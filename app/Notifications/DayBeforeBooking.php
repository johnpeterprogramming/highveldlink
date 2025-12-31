<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Shipper\WinSMS\WinSMSChannel;
use Shipper\WinSMS\WinSMSMessage;

class DayBeforeBooking extends Notification
{
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
        return ['mail', WinSMSChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting("Hi {$notifiable->name},")
            ->line("We are leaving {$this->booking->departureAddress->name} tomorrow at {$this->booking->departureTime()->toTimeString()}.")
            ->line("Please be there 30 minutes before hand.");
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
        $content .= "We are leaving {$this->booking->departureAddress->name} tomorrow at {$this->booking->departureTime()->toTimeString()}.";
        $content .= "Please be there 30 minutes before hand.";

        return (new WinSMSMessage())
            ->to($notifiable->phone)
            ->content($content);
    }
}
