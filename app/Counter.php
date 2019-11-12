<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    protected $fillable = [
    	'counter_name',
    	'counter_address',
    	'feature',
    	'user_id'
    ];
}
