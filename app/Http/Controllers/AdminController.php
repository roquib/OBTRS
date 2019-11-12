<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Carbon\Carbon;
use DB;

class AdminController extends Controller
{
  //  check authentication that user logged in or not
  public function __construct()
  {
    $this->middleware('auth');
  }

  // populate dashboard
  public function dashboard()
  {
    return view(
      'admin.dashboard',
      [
        'todaysTotalOrder'  => Order::where('created_at', '>=', Carbon::today())->get(),
        'totalPendingOrder' => DB::table('orders')->where('status', 0)
      ]
    );
  }


  public function user()
  {
    return view('admin.user');
  }

  public function profile()
  {
    return view('admin.profile');
  }
  public function counter()
  {
    return view('admin.counter');
  }
  public function ticket()
  {
    return view('admin.ticket');
  }
  public function city()
  {
    return view('admin.city');
  }

  public function group()
  {
    return view('admin.group');
  }

  public function category()
  {
    return view('admin.category');
  }
  public function trip_point()
  {
    return view('admin.trip_point');
  }
  public function trip_route()
  {
    return view('admin.trip_route');
  }

  public function origincity()
  {
    return view('admin.origincity');
  }
  public function destinationcity()
  {
    return view('admin.destinationcity');
  }
  public function route()
  {
    return view('admin.route');
  }
  public function details()
  {
    return view('admin.details');
  }

  public function publication()
  {
    return view('admin.publication');
  }

  public function product()
  {
    return view('admin.product');
  }
  public function supplier()
  {
    return view('admin.supplier');
  }
  public function operator()
  {
    return view('admin.operator');
  }
  public function boarding()
  {
    return view('admin.boarding');
  }
  public function purchase()
  {
    return view('admin.purchase');
  }
  public function purchase_list()
  {
    return view('admin.purchase-list');
  }
}
