<?php

namespace App\Http\Controllers;

use App\Detail;
use App\Reservation;
use App\SellTicket;
use DB;
use Illuminate\Http\Request;

class PagesController extends Controller
{
  public function index()
  {
    return view('public_user.pages.home');
  }
  public function confirm(Request $request)
  {
    // dd($request);
    $seats = [
      'A1', 'B1', 'C1', 'D1', 'E1', 'F1', 'G1', 'H1', 'I1', 'J1',
      'A2', 'B2', 'C2', 'D2', 'E2', 'F2', 'G2', 'H2', 'I2', 'J2',
      'A3', 'B3', 'C3', 'D3', 'E3', 'F3', 'G3', 'H3', 'I3', 'J3',
      'A4', 'B4', 'C4', 'D4', 'E4', 'F4', 'G4', 'H4', 'I4', 'J4',
    ];
    $Number_of_seats_exists = [];
    foreach ($request->all() as $key => $value) {
      if (in_array($key, $seats)) {
        array_push($Number_of_seats_exists, $key);
      }
    }
    // print_r($Number_of_seats_exists);
    $detail = Detail::where('trip_id', $request->trip_id)->get();
    // dd($request->all());
    $reservation = new Reservation();
    $reservation->p_name = $request->p_name;
    $reservation->p_gender = $request->p_gender;
    $reservation->p_mobile = $request->p_mobile;
    $reservation->p_email = $request->p_email;
    $reservation->trip_id = $request->trip_id;
    $reservation->origin_city_name = $request->origin_city_name;
    $reservation->destination_city_name = $request->destination_city_name;
    $reservation->company_name = $request->company_name;
    $reservation->departure_date = $request->departure_date;
    $reservation->departure_time = $request->departure_time;
    // $reservation->ticket_one = $request->ticket_one;
    // $reservation->ticket_two = $request->ticket_two;
    // $reservation->ticket_three = $request->ticket_three;
    $reservation->ticket_one = isset($Number_of_seats_exists[0]) ? $Number_of_seats_exists[0] : null;
    $reservation->ticket_two = isset($Number_of_seats_exists[1]) ? $Number_of_seats_exists[1] : null;
    $reservation->ticket_three = isset($Number_of_seats_exists[2]) ? $Number_of_seats_exists[2] : null;
    if ($reservation->ticket_one != null) {
      $ticket = SellTicket::where('trip_id', $request->trip_id)->where('seat_number', $reservation->ticket_one)->get()->first();
      $ticket->seat_available = 0;
      $ticket->save();
    }
    if ($reservation->ticket_two != null) {
      $ticket = SellTicket::where('trip_id', $request->trip_id)->where('seat_number', $reservation->ticket_two)->get()->first();
      $ticket->seat_available = 0;
      $ticket->save();
    }
    if ($reservation->ticket_three != null) {
      $ticket = SellTicket::where('trip_id', $request->trip_id)->where('seat_number', $reservation->ticket_three)->get()->first();
      $ticket->seat_available = 0;
      $ticket->save();
    }
    // dd([$reservation->ticket_one, $reservation->ticket_two, $reservation->ticket_three]);
    $reservation->boarding_point = $request->boarding_point;
    $reservation->total = $request->total;
    $reservation->payment = $request->payment;
    $reservation->city = $request->city;
    $reservation->area = $request->area;
    $reservation->first_name = $request->first_name;
    $reservation->last_name = $request->last_name;
    $reservation->address = $request->address;
    $reservation->alternate_contact = $request->alternate_contact;
    $reservation->status = 0;
    $reservation->save();
    return view("public_user.pages.welcome_message", ['name' => $request->p_name, 'email' => $request->p_email, 'contact' => $request->p_mobile]);
  }
  public function bookingRelease(Request $request)
  {
    return json_encode(["ticketid" => $request->ticketid, "routeid" => $request->routeid]);
  }
  public function bookingConfirm(Request $request)
  {
    $seats = [
      'A1', 'B1', 'C1', 'D1', 'E1', 'F1', 'G1', 'H1', 'I1', 'J1',
      'A2', 'B2', 'C2', 'D2', 'E2', 'F2', 'G2', 'H2', 'I2', 'J2',
      'A3', 'B3', 'C3', 'D3', 'E3', 'F3', 'G3', 'H3', 'I3', 'J3',
      'A4', 'B4', 'C4', 'D4', 'E4', 'F4', 'G4', 'H4', 'I4', 'J4',
    ];
    $Number_of_seats_exists = [];
    foreach ($request->all() as $key => $value) {
      if (in_array($key, $seats)) {
        array_push($Number_of_seats_exists, $key);
      }
    }
    $detail = Detail::where('trip_id', $request->trip_id)->get();
    // dd($detail);
    // dd($Number_of_seats_exists, $request->trip_id, $request->boardingpoint, $detail);
    return view(
      'public_user.pages.ticket_confirm',
      [
        'seats' => $Number_of_seats_exists,
        'trip_id' => $request->trip_id,
        'boarding_point' => $request->boardingpoint,
        'detail' => $detail
      ]
    );
  }
  public function bookingReserve(Request $request)
  {
    return json_encode(["ticketid" => $request->ticketid, "routeid" => $request->routeid, "ack" => 0]);
  }
  public function search(Request $request)
  {
    $fromcity = $request->fromcity;
    $tocity = $request->tocity;
    $doj = $request->doj;
    $dor = $request->dor;
    $result = Detail::where('origin_city_name', '=', $fromcity)
      ->where('destination_city_name', '=', $tocity)
      ->where('departure_date', '=', $doj)
      ->get();
    // $sellTickets = SellTicket::all();
    // dd($result);
    return view('public_user.pages.bus-search', ['result' => $result, 'data' => $request]);
  }
  // populate contact page
  public function contact()
  {
    return view(
      'public_user.pages.contact',
      [
        'cartProducts' => Cart::Content(),
        'authors'      => Author::orderBy('name', 'asc')->get(),
        'publications' => Publication::orderBy('name', 'asc')->get(),
        'activePage'   => "contact"
      ]
    );
  }


  // populate about page
  public function about_us()
  {
    return view(
      'public_user.pages.about_us',
      [
        'cartProducts' => Cart::Content(),
        'authors'      => Author::orderBy('name', 'asc')->get(),
        'publications' => Publication::orderBy('name', 'asc')->get(),
        'activePage'   => "about_us"
      ]
    );
  }
}
