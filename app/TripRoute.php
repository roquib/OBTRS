<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TripRoute extends Model
{
    protected $fillable = [
        'company_id',
        'company_name',
        'origin_city_id',
        'destination_city_id',
        'parent_trip_route_id',
        'business_class_fare',
        'economy_class_fare',
        'special_class_fare',
        'departure_date',
        'departure_time',
        'arrival_date',
        'arrival_time',
        'trip_number',
        'bus_type_id',
        'bus_desc',
    ];
    public function company()
    {
        return $this->belongsTo('App\Operator');
    }
}
