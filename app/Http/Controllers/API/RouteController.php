<?php


namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;

class RouteController extends Controller
{
  public function index()
  {
    // load page with initial data
    return Route::latest()->paginate(10);
  }
  public function route_list()
  {
    return DB::table('routes')
      ->get(['id', 'origin_city_id', 'destination_city_id', "trip_heading"]);
  }
  public function store(Request $request)
  {
    // dd($request->all());
    // validation
    $this->validate($request, [
      'origin_city_id'      => 'required',
      'destination_city_id'      => 'required',
      'trip_heading'      => 'required',
    ]);
    // insert data
    return Route::create([
      'origin_city_id'      => $request['origin_city_id'],
      'destination_city_id'      => $request['destination_city_id'],
      'trip_heading'      => $request['trip_heading'],
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
    // update data
    $route = Route::findOrFAil($id);
    $this->validate($request, [
      'origin_city_id'      => 'required',
      'destination_city_id'      => 'required',
      'trip_heading'      => 'required',
    ]);
    $route->update($request->all());
    return ['message' => 'Getting id is: ' . $id];
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    Route::findOrFail($id)->delete();
    return ['message' => 'City deleted successfully'];
  }
}
