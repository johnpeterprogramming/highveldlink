<?php

namespace App\Listeners;

use App\Events\BookingPaymentSuccess;
use App\Notifications\BookingPaidUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendBookingProofOfPaymentToUser implements ShouldQueue
{
    use InteractsWithQueue;

    public $tries = 2;
    public $backoff = [30];

    /**
     * Handle the event.
     */
    public function handle(BookingPaymentSuccess $event): void
    {
        $booking = $event->booking;
        $booking->user->notify(new BookingPaidUser($booking));
    }

    public function failed(BookingPaymentSuccess $event, \Throwable $exception): void
    {
        $booking = $event->booking;

        Log::error('Failed to send booking payment notification to user', [
            'booking_id' => $booking->id,
            'user_id' => $booking->user_id,
            'attempts' => $this->attempts(),
            'error' => $exception->getMessage()
        ]);

        // Notify developer
        $devEmail = config('mail.dev');
        if ($devEmail) {
            try {
                $mailMessage = (new MailMessage())
                        ->error()
                        ->subject('🚨 User Booking Notification Failed')
                        ->line("Failed to send booking payment notification to user.")
                        ->line("**Booking ID:** {$booking->id}")
                        ->line("**User ID:** " . $booking->user_id)
                        ->line("**Error:** {$exception->getMessage()}")
                        ->line("**Attempts:** {$this->attempts()}");
                        /* ->action('View Booking', url("/admin/bookings/{$booking->id}"))); */
                        // TODO: Configure admin dashboard bookings view

                Notification::route('mail', $devEmail)
                    ->notify($mailMessage);

            } catch (\Throwable $e) {
                Log::critical('Could not notify developer of failed job', [
                    'booking_id' => $booking->id,
                    'dev_email' => $devEmail,
                    'original_error' => $exception->getMessage(),
                    'notification_error' => $e->getMessage()
                ]);
            }
        } else {
            Log::critical('Failed job notification could not be sent - no dev email configured', [
                'booking_id' => $booking->id,
                'error' => $exception->getMessage()
            ]);
        }
    }
}
