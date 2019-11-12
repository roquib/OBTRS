<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\mail\sendMail;
use App\ContactMessage;

class SendingMailController extends Controller
{
  //  Advance mail send
  public function send(Request $request)
  {

    // dd($request->all());

    $this->validate($request, [
      'name'     => 'required|string|max:255',
      'to'       => 'required|string|email|max:191',
      'message'  => 'required',
    ]);

    try {

      Mail::send(new sendMail());

      // insert data
      $message = new ContactMessage();

      $message->name    = $request->name;
      $message->email   = $request->to;
      $message->message = $request->message;
      $message->mobile  = $request->mobile;
      $message->save();

      $request->session()->flash('contactMail', 'Your message is successfully send.');

      return redirect()->back();
    } catch (\Exception $e) {
      return "mail send failed";
      $request->session()->flash('contactMailFailled', 'Something Error.');
      return redirect()->back();
    }

  }

  // Send mail using form
  // public function email()
  // {
  //   return view('public_user.pages.contact');
  // }
}
