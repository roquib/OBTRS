<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Boarding;

class BoardingController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return Boarding::latest()->paginate(10);
    $details = Boarding::with('counter')->paginate(5);
  }
  public function boarding_list()
  {
    return Boarding::pluck('location_name')->toArray();
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
      'location_name' => "required",
      'location_id' => "required",
      'trip_id' => 'required'
    ]);
    // insert data
    return Boarding::create([
      'location_name'       => $request['location_name'],
      'location_id'       => $request['location_id'],
      'location_status'     => $request['location_status'],
      'city_id'      => $request['city_id'],
      'trip_id'    => $request['trip_id'],
      'trip_point_id'    => $request['trip_point_id'],
      'location_type'    => $request['location_type'],
      'location_date'    => $request['location_date'],
      'location_time'    => $request['location_time'],
      'counter_id'    => $request['counter_id'],
      'counter_name'    => $request['counter_name'],
      'counter_address'    => $request['counter_address'],
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
  public function update(Request $request, Boarding $boarding)
  {
    $this->validate($request, [
      'location_name' => "required",
      'location_id' => "required",
      'trip_id' => 'required'
    ]);
    $boarding->update($request->all());
    return ['message' => 'Updated Successfullys'];
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Boarding $boarding)
  {
    $boarding->delete();
    return 'Success';
  }
}
