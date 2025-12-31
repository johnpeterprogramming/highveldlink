<?php

namespace App\Http\Controllers;

use App\Events\BookingPaymentSuccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PayFast\PayFastPayment;
use App\Models\Booking;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;

/**
 * Handles PayFast payment gateway callbacks and booking payment redirects.
 *
 * This controller processes PayFast server-to-server notifications for booking
 * payments and displays the appropriate success or cancellation pages when a
 * user is redirected back from the PayFast payment flow.
 *
 * Notify route is used to verify payments to the server before payfast redirects
 * Cancel and Success routes are obvious
*/
class PaymentController extends Controller
{
    public function notify(Request $request)
    {
        try {
            // Initialize PayFast
            $payfast = new PayFastPayment([
                'merchantId'  => config('payfast.merchant_id'),
                'merchantKey' => config('payfast.merchant_key'),
                'passPhrase'  => config('payfast.passphrase'),
                'testMode'    => config('payfast.testing', true)
            ]);

            // Get the booking to verify amount
            $bookingId = $request->input('m_payment_id');
            $booking = Booking::findOrFail($bookingId);

            // Validate the notification
            // Pass the expected amount to verify it matches
            $notification = $payfast->notification->isValidNotification(
                $request->all(),
                ['amount_gross' => number_format($booking->grand_total, 2, '.', '')]
            );

            if ($notification === true) {
                // Notification is valid
                Log::channel('payments')->info('Valid PayFast notification received', [
                    'booking_id' => $bookingId,
                    'payment_status' => $request->input('payment_status')
                ]);

                // Check payment status
                if ($request->input('payment_status') === 'COMPLETE') {
                    // Update booking status
                    $booking->update([
                        'status' => 'paid',
                        'payment_date_time' => now(),
                        'pf_payment_id' => $request->input('pf_payment_id'),
                    ]);

                    Log::channel('payments')->info('Payment completed for booking', ['id' => $bookingId]);

                    // Triggers the following:
                    // - Notification to user to confirm the booking
                    // - Notification to admin
                    // - Logs transaction in Google sheets
                    event(new BookingPaymentSuccess($booking));

                // payment_status == CANCELLED case isn't handled, because that is specifically for subscriptions
                }

                return response('OK', 200);
            } else {
                // Invalid notification
                Log::error('Invalid PayFast notification', [
                    'data' => $request->all(),
                    'validation_result' => $notification
                ]);

                return response('Invalid notification', 400);
            }

        } catch (\Exception $e) {
            Log::error('PayFast notification error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response('Error processing notification', 500);
        }
    }

    // User returned from PayFast using a temporary signed url
    public function success($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        return view('payment.success', ['booking' => $booking]);
    }

    // User cancelled payment
    public function cancel(Request $request)
    {
        return view('payment.cancel');
    }
}
