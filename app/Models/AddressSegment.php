<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressSegment extends Model
{
    protected $fillable = [
        'start_address_id',
        'end_address_id',
        'distance',
        'travel_time_minutes'
    ];

    public function startAddress()
    {
        return $this->hasOne(Address::class, 'id', 'start_address_id');
    }

    public function endAddress()
    {
        return $this->hasOne(Address::class, 'id', 'end_address_id');
    }
}
