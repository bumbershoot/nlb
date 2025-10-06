<?php

namespace App\Services;

use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class GoogleCalendarService
{
    private $client;
    private $service;
    private $calendarId;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setApplicationName(config('app.name') . ' - Resort Booking');
        $this->client->setScopes([Google_Service_Calendar::CALENDAR]);
        $this->client->setAuthConfig(config('services.google.calendar.credentials_path'));
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');

        // Handle SSL issues in development
        if (config('app.env') === 'local') {
            $guzzleClient = new \GuzzleHttp\Client([
                'verify' => false // Disable SSL verification for local development
            ]);
            $this->client->setHttpClient($guzzleClient);
        }

        $this->service = new Google_Service_Calendar($this->client);
        $this->calendarId = config('services.google.calendar.calendar_id', 'primary');
        
        // If calendar ID is still 'primary', use the correct one
        if ($this->calendarId === 'primary') {
            $this->calendarId = '64bf81a3e044a8af9e7b1793485ae8b4dfe57a01eff9ab5852ac7f25dac19d2c@group.calendar.google.com';
        }
    }

    /**
     * Create a calendar event for a confirmed booking
     */
    public function createBookingEvent(Booking $booking)
    {
        try {
            // Only create events for confirmed bookings
            if ($booking->status !== 'confirmed') {
                Log::info('Skipping calendar event creation - booking not confirmed', [
                    'booking_id' => $booking->id,
                    'status' => $booking->status
                ]);
                return null;
            }

            $event = new Google_Service_Calendar_Event([
                'summary' => $this->getEventTitle($booking),
                'description' => $this->getEventDescription($booking),
                'start' => new Google_Service_Calendar_EventDateTime([
                    'dateTime' => Carbon::parse($booking->date_from . ' ' . ($booking->check_in_time ?: '15:00:00'))->toRfc3339String(),
                    'timeZone' => config('app.timezone', 'Asia/Kuala_Lumpur'),
                ]),
                'end' => new Google_Service_Calendar_EventDateTime([
                    'dateTime' => Carbon::parse($booking->date_to . ' ' . ($booking->check_out_time ?: '11:00:00'))->toRfc3339String(),
                    'timeZone' => config('app.timezone', 'Asia/Kuala_Lumpur'),
                ]),
                'colorId' => $this->getColorForStatus($booking->status),
                'extendedProperties' => [
                    'private' => [
                        'booking_id' => $booking->id,
                        'cabana_id' => $booking->cabana_id,
                        'total_price' => $booking->total_price,
                        'pax' => $booking->pax,
                    ]
                ]
            ]);

            $createdEvent = $this->service->events->insert($this->calendarId, $event);
            
            // Update booking with calendar event ID
            $booking->update([
                'google_calendar_event_id' => $createdEvent->getId(),
                'calendar_synced_at' => now()
            ]);

            Log::info('Google Calendar event created successfully', [
                'booking_id' => $booking->id,
                'event_id' => $createdEvent->getId(),
                'customer' => $booking->name,
                'cabana' => $booking->cabana->name ?? 'Unknown'
            ]);

            return $createdEvent;
        } catch (\Exception $e) {
            Log::error('Failed to create Google Calendar event', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Update a calendar event for a booking
     */
    public function updateBookingEvent(Booking $booking)
    {
        if (!$booking->google_calendar_event_id) {
            return $this->createBookingEvent($booking);
        }

        try {
            $event = $this->service->events->get($this->calendarId, $booking->google_calendar_event_id);
            
            $event->setSummary($this->getEventTitle($booking));
            $event->setDescription($this->getEventDescription($booking));
            $event->setColorId($this->getColorForStatus($booking->status));
            
            // Update dates and times
            $start = new Google_Service_Calendar_EventDateTime([
                'dateTime' => Carbon::parse($booking->date_from . ' ' . ($booking->check_in_time ?: '15:00:00'))->toRfc3339String(),
                'timeZone' => config('app.timezone', 'Asia/Kuala_Lumpur'),
            ]);
            $end = new Google_Service_Calendar_EventDateTime([
                'dateTime' => Carbon::parse($booking->date_to . ' ' . ($booking->check_out_time ?: '11:00:00'))->toRfc3339String(),
                'timeZone' => config('app.timezone', 'Asia/Kuala_Lumpur'),
            ]);
            
            $event->setStart($start);
            $event->setEnd($end);

            $updatedEvent = $this->service->events->update($this->calendarId, $event->getId(), $event);
            
            $booking->update(['calendar_synced_at' => now()]);

            Log::info('Google Calendar event updated successfully', [
                'booking_id' => $booking->id,
                'event_id' => $updatedEvent->getId()
            ]);

            return $updatedEvent;
        } catch (\Exception $e) {
            Log::error('Failed to update Google Calendar event', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Delete a calendar event for a booking
     */
    public function deleteBookingEvent(Booking $booking)
    {
        if (!$booking->google_calendar_event_id) {
            return false;
        }

        try {
            $this->service->events->delete($this->calendarId, $booking->google_calendar_event_id);
            
            $booking->update([
                'google_calendar_event_id' => null,
                'calendar_synced_at' => now()
            ]);

            Log::info('Google Calendar event deleted successfully', [
                'booking_id' => $booking->id
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to delete Google Calendar event', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Generate event title for booking
     */
    private function getEventTitle(Booking $booking)
    {
        $cabanaName = $booking->cabana ? $booking->cabana->name : 'Cabana';
        return "🏨 {$cabanaName} - {$booking->name} ({$booking->pax} pax)";
    }

    /**
     * Generate event description for booking
     */
    private function getEventDescription(Booking $booking)
    {
        $cabanaName = $booking->cabana ? $booking->cabana->name : 'Cabana';
        $description = "🏨 Resort Booking Details\n\n";
        $description .= "📍 Cabana: {$cabanaName}\n";
        $description .= "👤 Guest: {$booking->name}\n";
        $description .= "📞 Phone: {$booking->phone}\n";
        $description .= "📧 Email: {$booking->email}\n";
        $description .= "👥 Guests: {$booking->pax} pax\n";
        $description .= "💰 Total: RM " . number_format($booking->total_price, 2) . "\n";
        $description .= "📅 Check-in: {$booking->date_from} at " . Carbon::parse($booking->check_in_time ?: '15:00:00')->format('g:i A') . "\n";
        $description .= "📅 Check-out: {$booking->date_to} at " . Carbon::parse($booking->check_out_time ?: '11:00:00')->format('g:i A') . "\n";
        $description .= "🔖 Status: " . ucfirst($booking->status) . "\n\n";
        $description .= "📋 Booking ID: #{$booking->id}\n";
        $description .= "🏖️ Nur Laman Bestari Eco Resort";
        
        return $description;
    }

    /**
     * Get color ID for booking status
     */
    private function getColorForStatus($status)
    {
        $colors = [
            'pending' => '5',     // Yellow
            'confirmed' => '10',  // Green
            'cancelled' => '4',   // Red
            'completed' => '7',   // Blue
        ];

        return $colors[$status] ?? '10'; // Default to green for confirmed
    }

    /**
     * Check if the service is properly configured
     */
    public function isConfigured()
    {
        return config('services.google.calendar.credentials_path') && 
               file_exists(config('services.google.calendar.credentials_path'));
    }

    /**
     * Test the calendar connection
     */
    public function testConnection()
    {
        try {
            // Try to get calendar info
            $calendar = $this->service->calendars->get($this->calendarId);
            return [
                'success' => true,
                'calendar_name' => $calendar->getSummary(),
                'calendar_id' => $calendar->getId()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
