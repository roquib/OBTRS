<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Supplier;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Supplier::latest()->paginate(10);
    }
    public function supplier_list()
    {
      return Supplier::pluck('name')->toArray();
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
        'name'      => 'required|string|max:255|min:2|unique:suppliers',
        'mobile'    => 'required|string|max:255|min:2',
      ]);
      // insert data
      return Supplier::create([
        'name'       => $request['name'],
        'mobile'     => $request['mobile'],
        'email'      => $request['email'],
        'address'    => $request['address'],
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
    public function update(Request $request, Supplier $supplier)
    {
      $this->validate($request, [
        'name'      => 'required|string|max:255|min:2',
        'mobile'    => 'required|string|max:17|min:7',
      ]);
      $supplier->update($request->all());
      return ['message'=>'Updated Successfullys'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return 'Success';
    }
}
