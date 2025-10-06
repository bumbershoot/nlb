# ToyyibPay Setup Guide

## Overview
ToyyibPay is Malaysia's trusted payment gateway that supports:
- Online Banking (FPX) - All major Malaysian banks
- Credit/Debit Cards (Visa, Mastercard)
- E-Wallets (GrabPay, Boost, TouchNGo)

## Environment Configuration

Add these variables to your `.env` file:

```env
# ToyyibPay Configuration
TOYYIBPAY_USER_SECRET_KEY=your_user_secret_key_here
TOYYIBPAY_CATEGORY_CODE=your_category_code_here
TOYYIBPAY_MODE=sandbox
TOYYIBPAY_WEBHOOK_SECRET=your_webhook_secret_here
```

## Getting Started with ToyyibPay

### 1. Create ToyyibPay Account
- Visit: https://toyyibpay.com
- Register for a merchant account
- Complete business verification

### 2. Get API Credentials
- Login to ToyyibPay dashboard
- Navigate to "API Settings"
- Copy your `User Secret Key`
- Create a new category and get the `Category Code`

### 3. Configure Webhook
- Set webhook URL to: `https://yourdomain.com/webhooks/toyyibpay`
- Generate a webhook secret key
- Add it to your environment configuration

### 4. Test Mode
- Use `sandbox` mode for testing
- Switch to `production` for live transactions

## Features Implemented

### Payment Methods
- **ToyyibPay Online** - Redirects to ToyyibPay payment page
- **Bank Transfer** - Manual bank transfer with instructions
- **Cash Payment** - Pay upon arrival

### Payment Flow
1. Customer selects ToyyibPay payment method
2. System creates payment record and ToyyibPay bill
3. Customer redirected to ToyyibPay payment page
4. Customer completes payment using preferred method
5. ToyyibPay sends webhook notification
6. System automatically updates payment status
7. Booking confirmed upon successful payment

### Webhook Handling
- Automatic payment status updates
- Booking confirmation
- Failed payment handling

## Support
- ToyyibPay Documentation: https://toyyibpay.com/apidoc/
- Support Email: support@toyyibpay.com
- Phone: +603-2775 6505

## Testing
Use ToyyibPay's sandbox environment for testing:
- Test cards and bank accounts provided in their documentation
- No real money transactions in sandbox mode
