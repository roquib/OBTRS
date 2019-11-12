<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\request;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
     public function build(request $request)
     {
        // return "send mail";
         // return $this->view('public_user.pages.mail', ['msg'=>$request->message])->to($request->to);
         return $this->view('public_user.pages.mail',
         [
           'msg'   => $request->message,
           'to'    => $request->to,
           'name'  => $request->name,
           'mobile'=> $request->mobile
           ])->to('akashcseuu026@gmail.com');
     }
}
