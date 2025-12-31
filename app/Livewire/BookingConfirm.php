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
use Illuminate\Support\Facades\Auth;
use PayFast\PayFastPayment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

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

    // Booking/Payfast
    public $booking_data = [];
    public $payFastForm = null;
    public $showPayFastForm = false;

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

        return view('livewire.booking-confirm');
    }

    public function confirmBooking()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:11', 'min:10'], // TODO: add advanced validation for phone numbers
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
            'status' => 'awaiting-payment',
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

        $data = [
            // Merchant details
            // Generate temporary url for success page - so I can avoid implementing access control for guest users, or making use of access tokens
            'return_url'    => URL::temporarySignedRoute('payment.success', now()->addMinutes(45), ['booking_id' => $booking->id], true),
            'cancel_url'    => route('payment.cancel'),
            'notify_url'    => route('payment.notify'),

            // Buyer details
            'name_first'    => $this->name,
            'email_address' => $this->email,
            'cell_number' => $this->phone,

            // Transaction details
            'm_payment_id'  => (string) $booking->id,
            'amount'        => number_format($this->price, 2, '.', ''),
            'item_name'     => 'Booking#' . $booking->id,
            'item_description' => 'wifi:' . ($this->wifi ? 'yes' : 'no') . ';direct-dropoff:' . ($this->directDropoff ? 'yes' : 'no'),
        ];

        $payFastPayment = new PayFastPayment([
            'merchantId' => config('payfast.merchant_id'),
            'merchantKey' => config('payfast.merchant_key'),
            'passPhrase' => config('payfast.passphrase'),
            'testMode' => config('payfast.testing', true)
        ]);

        $htmlForm = $payFastPayment->custom->createFormFields($data, ['value' => 'Continue To Payment', 'class' => 'w-full py-3 text-lg']);

        // Set payfast-form as the id to the form
        if (!str_contains($htmlForm, 'id="payfast-form"')) {
            $htmlForm = preg_replace('/<form\b/', '<form id="payfast-form"', $htmlForm, 1) ?? $htmlForm;
        }

        // Get the HTML form
        $this->payFastForm = $htmlForm;
        $this->showPayFastForm = true;
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
