<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = [];

    protected function routePaths()
    {
        return $this->hasMany(RoutePath::class, 'route_id');
    }
}
