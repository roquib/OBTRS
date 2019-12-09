<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Detail extends Model
{
	protected $fillable = [
		'trip_id',
		'trip_route_id',
		'company_id',
		'company_name',
		'image',
		'origin_city_id',
		'origin_city_name',
		'destination_city_id',
		'destination_city_name',
		'parent_trip_route_id',
		'business_class_fare',
		'economy_class_fare',
		'special_class_fare',
		'departure_date',
		'departure_time',
		'arrival_date',
		'arrival_time',
		'available_till_datetime',
		'bus_type_id',
		'trip_number',
		'trip_heading',
		'bus_desc',
		'available_seats',
		'trip_origin_date',
		'trip_origin_time'
	];
	public function company()
	{
		return $this->belongsTo('App\Operator');
	}
	public function findTicket($trip_id, $seat_number)
	{
		// return json_encode(["trip_id"=> $trip_id,"seat_number" => $seat_number]);
		// $str = strval($seat_number);
		$sql = "select * from sell_tickets where trip_id=" . $trip_id . " and seat_number='" . $seat_number . "'";
		// dd($sql);
		// return $sql;
		$result = json_encode(DB::select(DB::raw($sql)));
		return $result;
		// return json_encode(SellTicket::where("trip_id", $trip_id)->where("seat_number", strval($seat_number))->get()->first());
	}
	public function seatAvailable($trip_id, $seat_number)
	{
		// return json_encode(["trip_id"=> $trip_id,"seat_number" => $seat_number]);
		// $a = json_encode(DB::table('sell_tickets')->where('trip_id', $trip_id)->where('seat_number', $seat_number)->get()->first());
		$a = SellTicket::where('trip_id', $trip_id)->where('seat_number', $seat_number)->get()->first();
		return $a;
		if ($a->seat_available === 0) {
			return 0;
		} else {
			return 1;
		}
	}
}
