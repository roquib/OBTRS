<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Counter;
use DB;

class CounterController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return Counter::latest()->paginate(10);
  }
  public function counter_list()
  {
    // return Counter::pluck('name')->toArray();
    return DB::table('counters')
      ->get(['counter_name', 'id', 'counter_address']);
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
      'counter_name'      => 'required|string',
    ]);
    // insert data
    return Counter::create([
      'counter_name'       => $request['counter_name'],
      'counter_address'     => $request['counter_address'],
      'feature'      => $request['feature'],
      'user_id'    => $request['user_id'],
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
  public function update(Request $request, Counter $counter)
  {
    $this->validate($request, [
      'counter_name'      => 'required|string',
    ]);
    $counter->update($request->all());
    return ['message' => 'Updated Successfullys'];
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Counter $counter)
  {
    $counter->delete();
    return 'Success';
  }
}
