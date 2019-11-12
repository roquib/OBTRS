<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Operator;
use DB;
class OperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Operator::latest()->paginate(10);
    }
    // public function operator_list()
    // {
    //   return Operator::pluck('company_name')->toArray();
    // }
    public function operator_list()
  {
    return DB::table('operators')
      ->get(['company_name','id']);
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
        'company_name'      => 'required|string|max:255|min:2|unique:operators',
      ]);
      // insert data
      return Operator::create([
        'company_logo_url'       => $request['company_logo_url'],
        'company_name'     => $request['company_name'],
        'company_address'      => $request['company_address'],
        'company_short_name'    => $request['company_short_name'],
        'address_line1'    => $request['address_line1'],
        'address_line2'    => $request['address_line2'],
        'postal_code'    => $request['postal_code'],
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
    public function update(Request $request, Operator $operator)
    {
      $this->validate($request, [
        'company_name'      => 'required|string|max:255|min:2',
      ]);
      $operator->update($request->all());
      return ['message'=>'Updated Successfullys'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Operator $operator)
    {
        $operator->delete();
        return 'Success';
    }
}
