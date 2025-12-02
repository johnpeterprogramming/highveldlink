<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Booking;
use App\Models\User;

#[Layout('components.layouts.marketing')]
class BookingPayment extends Component
{
    public function confirmPayment()
    {
        $bookingInfo = session('pending_booking');
        $booking = Booking::create([
            'route_id' => $bookingInfo['route_id'],
            'departure_address_id' => $bookingInfo['departure_address_id'],
            'arrival_address_id' => $bookingInfo['arrival_address_id'],
            'user_id' => Auth::user()?->id ?? User::inRandomOrder()->first()->id,
            'booking_type' => $bookingInfo['booking_type'],
            'status' => 'confirmed',
        ]);

        $this->redirectRoute('booking.success', ['booking' => $booking], navigate: true);
    }

    public function render()
    {
        return view('livewire.booking-payment');
    }
}
