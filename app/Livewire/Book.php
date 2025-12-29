<?php

namespace App\Livewire;

use App\Models\AddressSegment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Validation\Rule;
use WireUi\Traits\WireUiActions;

use App\Models\Route;
use App\Models\User;
use App\Models\RoutePath;
use App\Models\Booking;
use App\Services\RouteHelper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

#[Layout('components.layouts.marketing')]
class Book extends Component
{
    use WireUiActions;

    const MAX_PASSENGERS_PER_SEGMENT = 4;

    // Address options
    public $departureAddresses;
    public $arrivalAddresses;

    // Membership
    public $showMembershipPanel;
    public $selectedMembership; // null unless booking type is membership

    // Form fields
    public $selectedDeparture = null;
    public $selectedArrival = null;
    public $date = null;

    public function rules()
    {
        return [
            'selectedDeparture' => ['required', Rule::in($this->departureAddresses->map(fn($item) => $item['value']))],
            'selectedArrival' => ['required', Rule::in($this->arrivalAddresses->map(fn($item) => $item['value']))],
            'date' => [
                'required',
                'date',
                'after:yesterday', // Can't time travel
                'before:' . now()->addMonths(2)->format('Y-m-d'), // Can't book more than 2 months in advance
                function($attribute, $value, $fail) { // Can currently only book for fridays and sundays
                    $dayOfWeek = Carbon::parse($value)->dayOfWeek;
                    if (!in_array($dayOfWeek, [0, 5])) { // 0=Sunday, 5=Friday
                        $fail('Please select a Friday or Sunday.');
                    }
                }
            ]
        ];
    }

    public function book()
    {
        $this->validate();

        // Extract id's from hypen delimited value
        [$routeId, $departureAddressId] = explode('-', $this->selectedDeparture);
        [, $arrivalAddressId] = explode('-', $this->selectedArrival);


        // Save booking info to session incase user isn't logged in yet
        session()->put('pending_booking', [
            'route_id' => $routeId,
            'departure_address_id' => $departureAddressId,
            'arrival_address_id' => $arrivalAddressId,
            'booking_type' => 'once-off', // TODO: change this when memberships are added
            'date' => $this->date,
        ]);

        $this->redirectRoute('booking.confirm', navigate: true);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    private function mapRouteToDepartureAddresses(Route $route): Collection
    {
        $excludedSegments = $this->getExcludedSegmentIds($route->id);
        /* Log::debug($excludedSegments); */

        return $route->routePaths
            ->filter(function (RoutePath $routePath) use ($excludedSegments) {
                return !$excludedSegments->contains($routePath->address_segment_id);
            })
            ->map(function (RoutePath $routePath) use ($route) {
            $startAddressId = $routePath->addressSegment->start_address_id;
            return [
                'value' => $route->id . '-' . $startAddressId,
                'name' => $routePath->addressSegment->startAddress->city,
                'description' => $route->getArrivalTime($startAddressId)?->format("H:i") ?? '',
            ];
        });
    }

    public function updatedDate($value) : void
    {
        $this->selectedDeparture = null;
        $this->selectedArrival = null;

        // When a date gets deselected
        if ($value == null) {
            $this->departureAddresses = collect();
            return;
        }

        $this->departureAddresses = Route::with([
            'routePaths',
            'routePaths.addressSegment',
            'routePaths.addressSegment.startAddress'])
            ->get()
            ->flatmap(fn(Route $route) => $this->mapRouteToDepartureAddresses($route));
    }

    public function updatedSelectedDeparture($value) : void
    {
        $this->selectedArrival = null;

        // When a departure address gets deselected
        if ($value == null) {
            $this->arrivalAddresses = collect();
            return;
        }

        // Extract Route ID and Address ID
        [$routeId, $addressId] = explode('-', $value);

        $this->loadArrivalAddresses((int)$routeId, (int)$addressId);
    }

    private function loadArrivalAddresses(int $routeId, int $departureAddressId) : void
    {
        $route = Route::with([
            'routePaths',
            'routePaths.addressSegment',
            'routePaths.addressSegment.endAddress',
        ])->find($routeId);

        // Get segment order number from departure address
        // This will be used to ensure arrivalAddresses only display addresses that are reachable from a certain address within a route
        $departureSegmentOrderNum = (int) RoutePath::where('route_id', $routeId)
            ->whereHas('addressSegment', function ($query) use ($departureAddressId) {
                $query->where('start_address_id', $departureAddressId);
            })
            ->first()
            ->segment_order_number;

        // Get excluded address segments - segments that are fully booked
        $excludedSegments = $this->getExcludedSegmentIds($routeId);


        $this->arrivalAddresses = $route->routePaths
            ->filter(function (RoutePath $routePath) use ($departureSegmentOrderNum, $excludedSegments) {
                // Only display addresses that come after the selected from address in a route
                return $routePath->segment_order_number >= $departureSegmentOrderNum &&
                    // Filter out segments that are fully booked
                    !$excludedSegments->contains($routePath->address_segment_id);
            })
            ->map(function (RoutePath $routePath) use ($route) {
                $endAddressId = $routePath->addressSegment->end_address_id;
                return [
                    'value' => $route->id . '-' . $endAddressId,
                    'name' => $routePath->addressSegment->endAddress->city,
                    'description' => $route->getArrivalTime($endAddressId)?->format("H:i") ?? '',
                ];
            });
        /* \Log::debug("Arrival Addresses: " . $this->arrivalAddresses); */
    }

    // TODO: DO VALIDATION FOR DATE
    private function getExcludedSegmentIds($routeId) {
        if (!$this->date) {
            Log::warning('Date has not been set on the booking page, so excludedSegments could not be calculated.');
            return collect();
        }

        $bookings = Booking::where('route_id', $routeId)
            ->where('date', $this->date)
            ->where('status', 'confirmed') // TODO: SET TO PAID INSTEAD
            ->get();

        $addressSegmentIds = AddressSegment::pluck('id')->all();
        $addressSegmentCount = array_fill_keys($addressSegmentIds, 0);

        $bookings->each(function(Booking $booking) use (&$addressSegmentCount) {
            // TODO: takes booking, uses from and to address and returns a collection of address segments
            $bookingAddressSegments = RouteHelper::getAddressSegmentsFromBooking($booking);
            Log::debug("Segments from booking with id: " . $booking->id);
            Log::debug($bookingAddressSegments);

            $bookingAddressSegments->each(function (AddressSegment $address_segment) use (&$addressSegmentCount) {
                $addressSegmentCount[$address_segment->id]++;
            });
        });

        Log::debug("Address Segment count: ", $addressSegmentCount);

        return collect(array_filter($addressSegmentCount, fn($count) => $count >= self::MAX_PASSENGERS_PER_SEGMENT))->keys();
    }

    public function mount()
    {
        $this->showMembershipPanel = true;
        // TODO: improve readability and maybe extract logic in helper function
        // TODO: use caching here
        $this->departureAddresses = collect();
        /* \Log::debug($this->departureAddresses->map(fn($item) => $item['value'])); */
        // TODO: use caching
        $this->arrivalAddresses = collect();
    }


    public function render()
    {
        return view('livewire.book');
    }
}
