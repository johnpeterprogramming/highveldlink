@component('mail::message')
# Hi {{ $notifiable->name }},

Your payment for the booking from **{{ $booking->departureAddress->city }}** to **{{ $booking->arrivalAddress->city }}** has been received!

| Time                | Departure Location                | Arrival Location                |
|---------------------|----------------------------------|---------------------------------|
| {{ $booking->departureTime()->toTimeString() }} | {{ $booking->departureAddress->name }} | {{ $booking->arrivalAddress->name }} |

<br>

Please be at **{{ $booking->departureAddress->name }}** 30 minutes before the departure time.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
