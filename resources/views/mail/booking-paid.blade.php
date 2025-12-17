@component('mail::message')
# Hi {{ $notifiable->name }}

Your payment for the booking from **{{ $booking->departureAddress->city }}** to **{{ $booking->arrivalAddress->city }}** has been received!

| Time                | Departure Location                | Arrival Location                |
|---------------------|----------------------------------|---------------------------------|
| {{ $booking->departureTime() }} | {{ $booking->departureAddress->name }} | {{ $booking->arrivalAddress->name }} |


Please be at **{{ $booking->departureAddress->name }}** 20 minutes before the departure time ({{ $booking->departureTime()->subMinutes(20) }}).

Thanks,<br>
{{ config('app.name') }}
@endcomponent
