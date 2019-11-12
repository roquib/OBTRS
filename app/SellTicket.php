<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellTicket extends Model
{
    protected $fillable = [
        'ticket_id',
        'trip_id',
        'company_id',
        'seat_number',
        'seat_available'
    ];
}
