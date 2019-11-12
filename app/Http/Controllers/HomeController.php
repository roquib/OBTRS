<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Carbon\Carbon;
use DB;

class HomeController extends Controller
{
    /**
     * Check user is authenticated or not
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {
      return view('admin.dashboard',
      [
        'todaysTotalOrder'  => Order::where('created_at', '>=', Carbon::today())->get(),
        'totalPendingOrder' => DB::table('orders')->where('status', 0)
      ]);
    }
}
