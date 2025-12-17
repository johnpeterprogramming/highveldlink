<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'route_id',
        'departure_address_id',
        'arrival_address_id',
        'user_id',
        'booking_type', // once-off or membership
        'status',
        'date',
        'base_route_total',
        'upsells_total',
        'grand_total',
    ];

    protected $casts = [
        'date' => 'date'
    ];


    public function route() : BelongsTo
    {
        return $this->belongsTo(Route::class, 'route_id');
    }

    public function departureAddress() : BelongsTo
    {
        return $this->belongsTo(Address::class, 'departure_address_id');
    }

    public function arrivalAddress() : BelongsTo
    {
        return $this->belongsTo(Address::class, 'arrival_address_id');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function upsells()
    {
        return $this->belongsToMany(Upsell::class, 'booking_upsell')
                    ->withPivot('price')
                    ->withTimestamps();
    }

    // Helper Functions
    public function departureTime() : Carbon
    {
        return $this->route->getArrivalTime($this->departure_address_id);
    }

}
