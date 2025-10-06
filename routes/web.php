<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\CabanaController;
use App\Http\Controllers\AmenityController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\EinvoiceController;

// Static Pages
Route::view('/about', 'pages.about')->name('about');
Route::view('/locations', 'pages.locations')->name('locations');
Route::view('/contact', 'pages.contact')->name('contact');

// Public Booking Routes (No authentication required)
Route::get('/booking-form', [BookingController::class, 'bookingForm'])->name('booking.form');
Route::get('/amenity-booking-form', [BookingController::class, 'amenityBookingForm'])->name('amenity.booking.form');
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');


Route::redirect('/', '/cabanas')->name('home');
Route::get('/cabanas', [CabanaController::class, 'index'])->name('cabanas.index');
Route::get('/cabana/{cabana:slug}', [CabanaController::class, 'show'])->name('cabanas.show');

// Amenity routes
Route::get('/amenities', [AmenityController::class, 'index'])->name('amenities.index');
Route::get('/amenity/{amenity:slug}', [AmenityController::class, 'show'])->name('amenities.show');

// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Auth\AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\AdminAuthController::class, 'login']);
    Route::get('/register', [\App\Http\Controllers\Auth\AdminAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [\App\Http\Controllers\Auth\AdminAuthController::class, 'register']);
    Route::post('/logout', [\App\Http\Controllers\Auth\AdminAuthController::class, 'logout'])->name('logout');
});

// Alternative discrete admin access
Route::get('/staff', function () {
    return redirect()->route('admin.login');
})->name('staff.login');

// Customer Authentication Routes
Route::prefix('customer')->name('customer.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Auth\CustomerAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\CustomerAuthController::class, 'login']);
    Route::get('/register', [\App\Http\Controllers\Auth\CustomerAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [\App\Http\Controllers\Auth\CustomerAuthController::class, 'register']);
    Route::post('/logout', [\App\Http\Controllers\Auth\CustomerAuthController::class, 'logout'])->name('logout');
});

// Legacy routes (redirect to customer routes)
Route::get('/login', function () {
    return redirect()->route('customer.login');
})->name('login');

Route::get('/register', function () {
    return redirect()->route('customer.register');
})->name('register');

// Customer Routes (Authenticated users)
Route::middleware(['auth'])->group(function () {
    // Customer booking management
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('bookings.index');
    
    // Payment routes (customers)
    Route::post('/bookings/{booking}/payment', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/{payment}/fpx', [PaymentController::class, 'processFPX'])->name('payments.fpx.process');
    Route::get('/payments/{payment}/toyyibpay', [PaymentController::class, 'processToyyibPay'])->name('payments.toyyibpay.process');
    Route::get('/payments/{payment}/bank-transfer', [PaymentController::class, 'bankTransferInstructions'])->name('payments.bank-transfer.instructions');
    Route::get('/payments/{payment}/cash', [PaymentController::class, 'cashInstructions'])->name('payments.cash.instructions');
    Route::post('/payments/{payment}/confirm-manual', [PaymentController::class, 'confirmManual'])->name('payments.confirm.manual');
});

// Admin Routes (Resort Owners/Managers)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    
    // Booking Management
    Route::get('/bookings', [\App\Http\Controllers\AdminController::class, 'bookings'])->name('bookings.index');
    Route::get('/bookings/{booking}', [\App\Http\Controllers\AdminController::class, 'showBooking'])->name('bookings.show');
    Route::patch('/bookings/{booking}/status', [\App\Http\Controllers\AdminController::class, 'updateBookingStatus'])->name('bookings.update-status');
    
    // Customer Management
    Route::get('/customers', [\App\Http\Controllers\AdminController::class, 'customers'])->name('customers.index');
    
    // Payment Management
    Route::get('/payments', [\App\Http\Controllers\AdminController::class, 'payments'])->name('payments.index');
    
    // Cabana Management
    Route::get('/cabanas', [\App\Http\Controllers\AdminController::class, 'cabanas'])->name('cabanas.index');
    Route::resource('cabanas', \App\Http\Controllers\Admin\CabanaController::class)->except(['index']);
    
    
    // E-invoice routes (admin only)
    Route::get('/einvoices', [EinvoiceController::class, 'index'])->name('einvoices.index');
    Route::post('/einvoices/{invoice}/submit', [EinvoiceController::class, 'submit'])->name('einvoices.submit');
    Route::post('/einvoices/{invoice}/check-status', [EinvoiceController::class, 'checkStatus'])->name('einvoices.check-status');
    Route::post('/einvoices/{invoice}/generate-pdf', [EinvoiceController::class, 'generatePDF'])->name('einvoices.generate-pdf');
    Route::get('/einvoices/{invoice}/download-pdf', [EinvoiceController::class, 'downloadPDF'])->name('einvoices.download-pdf');
    Route::post('/einvoices/bulk-submit', [EinvoiceController::class, 'bulkSubmit'])->name('einvoices.bulk-submit');
    Route::get('/einvoices/statistics', [EinvoiceController::class, 'statistics'])->name('einvoices.statistics');
});


// Public webhook routes (no auth required)
Route::post('/webhooks/{gateway}', [PaymentController::class, 'webhook'])->name('payments.webhook');

// Legacy logout route (redirects based on user role)
Route::post('/logout', function (Request $request) {
    $isAdmin = Auth::user() ? Auth::user()->isAdmin() : false;
    
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    if ($isAdmin) {
        return redirect()->route('admin.login')->with('success', 'Logged out successfully');
    } else {
        return redirect('/')->with('success', 'Logged out successfully');
    }
})->name('logout');
