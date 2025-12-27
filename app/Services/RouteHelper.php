<?php

namespace App\Services;

use App\Models\Booking;

class RouteHelper
{
    public static function getAddressSegmentsFromBooking(Booking $booking) {
        // get segment_order_number for arrival address and departure address
        $startPoint = $booking->route
            ->routePaths()
            ->whereHas('addressSegment', function ($query) use ($booking) {
                $query->where('start_address_id', $booking->departure_address_id);
           })
            ->first()
            ?->segment_order_number;

        $endPoint = $booking->route
            ->routePaths()
            ->whereHas('addressSegment', function ($query) use ($booking) {
                $query->where('end_address_id', $booking->arrival_address_id);
           })
            ->first()
            ?->segment_order_number;

        $addressSegments = $booking->route
            ->routePaths()
            ->whereHas('addressSegment', function ($query) use ($startPoint, $endPoint) {
                $query->whereBetween('segment_order_number', [$startPoint, $endPoint]);
            })
            ->with('addressSegment')
            ->get()
            ->pluck('addressSegment');

        return $addressSegments;
    }
}
