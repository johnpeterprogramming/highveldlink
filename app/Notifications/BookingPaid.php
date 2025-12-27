<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;
use Shipper\WinSMS\WinSMSChannel;
use Shipper\WinSMS\WinSMSMessage;

class BookingPaid extends Notification implements ShouldQueue
{
    use Queueable;

    private Booking $booking;
    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        if (config('app.debug'))
            return [];
        return [WinSMSChannel::class, 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->markdown('mail.booking-paid', ['booking' => $this->booking, 'notifiable' => $notifiable]);
    }

     /**
     * Send sms using WinSMS API
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toWinSMS($notifiable): WinSMSMessage
    {
        $content = "Hi {$notifiable->name}\n";
        $content .= "Your Booking on {$this->booking->date->toDateString()} from {$this->booking->departureAddress->name} to {$this->booking->arrivalAddress->name} has been created succesfully!\n";
        $content .= "Your pickup is at {$this->booking->departureTime()->toTimeString()}.\n\n";
        $content .= "Please arrive atleast 20 minutes before hand.";

        return (new WinSMSMessage())
            ->to($notifiable->phone)
            ->content($content);
    }

}
