<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Supplier;
use App\Purchase;
use App\PurchaseDetail;
use DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index($data = null)
     {
       $order = 'asc';
       // $table = '';
       if ($data) {
         return $data;
       }


       $purchases = Purchase::with('supplier')
         ->with('purchaseItems')
         ->with('user');

       return response()->JSON($purchases->paginate(3));
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    public function storeProducts(Request $request, $supp)
    {
        $supplier    = DB::table('suppliers')->where('name', $supp)->first();

        $purchase = Purchase::create([
          'user_id'      => auth('api')->user()->id,
          'supplier_id'  => $supplier->id,
          'total_price'  => 0,
        ]);




      $total_price = 0;
      foreach (json_decode($request->shopItems) as $item) {
        $total_price += $item->quantity * $item->price;
        PurchaseDetail::create([
          'purchase_id'  => $purchase->id,
          'quantity'     => $item->quantity,
          'price'        => $item->price,
          'book_id'      => $item->book_id,
        ]);
      }

      if ($total_price > 0) {
        DB::table('purchases')
          ->where('id', $purchase->id)
          ->update(['total_price' => $total_price]);
      }


      return "success";
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
