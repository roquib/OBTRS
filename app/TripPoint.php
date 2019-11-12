<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TripPoint extends Model
{
    protected $fillable = [
        'location_name',
        'location_status',
        'location_type'
    ];
}
