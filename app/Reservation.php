<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'p_name',
        "p_gender",
        "p_mobile",
        "p_email",
        "trip_id",
        "origin_city_name",
        "destination_city_name",
        "company_name",
        "departure_date",
        "departure_time",
        "ticket_one",
        "ticket_two",
        "ticket_three",
        "boarding_point",
        "total",
        "payment",
        "city",
        "area",
        "first_name",
        "last_name",
        "address",
        "alternate_contact",
        "status"
    ];
}
