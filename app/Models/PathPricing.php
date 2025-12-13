<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PathPricing extends Model
{
    protected $table = 'path_pricing';
    protected $fillable = [
        'route_id',
        'departure_address_id',
        'arrival_address_id',
        'price'
    ];

    public $timestamps = false;
}
