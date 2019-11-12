<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Author;
use App\Publication;
use App\Order;
use App\Payment;
use App\OrderDetail;
use Cart;
use Session;
use \PDF;

class ProductShippingController extends Controller
{


  /*
    #############################################################
                        Product Shipping
    #############################################################
  */
  // Product shipping form
  public function productShipping()
  {
    if (Cart::Content()->isEmpty()) {
      return view(
        'public_user.pages.shipping.shipping',
        [
          'activePage'   => "",
          'cartProducts' => Cart::Content(),
          'authors'      => Author::orderBy('NAME', 'asc')->get(),
          'publications' => Publication::orderBy('NAME', 'asc')->get()
        ]
      );
    }
    return view(
      'public_user.pages.shipping.shipping',
      [
        'activePage'   => "",
        'cartProducts' => Cart::Content(),
        'authors'      => Author::orderBy('name', 'asc')->get(),
        'publications' => Publication::orderBy('name', 'asc')->get()
      ]
    );
  }


  // Store Shipping info in session
  public function cartShipping(Request $request)
  {
    if (Cart::Content()->isEmpty()) {
      return redirect()->back();
    }
    $delivery_amount = array(30, 50, 70, 100, 100, 100, 90, 80, 0);

    $request->session()->put('customer_name', $request->customer_name);
    $request->session()->put('email', $request->email);
    $request->session()->put('customer_mobile', $request->customer_mobile);
    $request->session()->put('contact_person', $request->contact_person);
    $request->session()->put('reciver_number', $request->reciver_number);
    $request->session()->put('zone', $request->zone);
    $request->session()->put('address', $request->address);
    $request->session()->put('delivery_charge', $delivery_amount[$request->zone]);

    $this->validate($request, [
      'customer_name'   => 'required|string|max:255|min:2',
      'customer_mobile' => 'required|string|max:15|min:11',
      'contact_person'  => 'required|min:3|max:100',
      'reciver_number'  => 'required|min:11|max:16',
      'address'         => 'required|min:11|max:255',
    ]);

    return redirect()->route('payment.checkout');
  }


  /*
      #############################################################
                          Product Checkout
      #############################################################
    */


  // checkout
  public function productCheckout()
  {
    return view(
      'public_user.pages.shipping.checkout',
      [
        'activePage'   => "",
        'cartProducts' => Cart::Content(),
        'authors'      => Author::orderBy('name', 'asc')->get(),
        'publications' => Publication::orderBy('name', 'asc')->get()
      ]
    );
  }




  /*
      #############################################################
                          Payment Finalize
      #############################################################
    */
  // Submit Order

  public function orderSubmit(Request $request)
  {
    // if the payment type 1 it is payment by bkash and it must cash
    // status 0 means sales amount not paid
    // dd($request->all());
    if (Cart::Content()->isEmpty()) {
      return redirect()->back();
    }
    if (empty(Session::get('customer_name'))) {
      return redirect()->route('home.shipping.product');
    }
    if ($request->type == 1) {
      $status = 0;
    } else {
      $status = 1;
    }

    $totalQty = $totalItem = $cartTotal = 0;

    // calculate total quantity, total item and cart total price
    foreach (Cart::Content() as $product) {
      $totalQty += $product->qty;
      $totalItem++;
      $cartTotal += ($product->qty * $product->price);
    }

    // store order into order table
    $order                 = new Order();
    $order->email          = session('email');
    $order->name           = session('customer_name');
    $order->mobile         = session('customer_mobile');
    $order->total_price    = $cartTotal;
    $order->tax            = intval(((2 * $cartTotal) / 100));
    $order->shipping_cost  = session('delivery_charge');
    $order->contact_person = session('contact_person');
    $order->contact_mobile = session('reciver_number');
    $order->zone           = session('zone');
    $order->address        = session('address');
    $order->save();

    // store order details into order_detail
    foreach (Cart::Content() as $product) {
      $order_detail              = new OrderDetail();

      $book                      = Product::find($product->id);
      $book->sold += $product->qty;
      $book->save();

      $order_detail->order_id    = $order->id;
      $order_detail->product_id  = $product->id;
      $order_detail->quantity    = $product->qty;
      $order_detail->price       = $product->price;
      $order_detail->save();
    }

    // store payment info into payment table
    $payment                 = new Payment();
    $payment->type           = $request->type;
    $payment->order_id       = $order->id;
    $payment->status         = $status;
    $payment->amount         = $request->amount;
    $payment->transaction_id = $request->transaction_id;
    $payment->save();

    // cart destroy and clear shipping info
    Cart::destroy();
    $request->session()->put('customer_name', '');
    $request->session()->put('email', '');
    $request->session()->put('customer_mobile', '');
    $request->session()->put('contact_person', '');
    $request->session()->put('reciver_number', '');
    $request->session()->put('zone', '');
    $request->session()->put('address', '');
    $request->session()->put('delivery_charge', 0);

    // return order success view with the data below
    return redirect()->route('order.invoice', $order->id);
  }


  // get order invoice
  public function orderInvoice($id)
  {
    $order = Order::where('id', $id)->with('orderedProduct')->first();
    // dd($order->orderedProduct);
    return view(
      'public_user.pages.cart.order_success',
      [
        'activePage'   => "",
        'order'        => $order,
        // 'orderDetails' => OrderDetail::where('order_id', $id)->get(),
        'products'     => Product::all(),
        'authors'      => Author::orderBy('name', 'asc')->get(),
        'cartProducts' => Cart::Content(),
        'publications' => Publication::orderBy('name', 'asc')->get()
      ]
    );
  }
  // public function saveInvoices($id) {
  //     return PDF::loadView('public_user.pages.cart.invoice',
  //     [
  //       'order'        => Order::where('id', $id)->first(),
  //       'orderDetails' => OrderDetail::where('order_id', $id)->get(),
  //       'products'     => Product::all()
  //     ])->download('invoice.pdf');
  // }
}
