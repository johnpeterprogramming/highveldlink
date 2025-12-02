<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Booking;

#[Layout('components.layouts.marketing')]
class BookingSuccess extends Component
{
    public Booking $booking;

    public function render()
    {
        return view('livewire.booking-success');
    }
}
