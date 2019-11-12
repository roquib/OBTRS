<?php


namespace App\Http\Controllers\API;

use App\DestinationCity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;

class DestinationCityController extends Controller
{
  public function index()
  {
    // load page with initial data
    return DestinationCity::latest()->paginate(10);
  }
  public function destinationcity_list()
  {
    return DB::table('destination_cities')
      ->get(['id', 'name']);
  }
  public function store(Request $request)
  {
    // dd($request->all());
    // validation
    $this->validate($request, [
      'name'      => 'required',
    ]);
    // insert data
    return DestinationCity::create([
      'name'      => $request['name'],
      'destination_city_seq'      => $request['destination_city_seq'],
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
    $destination_city = DestinationCity::findOrFAil($id);
    $this->validate($request, [
      'name'      => 'required',
    ]);
    $destination_city->update($request->all());
    return ['message' => 'Getting id is: ' . $id];
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    DestinationCity::findOrFail($id)->delete();
    return ['message' => 'Destination deleted successfully'];
  }
}
