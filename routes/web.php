<?php

use App\Http\Controllers\PaymentController;
use App\Livewire\Book;
use App\Livewire\BookingPayment;
use App\Livewire\BookingSuccess;
use App\Livewire\BookingConfirm;
use App\Livewire\BookingPaymentCallback;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/terms-and-conditions', function() {
    return view('terms-and-conditions');
})->name('terms-and-conditions');

Route::get('/privacy-policy', function() {
    return view('privacy-policy');
})->name('privacy-policy');

// Bookings
Route::get('/book', Book::class)->name('book');

Route::middleware(['booking-has-session-data'])->group(function() {
    Route::get('/book/confirm', BookingConfirm::class)->name('booking.confirm');
});

// Payfast
Route::post('/payment/notify', [PaymentController::class, 'notify'])
    ->name('payment.notify')
    ->withoutMiddleware([VerifyCsrfToken::class])
    ->middleware(function ($request, $next) {
        // Validate that the request comes from PayFast's known domains
        // PayFast webhooks come from: www.payfast.co.za, sandbox.payfast.co.za, w1w.payfast.co.za, w2w.payfast.co.za
        $allowedHosts = [
            'www.payfast.co.za',
            'sandbox.payfast.co.za',
            'w1w.payfast.co.za',
            'w2w.payfast.co.za',
        ];

        // Get client IP and perform reverse DNS lookup
        $clientIp = $request->ip();
        $clientHost = gethostbyaddr($clientIp);
        
        // Validate that reverse DNS lookup succeeded (it returns the IP if it fails)
        if ($clientHost === $clientIp || $clientHost === false) {
            abort(403, 'Unauthorized webhook source domain.');
        }
        
        // Validate domain by exact match only (prevents subdomain spoofing)
        if (!in_array($clientHost, $allowedHosts, true)) {
            abort(403, 'Unauthorized webhook source domain.');
        }

        return $next($request);
    });
Route::get('/payment/success/{booking_id}', [PaymentController::class, 'success'])
    ->name('payment.success')
    ->middleware('signed:relative');
Route::get('/payment/cancel', [PaymentController::class, 'cancel'])
    ->name('payment.cancel');


// Dashboard
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

require __DIR__.'/auth.php';
