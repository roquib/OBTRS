<?php


namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\OriginCity;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;

class OriginCityController extends Controller
{
  public function index()
  {
    // load page with initial data
    return OriginCity::latest()->paginate(10);
  }
  public function origincity_list()
  {
    return DB::table('origin_cities')
      ->get(['id', 'name']);
  }
  public function store(Request $request)
  {
    // dd($request->all());
    // validation
    $this->validate($request, [
      'name'      => 'nullable',
    ]);
    // insert data
    return OriginCity::create([
      'name'      => $request['name'],
      'origin_city_seq'      => $request['origin_city_seq'],
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
    $origin_city = OriginCity::findOrFAil($id);
    $this->validate($request, [
      'name'      => 'required',
    ]);
    $origin_city->update($request->all());
    return ['message' => 'Getting id is: ' . $id];
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    OriginCity::findOrFail($id)->delete();
    return ['message' => 'City deleted successfully'];
  }
}
