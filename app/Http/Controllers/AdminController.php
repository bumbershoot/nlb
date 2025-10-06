<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Cabana;
use App\Models\User;
use App\Services\GoogleCalendarService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Admin Dashboard
     */
    public function dashboard()
    {
        // Recent bookings
        $recentBookings = Booking::with(['cabana', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Monthly bookings
        $monthlyBookings = Booking::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->with(['cabana', 'user'])
            ->get();

        // Today's check-ins and check-outs
        $todayCheckIns = Booking::whereDate('date_from', today())
            ->with(['cabana', 'user'])
            ->get();

        $todayCheckOuts = Booking::whereDate('date_to', today())
            ->with(['cabana', 'user'])
            ->get();

        // Statistics
        $totalCustomers = User::where('role', 'customer')->count();
        $monthlyRevenue = Payment::where('status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        return view('admin.dashboard', compact(
            'recentBookings', 
            'monthlyBookings', 
            'todayCheckIns', 
            'todayCheckOuts',
            'totalCustomers',
            'monthlyRevenue'
        ));
    }

    /**
     * All Bookings Management
     */
    public function bookings(Request $request)
    {
        $query = Booking::with(['cabana', 'payment', 'user']);

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from !== '') {
            $query->whereDate('date_from', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to !== '') {
            $query->whereDate('date_to', '<=', $request->date_to);
        }

        // Search by customer name or email
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show specific booking details
     */
    public function showBooking(Booking $booking)
    {
        $booking->load(['cabana', 'payment', 'user']);
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Update booking status
     */
    public function updateBookingStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);

        $oldStatus = $booking->status;
        $booking->update(['status' => $request->status]);

        // Handle Google Calendar sync when booking is confirmed
        if (config('services.google.calendar.auto_sync', true)) {
            try {
                $calendarService = new GoogleCalendarService();
                
                // If booking is confirmed and wasn't confirmed before, create calendar event
                if ($request->status === 'confirmed' && $oldStatus !== 'confirmed') {
                    if ($calendarService->isConfigured()) {
                        $calendarService->createBookingEvent($booking);
                    }
                }
                // If booking was cancelled and had a calendar event, delete it
                elseif ($request->status === 'cancelled' && $booking->isCalendarSynced()) {
                    if ($calendarService->isConfigured()) {
                        $calendarService->deleteBookingEvent($booking);
                    }
                }
                // If booking was already confirmed and details might have changed, update it
                elseif ($request->status === 'confirmed' && $oldStatus === 'confirmed' && $booking->isCalendarSynced()) {
                    if ($calendarService->isConfigured()) {
                        $calendarService->updateBookingEvent($booking);
                    }
                }
            } catch (\Exception $e) {
                \Log::warning('Failed to sync booking status change to Google Calendar', [
                    'booking_id' => $booking->id,
                    'old_status' => $oldStatus,
                    'new_status' => $request->status,
                    'error' => $e->getMessage()
                ]);
                
                // Don't fail the status update if calendar sync fails
                return back()->with('warning', 'Booking status updated, but calendar sync failed: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Booking status updated successfully!');
    }

    /**
     * Customers Management
     */
    public function customers()
    {
        $customers = User::where('role', 'customer')
            ->withCount('bookings')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Payments Management
     */
    public function payments()
    {
        $payments = Payment::with(['booking.cabana', 'booking.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Cabanas Management
     */
    public function cabanas()
    {
        $cabanas = Cabana::withCount(['bookings'])
            ->orderBy('name')
            ->get();

        return view('admin.cabanas.index', compact('cabanas'));
    }


}