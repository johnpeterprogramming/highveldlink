@php
    $preferredArrivalTime = $booking->departureTime()->subMinutes(15);
@endphp
<div>
    <h1>Your booking from {{ $booking->departureAddress->city }} to {{ $booking->arrivalAddress->city }} has been confirmed!</h1>

    <h2>Booking Details:</h2>
    <table>
        <tr>
            <th>Time</th>
            <th>Departure Location</th>
            <th>Arrival Location</th>
        </tr>
        <tr>
            <th>{{ $booking->departureTime() }}</th>
            <th>{{ $booking->departureAddress->name }}</th>
            <th>{{ $booking->arrivalAddress->name }}</th>
        </tr>
    </table>

    <p>Please be at {{ $booking->departureAddress->name }} 15 minutes before the departure time( {{ $preferredArrivalTime }}).</p>


</div>
