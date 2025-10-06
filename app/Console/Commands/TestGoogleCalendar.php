<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GoogleCalendarService;

class TestGoogleCalendar extends Command
{
    protected $signature = 'calendar:test';
    protected $description = 'Test Google Calendar integration';

    public function handle()
    {
        $this->info('🧪 Testing Google Calendar Integration...');
        $this->newLine();

        try {
            $calendarService = new GoogleCalendarService();
            
            $this->info('✅ GoogleCalendarService created successfully');
            
            // Test if service is configured
            if ($calendarService->isConfigured()) {
                $this->info('✅ Google Calendar credentials are properly configured');
            } else {
                $this->error('❌ Google Calendar credentials not found or invalid');
                $this->newLine();
                $this->warn('Setup required:');
                $this->line('1. Create Google Cloud project and enable Calendar API');
                $this->line('2. Create service account and download credentials JSON');
                $this->line('3. Place credentials file in: storage/app/google-calendar-credentials.json');
                $this->line('4. Set GOOGLE_CALENDAR_ID in .env file');
                return 1;
            }
            
            // Test connection
            $this->info('🔍 Testing calendar connection...');
            $result = $calendarService->testConnection();
            
            if ($result['success']) {
                $this->info('✅ Successfully connected to Google Calendar!');
                $this->line("📅 Calendar: {$result['calendar_name']}");
                $this->line("🔗 Calendar ID: {$result['calendar_id']}");
            } else {
                $this->error('❌ Failed to connect to Google Calendar');
                $this->line("Error: {$result['error']}");
                return 1;
            }
            
            $this->newLine();
            $this->info('🎉 Google Calendar integration test PASSED!');
            $this->newLine();
            $this->line('✅ Ready to sync confirmed bookings to Google Calendar');
            $this->line('✅ Calendar events will be created when bookings are confirmed');
            $this->line('✅ Events include cabana name, customer details, and booking times');
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('❌ Test FAILED: ' . $e->getMessage());
            $this->newLine();
            $this->warn('Troubleshooting:');
            $this->line('1. Check Google Calendar API credentials');
            $this->line('2. Verify calendar ID is correct');
            $this->line('3. Ensure service account has calendar access');
            $this->line('4. Check Laravel logs: storage/logs/laravel.log');
            
            return 1;
        }
    }
}