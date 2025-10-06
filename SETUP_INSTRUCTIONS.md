# 🏨 Booking Resort Setup Instructions

## Quick Start

1. **Run the setup script:**
   ```bash
   setup.bat
   ```

2. **Start the development server:**
   ```bash
   php artisan serve
   ```

3. **Visit your application:**
   ```
   http://localhost:8000
   ```

## Manual Setup (Alternative)

### 1. Database Setup
```bash
# Create database migrations
php artisan migrate

# Seed sample data
php artisan db:seed

# Create storage link
php artisan storage:link
```

### 2. Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## ToyyibPay Configuration

### 1. Create ToyyibPay Account
- Visit: https://toyyibpay.com
- Click "Register" 
- Choose "Merchant Account"
- Complete business verification

### 2. Get API Credentials
1. Login to ToyyibPay dashboard
2. Go to "Settings" → "API Settings"
3. Copy your **User Secret Key**
4. Create a new category and get the **Category Code**

### 3. Update .env File
Replace the placeholder values in your `.env` file:

```env
# ToyyibPay Configuration
TOYYIBPAY_USER_SECRET_KEY=your_actual_secret_key_here
TOYYIBPAY_CATEGORY_CODE=your_actual_category_code_here
TOYYIBPAY_MODE=sandbox
TOYYIBPAY_WEBHOOK_SECRET=your_webhook_secret_here
```

### 4. Configure Webhook
- In ToyyibPay dashboard, go to "Webhook Settings"
- Set webhook URL: `https://yourdomain.com/webhooks/toyyibpay`
- Generate and save webhook secret

## Testing the System

### 1. Create a Test Booking
1. Visit `/cabanas` to see available cabanas
2. Click on a cabana to view details
3. Click "Book Now" and fill the form
4. Select ToyyibPay as payment method

### 2. Test Payment Flow
- **Sandbox Mode**: Use test credentials (no real money)
- **Test Cards**: Use ToyyibPay's test card numbers
- **Test Banks**: Use sandbox banking credentials

## Database Structure

Your system includes these tables:
- `users` - Customer accounts
- `cabanas` - Resort cabanas/rooms
- `bookings` - Customer bookings
- `payments` - Payment records
- `invoices` - Invoice generation

## Payment Methods Available

1. **🟡 ToyyibPay** (Primary)
   - Online Banking (FPX)
   - Credit/Debit Cards
   - E-Wallets (GrabPay, Boost, TouchNGo)

2. **🏦 Bank Transfer**
   - Manual verification
   - Multiple bank options
   - Receipt upload

3. **💵 Cash Payment**
   - Pay on arrival
   - Booking confirmation

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   ```bash
   # Check database settings in .env
   # Ensure MySQL/MariaDB is running
   # Verify database name exists
   ```

2. **ToyyibPay API Error**
   ```bash
   # Check API credentials in .env
   # Verify sandbox/production mode
   # Check webhook URL configuration
   ```

3. **Permission Issues**
   ```bash
   # Set proper folder permissions
   chmod -R 755 storage/
   chmod -R 755 bootstrap/cache/
   ```

## Production Deployment

### 1. Environment
```env
APP_ENV=production
APP_DEBUG=false
TOYYIBPAY_MODE=production
```

### 2. Security
- Use HTTPS for webhook URLs
- Set strong webhook secrets
- Enable CSRF protection
- Configure proper file permissions

### 3. Performance
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

## Support

- **ToyyibPay Support**: support@toyyibpay.com
- **Documentation**: https://toyyibpay.com/apidoc/
- **Phone**: +603-2775 6505

## Next Steps

1. ✅ Complete ToyyibPay registration
2. ✅ Get API credentials
3. ✅ Update .env configuration
4. ✅ Test payment flow
5. ✅ Configure webhook
6. ✅ Go live with production credentials

Your booking resort system is now ready for Malaysian customers! 🇲🇾
