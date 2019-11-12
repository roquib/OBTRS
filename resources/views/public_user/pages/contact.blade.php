
@extends('master.public')

@section('page-title')
  Contact Us
@endsection


@section('addition-styles')
  <link rel="stylesheet" href="{{ asset('public_user/css/contact-us.css') }}" type="text/css">
@endsection

@section('main-content')
  <div class="bg m-0">

    <div class="contact-form mx-auto">
      <div class="contact-image">
        <img src="{{ asset('public_user/images/rocket_contact.png') }}" alt="Image not found">
      </div>

      {{-- form start --}}
      {!! Form::open([ 'url' => route('send.contact'), 'method'=>'post', 'role'=>'form', 'enctype'=>'multipart/form-data', 'name'=>'productEditForm']) !!}


        @if(Session::has('contactMail'))
          <div id="successMessage" class="alert text-center" style="background: #D9EDF7">
            <strong>Success!</strong> Your message is send.
          </div>
        @elseif(Session::has('name'))
          <div id="successMessage" class="alert text-center" style="background: #D9EDF7">
            <strong>warning!</strong> {{ Session::get('name') }}
          </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h3 class="text-primary text-center">Drop us a contact</h3>

        <div class="row">
          <div class="col-md-6">
            <input class="form-control border-radius my-2" type="text" name="name" value="" placeholder="Your name *" title="Your Name">
            <input class="form-control border-radius my-2" type="text" name="to" value="" placeholder="Your Email *" title="Email Address">
            <input class="form-control border-radius my-2" type="text" name="mobile" value="" placeholder="Your Mobile" title="Mobile Number">

            <input class="mt-3 btn btn-success btn-block border-radius " type="submit" name="" value="Send Message">
          </div>
          <div class="col-md-6">

            <textarea class="form-control mt-2" title="Email Valuable Message" name="message" rows="7" cols="80" placeholder="Your message........."></textarea>

          </div>
        </div>
      {!! Form::close() !!}
    </div>

    <div class="contact-form map mx-auto" style="background: #17ABCC">
      <h3 class="text-light text-center">Location</h3>
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7297.094007074188!2d90.39794648377654!3d23.87021445552251!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c43aad03699f%3A0xd7744072ad2d345e!2sUttara+University!5e0!3m2!1sen!2shk!4v1547299147366" width="100%" height="450" frameborder="0" style="border:5px" allowfullscreen></iframe>

    </div>
  </div>

  {{-- <script type="text/javascript">
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip({
          placement : 'top'
      });
    });
    setTimeout(function() {
        $('#successMessage').fadeOut('fast');
      }, 3000); // <-- time in milliseconds
  </script> --}}
@endsection
