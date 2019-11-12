<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
    	'city_name',
    	'city_status',
    	'sequence',
    	'city_short_name',
    	'is_enroute',
    	'top_city',
    	'about_city'
    ];
}
