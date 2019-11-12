<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = [
        'origin_city_id',
        'destination_city_id',
        'trip_heading'
    ];
    public function origincity()
    {
        return $this->belongsTo('App\OriginCity');
    }
    public function destinationcity()
    {
        return $this->belongsTo('App\DestinationCity');
    }
}
