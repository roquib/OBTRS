<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Detail;
use App\Trip;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;

class DetailController extends Controller
{
  public function index()
  {
    // $details = Detail::latest()->paginate(3);
    // return DB::table('details')->paginate(5);
    $details = Detail::with('company')->paginate(5);
    return $details;
  }

  public function detail_list()
  {
    return DB::table('details')->get();
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
      'trip_id' => 'required',
      'trip_route_id' => 'required',
      'company_id' => 'required',
      'company_name' => 'required',
      'origin_city_id' => 'required',
      'origin_city_name' => 'required',
      'destination_city_id' => 'required',
      'destination_city_name' => 'required',
      'departure_date' => 'required',
      'departure_time' => 'required',
      'arrival_date' => 'required',
      'arrival_time' => 'required',
      'available_till_datetime' => 'required',
      'bus_type_id' => 'required',
      'trip_number' => 'required',
      'trip_heading' => 'required',
      'bus_desc' => 'required',
      'trip_origin_date' => 'required',
      'trip_origin_time' => 'required',
    ]);
    $imgName = 'abc';
    if ($request->image) {
      $imgName = time() . '.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ';')))[1])[1];
      \Image::make($request->image)->save(public_path('img/writer/') . $imgName);
    }

    // insert data
    Trip::create([
      'id' => $request['trip_id'],
    ]);
    return Detail::create([
      'trip_id'                   => $request['trip_id'],
      'trip_route_id'             => $request['trip_route_id'],
      'company_id'                => $request['company_id'],
      'company_name'              => $request['company_name'],
      'image'                     => $imgName,
      'origin_city_id'            => $request['origin_city_id'],
      'origin_city_name'          => $request['origin_city_name'],
      'destination_city_id'       => $request['destination_city_id'],
      'destination_city_name'     => $request['destination_city_name'],
      'parent_trip_route_id'      => $request['parent_trip_route_id'],
      'business_class_fare'       => $request['business_class_fare'],
      'economy_class_fare'        => $request['economy_class_fare'],
      'special_class_fare'        => $request['special_class_fare'],
      'departure_date'        => $request['departure_date'],
      'departure_time'        => $request['departure_time'],
      'arrival_date'        => $request['arrival_date'],
      'arrival_time'        => $request['arrival_time'],
      'available_till_datetime'        => $request['available_till_datetime'],
      'trip_number'        => $request['trip_number'],
      'trip_heading'        => $request['trip_heading'],
      'bus_desc'        => $request['bus_desc'],
      'available_seats'        => $request['available_seats'],
      'trip_origin_date'        => $request['trip_origin_date'],
      'trip_origin_time'        => $request['trip_origin_time'],
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
    $detail = Detail::findOrFAil($id);


    // return 'got the request';
    $this->validate($request, [
      'trip_id' => 'required',
      'trip_route_id' => 'required',
      'company_id' => 'required',
      'company_name' => 'required',
      'origin_city_id' => 'required',
      'origin_city_name' => 'required',
      'destination_city_id' => 'required',
      'destination_city_name' => 'required',
      'departure_date' => 'required',
      'departure_time' => 'required',
      'arrival_date' => 'required',
      'arrival_time' => 'required',
      'available_till_datetime' => 'required',
      'bus_type_id' => 'required',
      'trip_number' => 'required',
      'trip_heading' => 'required',
      'bus_desc' => 'required',
      'trip_origin_date' => 'required',
      'trip_origin_time' => 'required',
    ]);

    $imgName = 'abc';
    $currentDetail = Detail::where('id', $id)->first();
    $currentImage = $currentDetail->image;

    if ($request->image != $currentImage) {

      if ($request->image) {
        $imgName = time() . '.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ';')))[1])[1];
        \Image::make($request->image)->save(public_path('img/writer/') . $imgName);
        $request->merge(['image' => $imgName]);
        // if (file_exists('img/writer/' . $currentImage)) {
        //   unlink('img/writer/' . $currentImage);
        // }
      } else {
        // return 'when not change image: ' . $request->image;
      }
    } else { }
    // dd($request->all());
    // return $request->all();
    $detail->update($request->all());
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

    $currentDetail = Detail::where('id', $id)->first();
    $currentImage = $currentDetail->image;
    if (file_exists('detail/' . $currentImage)) {
      unlink('detail/' . $currentImage);
    }
    $detail = Detail::findOrFail($id);
    $trip = Trip::findOrFail($detail->trip_id);
    $trip->delete();
    $detail->delete();
    // redirect back
    return ['message' => 'Detail deleted successfully'];
  }
}
