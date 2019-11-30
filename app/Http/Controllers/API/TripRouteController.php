<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TripRoute;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;

class TripRouteController extends Controller
{
  public function index()
  {
    // $details = Detail::latest()->paginate(3);
    // return DB::table('details')->paginate(5);
    $trip_routes = TripRoute::with('company')->paginate(5);
    return $trip_routes;
  }
  public function last_trip_id()
  {
    $last3 = DB::table('trips')->latest('id')->get();
    return $last3;
  }
  public function trip_route_list()
  {
    return DB::table('trip_routes')->get();
    // return DB::table('trip_routes')->orderBy('id', 'asc')->paginate(155);
  }

  public function search($detail_search)
  {
    // return $search;
    // if ($detail_search == "") {
    //   $details = Detail::with('author')
    //     ->with('category')
    //     ->with('group')
    //     ->paginate(5);
    //   return $details;
    // }
    // $details = Detail::with('author')
    //   ->with('category')
    //   ->with('group')
    //   ->with('publication')
    //   ->where('name', 'like', '%' . $detail_search . '%')
    //   ->paginate(5);
    // return $details;
  }

  /**
   * Store the request data into database
   */
  public function store(Request $request)
  {
    $user_id = auth('api')->user()->id;
    $this->validate($request, [
      'company_id' => 'required',
      'company_name' => 'required',
      'origin_city_id' => 'required',
      'destination_city_id' => 'required',
      'departure_date' => 'required',
      'departure_time' => 'required',
      'arrival_date' => 'required',
      'arrival_time' => 'required',
      'trip_number' => 'required',
      'bus_type_id' => 'required',
      'bus_desc' => 'required',
    ]);
    // insert data
    return TripRoute::create([
      'company_id'                => $request['company_id'],
      'company_name'              => $request['company_name'],
      'origin_city_id'            => $request['origin_city_id'],
      'destination_city_id'       => $request['destination_city_id'],
      'parent_trip_route_id'      => $request['parent_trip_route_id'],
      'business_class_fare'       => $request['business_class_fare'],
      'economy_class_fare'        => $request['economy_class_fare'],
      'special_class_fare'        => $request['special_class_fare'],
      'departure_date'        => $request['departure_date'],
      'departure_time'        => $request['departure_time'],
      'arrival_date'        => $request['arrival_date'],
      'arrival_time'        => $request['arrival_time'],
      'trip_number'        => $request['trip_number'],
      'bus_type_id'        => 2,
      'bus_desc'        => $request['bus_desc'],
    ]);
  }

  /**
   * Display the specified resource.
   */
  public function show($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $trip_route = TripRoute::findOrFAil($id);
    // dd($request->all());

    // return 'got the request';
    $this->validate($request, [
      'company_id' => 'required',
      'company_name' => 'required',
      'origin_city_id' => 'required',
      'destination_city_id' => 'required',
      'departure_date' => 'required',
      'departure_time' => 'required',
      'arrival_date' => 'required',
      'arrival_time' => 'required',
      'trip_number' => 'required',
      'bus_type_id' => 'required',
      'bus_desc' => 'required',
    ]);
    $trip_route->update($request->all());
    return ['message' => 'Getting id is: ' . $id];
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {

    $trip_route = TripRoute::findOrFail($id);
    $trip_route->delete();
    // redirect back
    return ['message' => 'trip route deleted successfully'];
  }
}
