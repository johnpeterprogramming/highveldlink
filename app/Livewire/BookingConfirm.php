<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Models\Address;
use App\Models\Booking;
use App\Models\PathPricing;
use App\Models\Route;
use App\Models\User;
use App\Models\Upsell;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Notifications\BookingPaid;

#[Layout('components.layouts.marketing')]
class BookingConfirm extends Component
{
    // User details
    public string $name = "";
    public string $email = "";
    public string $phone = "";

    // Route info
    public float $basePrice = 0;
    public float $price = 0;
    public bool $directDropoff = false;
    public bool $wifi = false;

    public $booking_data = [];

    public function mount()
    {

        $this->booking_data = session('pending_booking');
        $this->basePrice = PathPricing::where('route_id', $this->booking_data['route_id'])
            ->where('departure_address_id', $this->booking_data['departure_address_id'])
            ->where('arrival_address_id', $this->booking_data['arrival_address_id'])
            ->first()
            ->price;

        $this->price = $this->basePrice;

        // Prefill user details if user is logged in
        if (Auth::check()) {
            $user = Auth::user();

            $this->name = $user->name;
            $this->email = $user->email;
            $this->phone = $user->phone;
        }
    }

    public function render()
    {
        $this->price = $this->basePrice;
        if ($this->directDropoff)
            $this->price += $this->directDropoffUpsell->price;
        if ($this->wifi)
            $this->price += $this->wifiUpsell->price;

        // payment-allowed middleware ensures pending_booking exists
        return view('livewire.booking-confirm');
    }

    public function confirmBooking()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:10', 'min:10'], // TODO: add advanced validation for phone numbers
        ]);

        // Make guest user if user isn't logged in
        if (!Auth::check()) {
            $user = User::firstOrCreate(
                ['email' => $validated['email']],
                [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'is_guest' => true,
            ]);
        } else
            $user = Auth::user();

        $booking = Booking::create([
            'route_id' => $this->booking_data['route_id'],
            'departure_address_id' => $this->booking_data['departure_address_id'],
            'arrival_address_id' => $this->booking_data['arrival_address_id'],
            'booking_type' => $this->booking_data['booking_type'],
            'user_id' => $user->id,
            'status' => 'confirmed',
            'date' => $this->booking_data['date'],
            'base_route_total' => $this->basePrice,
            'upsells_total' => $this->price - $this->basePrice,
            'grand_total' => $this->price,
        ]);

        // Connect upsells to booking through pivot table
        if ($this->wifi)
            $booking->upsells()->attach($this->wifiUpsell->id, [
                'price' => $this->wifiUpsell->price
            ]);

        if ($this->directDropoff)
            $booking->upsells()->attach($this->directDropoffUpsell->id, [
                'price' => $this->directDropoffUpsell->price
            ]);

        $user->notify(new BookingPaid($booking));

        // Clear session data about booking
        session()->forget('pending_booking');

        // Go straight to redirect link - TODO: use payfast link
        $this->redirectRoute('booking.success', ['booking' => $booking], navigate: true);
    }

    // Computed Properties
    #[Computed]
    public function wifiUpsell()
    {
        return Upsell::where('slug', 'uncapped-wifi')->first();
    }

    #[Computed]
    public function directDropoffUpsell()
    {
        return Upsell::where('slug', 'direct-dropoff')->first();
    }

    #[Computed]
    public function getArrivalAddressProperty()
    {
        return Address::find($this->booking_data['arrival_address_id']);
    }

    #[Computed]
    public function getDepartureAddressProperty()
    {
        return Address::find($this->booking_data['departure_address_id']);
    }

    #[Computed]
    public function getArrivalTimeProperty()
    {
        $route = Route::find($this->booking_data['route_id']);
        $arrivalTime = $route->getArrivalTime($this->booking_data['arrival_address_id']);
        return $arrivalTime->format('h:i A');
    }

    #[Computed]
    public function getDepartureTimeProperty()
    {
        $route = Route::find($this->booking_data['route_id']);
        $departureTime = $route->getArrivalTime($this->booking_data['departure_address_id']);
        return $departureTime->format('h:i A');
    }

    public function getDateProperty() {
        return $this->booking_data['date'];
    }
}
