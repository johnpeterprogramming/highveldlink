<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Address;
use App\Models\PathPricing;
use App\Models\Route;
use Carbon\Carbon;

#[Layout('components.layouts.marketing')]
class BookingConfirm extends Component
{
    public float $basePrice = 0;
    public float $price = 0;
    public bool $directDropoff = false;
    public bool $wifi = false;

    public $booking_data = [];

    protected float $directDropoffPrice = 60.00;
    protected float $wifiPrice = 30.00;

    public function mount()
    {
        $this->booking_data = session('pending_booking');
        $this->basePrice = PathPricing::where('route_id', $this->booking_data['route_id'])
            ->where('departure_address_id', $this->booking_data['departure_address_id'])
            ->where('arrival_address_id', $this->booking_data['arrival_address_id'])
            ->first()
            ->price;

        $this->price = $this->basePrice;
    }

    public function render()
    {
        $this->price = $this->basePrice;
        if ($this->directDropoff)

            $this->price += $this->directDropoffPrice;
        if ($this->wifi)
            $this->price += $this->wifiPrice;

        // payment-allowed middleware ensures pending_booking exists
        return view('livewire.booking-confirm');
    }
    /**/
    /* public function updatePrice() */
    /* { */
    /*     \Log::info("Price has been updated"); */
    /*     if ($this->directDropoff) */
    /*         $this->price = $this->basePrice + $this->directDropoffPrice; */
    /* } */


    public function getArrivalAddressProperty()
    {
        return Address::find($this->booking_data['arrival_address_id']);
    }

    public function getDepartureAddressProperty()
    {
        return Address::find($this->booking_data['departure_address_id']);
    }

    public function getArrivalTimeProperty()
    {
        $route = Route::find($this->booking_data['route_id']);
        $arrivalTime = $route->getArrivalTime($this->booking_data['arrival_address_id']);
        return $arrivalTime->format('h:i A');
    }

    public function getDepartureTimeProperty()
    {
        $route = Route::find($this->booking_data['route_id']);
        $departureTime = $route->getArrivalTime($this->booking_data['departure_address_id']);
        return $departureTime->format('h:i A');
    }
}
