<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TripPoint;
use DB;

class TripPointController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return TripPoint::latest()->paginate(10);
  }
  public function trip_point_list()
  {
    // return Counter::pluck('name')->toArray();
    return DB::table('trip_points')
      ->get(['location_name', 'id', 'location_status', "location_type", 'created_at']);
    // return TripPoint::all();
  }
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->validate($request, [
      'location_name'      => 'required|string',
    ]);
    // insert data
    return TripPoint::create([
      'location_name'       => $request['location_name'],
      'location_status'     => $request['location_status'],
      'location_type'      => $request['location_type'],
    ]);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, TripPoint $trip_point)
  {
    $this->validate($request, [
      'location_name'      => 'required|string',
    ]);
    $trip_point->update($request->all());
    return ['message' => 'Updated Successfullys'];
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(TripPoint $trip_point)
  {
    $trip_point->delete();
    return 'Success';
  }
}
