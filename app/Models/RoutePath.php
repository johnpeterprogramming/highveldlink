<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoutePath extends Model
{
    protected $fillable = [
        'route_id',
        'address_segment_id',
        'segment_order_number'
    ];

    public function route()
    {
        return $this->hasOne(Route::class);
    }

    public function addressSegment()
    {
        return $this->hasOne(AddressSegment::class);
    }
}
