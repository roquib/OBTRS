<?php

namespace App\Http\Controllers;

use App\Product;
use App\Order;
use App\Payment;
use App\OrderDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;
use DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todaysTotalOrder = Order::where('created_at', '>=', Carbon::today())->get();
        return view('admin.todays-order', ['todaysTotalOrder'=>$todaysTotalOrder]);
    }

    public function manageOrder($id) {
      return view('admin.manage-order',
      [
          'products'        => Product::all(),
          'order'           => Order::where('id', $id)->first(),
          'orderedProducts' => OrderDetail::where('order_id', $id)->get()
      ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function deleteOrderItem ($id)
    {
        $orderDetails = OrderDetail::where('id', $id)->first();
        $order = Order::where('id', $orderDetails->order_id)->first();
        $order = Payment::where('id', $orderDetails->order_id)->first();

        $order->total_price = $order->total_price = $orderDetails->price;
        $order->save();
        $orderDetails->delete();
        Session::flash('success', 'Item deleted successful!');
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        // dd($request->all());
        $order = Order::find($request->id);
        $order->update($request->all());
        Session::flash('success', 'Data updated successful!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
