<?php

namespace App\Listeners;

use App\Events\BookingPaymentSuccess;
use App\Models\User;
use App\Notifications\BookingPaidAdmin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendBookingProofOfPaymentToAdmin implements ShouldQueue
{
    use InteractsWithQueue;

    public $tries = 2;
    public $backoff = [30];

    public function handle(BookingPaymentSuccess $event): void
    {
        $booking = $event->booking;
        $adminEmail = config('mail.admin');

        if (!$adminEmail) {
            $this->fail(new \Exception('Admin email not configured in mail.admin'));
            return;
        }

        $adminUser = User::where('email', $adminEmail)->first();

        if (!$adminUser) {
            $this->fail(new \Exception("Admin user not found with email: {$adminEmail}"));
            return;
        }

        $adminUser->notify(new BookingPaidAdmin($booking));
    }

    public function failed(BookingPaymentSuccess $event, \Throwable $exception): void
    {
        $booking = $event->booking;

        Log::error('Failed to send booking payment notification to admin', [
            'booking_id' => $booking->id,
            'admin_email' => config('mail.admin'),
            'attempts' => $this->attempts(),
            'error' => $exception->getMessage()
        ]);

        // Notify developer
        $devEmail = config('mail.dev');
        if ($devEmail) {
            try {
                $mailMessage = (new MailMessage())
                        ->error()
                        ->subject('🚨 Admin Booking Notification Failed')
                        ->line("Failed to send booking payment notification to admin.")
                        ->line("**Booking ID:** {$booking->id}")
                        ->line("**Admin Email:** " . (config('mail.admin') ?: 'Not configured'))
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
