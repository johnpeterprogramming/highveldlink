@component('mail::message')
# Automated Message to Admin

Payment for the booking of {{ $booking->user->name }} has been received.

| Time                | Departure Location                | Arrival Location                |
|---------------------|----------------------------------|---------------------------------|
| {{ $booking->departureTime()->toTimeString() }} | {{ $booking->departureAddress->name }} | {{ $booking->arrivalAddress->name }} |

TODO: add link to booking info in admin dashboard panel

@endcomponent
