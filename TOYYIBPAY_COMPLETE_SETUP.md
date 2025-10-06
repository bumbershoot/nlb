# 🚀 Complete ToyyibPay Setup Guide

Your ToyyibPay integration is now **FULLY IMPLEMENTED**! Here's everything you need to know to get it running.

## ✅ What's Been Implemented

### 🔧 Backend Services
- **ToyyibPayService** - Complete API integration with ToyyibPay
- **PaymentService** - Updated to support ToyyibPay payments
- **PaymentController** - Handles ToyyibPay payment requests
- **Webhook handling** - Automatic payment status updates

### 🎨 Frontend Views
- **ToyyibPay payment page** - Beautiful, functional payment interface
- **Payment status handling** - Success, failure, and retry states
- **Loading states** - Professional UX during payment processing

### ⚙️ Configuration
- **Services config** - ToyyibPay credentials management
- **Routes** - All payment and webhook routes configured
- **Validation** - Payment method validation updated

## 🛠️ Setup Instructions

### Step 1: Create ToyyibPay Account

1. **Visit**: https://toyyibpay.com
2. **Click**: "Register" → "Merchant Account"
3. **Complete**: Business verification process
4. **Wait**: For account approval (usually 1-2 business days)

### Step 2: Get API Credentials

1. **Login** to your ToyyibPay dashboard
2. **Navigate** to "Settings" → "API Settings"
3. **Copy** your **User Secret Key**
4. **Create** a new category:
   - Go to "Category" → "Add New Category"
   - Enter name: "Resort Bookings" (or similar)
   - **Copy** the **Category Code** generated

### Step 3: Configure Environment

Create/update your `.env` file with these settings:

```env
# ToyyibPay Configuration
TOYYIBPAY_USER_SECRET_KEY=your_actual_secret_key_here
TOYYIBPAY_CATEGORY_CODE=your_actual_category_code_here
TOYYIBPAY_MODE=sandbox
TOYYIBPAY_WEBHOOK_SECRET=your_webhook_secret_here
```

**Important Notes:**
- Replace `your_actual_secret_key_here` with your real ToyyibPay User Secret Key
- Replace `your_actual_category_code_here` with your real Category Code
- Use `sandbox` for testing, `production` for live payments
- Generate a strong webhook secret (e.g., `php artisan key:generate --show`)

### Step 4: Configure Webhook

1. **In ToyyibPay Dashboard**:
   - Go to "Webhook Settings"
   - Set webhook URL: `https://yourdomain.com/webhooks/toyyibpay`
   - Enter your webhook secret from `.env`
   - Save settings

2. **For Local Testing**:
   - Use ngrok: `ngrok http 8000`
   - Set webhook URL: `https://your-ngrok-url.ngrok.io/webhooks/toyyibpay`

### Step 5: Clear Caches

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

## 🧪 Testing the Integration

### Test Payment Flow

1. **Start your server**: `php artisan serve`
2. **Visit**: `http://localhost:8000/cabanas`
3. **Select a cabana** and click "Book Now"
4. **Fill booking form** with test data
5. **Choose "ToyyibPay"** as payment method
6. **Click "Pay with ToyyibPay"**

### Expected Behavior

✅ **Success Flow**:
1. Payment record created with status "pending"
2. ToyyibPay bill created via API
3. User redirected to ToyyibPay payment page
4. User completes payment
5. Webhook updates payment status to "paid"
6. Booking status updated to "confirmed"
7. Invoice automatically generated

❌ **Error Handling**:
- Invalid credentials → Clear error message
- Network issues → Retry functionality
- Payment failure → Status updated, retry option

## 🔧 Available Payment Methods

Your ToyyibPay integration supports:

- **🏦 Online Banking (FPX)**: All major Malaysian banks
- **💳 Credit/Debit Cards**: Visa, Mastercard

## 🎯 Payment Method Options

Users can now choose from:

1. **ToyyibPay** (Online Banking + Cards + E-Wallets)
2. **Bank Transfer** (Manual with instructions)
3. **Cash Payment** (Pay on arrival)

## 🐛 Troubleshooting

### Common Issues

**1. "Invalid credentials" error**
```bash
# Check your .env file
# Ensure TOYYIBPAY_USER_SECRET_KEY and TOYYIBPAY_CATEGORY_CODE are real values
# Clear config cache: php artisan config:clear
```

**2. "Webhook not receiving callbacks"**
```bash
# Check webhook URL is publicly accessible
# Verify webhook secret matches .env file
# Check ToyyibPay dashboard webhook settings
```

**3. "Payment not updating status"**
```bash
# Check Laravel logs: storage/logs/laravel.log
# Verify webhook URL is correct
# Test webhook manually with curl
```

### Debug Mode

Enable detailed logging by adding to your `.env`:
```env
APP_DEBUG=true
LOG_LEVEL=debug
```

## 📊 Monitoring

### Check Payment Status
```php
// In tinker or controller
$payment = Payment::find(1);
echo $payment->status; // pending, paid, failed
echo $payment->gateway_response; // Full ToyyibPay response
```

### View Logs
```bash
tail -f storage/logs/laravel.log
```

## 🚀 Going Live

### Production Checklist

1. **✅ Update Environment**:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   TOYYIBPAY_MODE=production
   ```

2. **✅ Get Production Credentials**:
   - Switch to production ToyyibPay account
   - Update User Secret Key and Category Code
   - Update webhook URL to production domain

3. **✅ Security**:
   - Use HTTPS for webhook URLs
   - Set strong webhook secrets
   - Enable Laravel security features

4. **✅ Performance**:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan optimize
   ```

## 📞 Support

- **ToyyibPay Support**: support@toyyibpay.com
- **Phone**: +603-2775 6505
- **Documentation**: https://toyyibpay.com/apidoc/

## 🎉 You're All Set!

Your booking resort system now has **complete ToyyibPay integration**! 

### Quick Start:
1. Add your ToyyibPay credentials to `.env`
2. Clear Laravel caches
3. Test a booking with ToyyibPay payment
4. Monitor logs for any issues
5. Go live when ready!

**Malaysian customers can now pay with their preferred method** - online banking, cards, or e-wallets! 🇲🇾✨
