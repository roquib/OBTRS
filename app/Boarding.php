<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boarding extends Model
{
	protected $fillable = [
		'location_id',
		'location_name',
		'location_status',
		'city_id',
		'trip_id',
		'trip_point_id',
		'location_type',
		'location_date',
		'location_time',
		'counter_id',
		'counter_name',
		'counter_address',
	];
	public function counter()
	{
		return $this->belongsTo('App\Counter');
	}
}
