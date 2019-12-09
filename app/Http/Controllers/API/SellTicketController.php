<?php


namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SellTicket;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;

class SellTicketController extends Controller
{
  public function index()
  {
    // load page with initial data
    // return SellTicket::latest()->paginate(10);
    return SellTicket::groupBy('trip_id', 'company_id')->select('trip_id', "company_id", DB::raw('count(*) as total'))
      ->paginate(10);
  }
  public function ticket_list()
  {
    // return Counter::pluck('name')->toArray();
    return DB::table('sell_tickets')
      ->groupBy('trip_id')
      ->get(['trip_id', 'company_id']);
  }
  public function store(Request $request)
  {
    // dd($request->all());
    // validation
    $lastTicket = SellTicket::latest()->first()->ticket_id;
    $seatRow = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
    $NumberOfSeats = 40;
    $this->validate($request, [
      'trip_id'      => 'required',
      'company_id'      => 'required',
    ]);
    // insert data
    $dataA = [];
    for ($i = 0; $i < 10; $i++) {
      $newA = array_push($dataA, $seatRow[$i] . '1');
      $newA = array_push($dataA, $seatRow[$i] . '2');
      $newA = array_push($dataA, $seatRow[$i] . '3');
      $newA = array_push($dataA, $seatRow[$i] . '4');
    }
    for ($j = 0; $j < $NumberOfSeats; $j++) {
      SellTicket::create([
        'ticket_id'      => $lastTicket += 1,
        'trip_id'      => $request['trip_id'],
        'company_id'      => $request['company_id'],
        'seat_number'      => $dataA[$j],
        'seat_available'      => 1,
      ]);
    }
    return "success";
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
    $tickets = SellTicket::where('trip_id', '=', $id);
    $this->validate($request, [
      'trip_id'      => 'required',
      'company_id'      => 'required',
    ]);
    foreach ($tickets as $obj) {
      $obj->trip_id = $request->trip_id;
      $obj->company_id = $request->company_id;
      $obj->save();
    }
    return ['message' => 'Getting id is: ' . $id];
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    DB::table('sell_tickets')->where('trip_id', '=', $id)->delete();
    return ['message' => 'Ticket deleted successfully'];
  }
}
