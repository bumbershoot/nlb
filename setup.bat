@echo off
echo =================================
echo   Booking Resort Setup Script
echo =================================
echo.

echo Step 1: Generating Application Key...
php artisan key:generate

echo.
echo Step 2: Creating Database...
php artisan migrate

echo.
echo Step 3: Seeding Sample Data...
php artisan db:seed

echo.
echo Step 4: Creating Storage Link...
php artisan storage:link

echo.
echo Step 5: Clearing Cache...
php artisan config:clear
php artisan cache:clear
php artisan view:clear

echo.
echo =================================
echo   Setup Complete!
echo =================================
echo.
echo Your booking resort system is ready!
echo.
echo Next steps:
echo 1. Update your .env file with ToyyibPay credentials
echo 2. Start the development server: php artisan serve
echo 3. Visit: http://localhost:8000
echo.
pause
