<?php


namespace App\Http\Controllers\API;

use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;

class CityController extends Controller
{
  public function index()
  {
    // load page with initial data
    return City::latest()->paginate(10);
  }
  public function city_list()
  {
    // return Counter::pluck('name')->toArray();
    return DB::table('cities')
      ->get(['city_name', 'sequence']);
  }
  public function store(Request $request)
  {
    // dd($request->all());
    // validation
    $this->validate($request, [
      'city_name'      => 'required:string',
    ]);
    // insert data
    return City::create([
      'city_name'      => $request['city_name'],
      'city_status'      => $request['city_status'],
      'sequence'      => $request['sequence'],
      'city_short_name'      => $request['city_short_name'],
      'is_enroute'      => $request['is_enroute'],
      'top_city'      => $request['top_city'],
      'about_city'      => $request['about_city'],
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
    $city = City::findOrFAil($id);
    $this->validate($request, [
      'city_name'      => 'required',
    ]);
    $city->update($request->all());
    return ['message' => 'Getting id is: ' . $id];
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    city::findOrFail($id)->delete();
    return ['message' => 'City deleted successfully'];
  }
}
