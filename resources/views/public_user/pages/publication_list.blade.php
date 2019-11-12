
@extends('master.public')

@section('page-title')
  Book Publication
@endsection

@section('additional_script')
  <style media="screen">
    .publication img:hover {
      border: 1px solid #4FBFA8;
      padding: 5px;
    }
  </style>
@endsection




@section('main-content')
  <div class="row">
    <div class="py-4 w-100" style="background: #4FBFA8; letter-spacing: 3px; text-transform: uppercase">
    	<div class="container text-center text-light">
    			<h3  class="text-center font-weight-bold">All Publication</h3>
    	</div>
    </div>

    <div class="col-md-10 mx-auto">
      <div class="row my-4">
        @foreach ($publications as $publication)
          <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12">

            <div class="card text-center">
              <div class="card-body publication">
                <a href="{{ route('publication', $publication->id) }}">
                  <img class="card-img-top" src="{{ asset('public_user/images/publication.jpg') }}" style="height: 150px" alt="Publication">
                </a>
              </div>
              <div class="card-footer px-0 pt-1 pb-0">
                <p>By
                  <a style="color: black; font-weight: bold" href="{{ route('publication', $publication->id) }}">
                    {{ $publication->name }}
                  </a>
                </p>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>

@endsection

@section('additional_script')
  <script src="{{ asset('public_user/js/scroll_tooltip.js') }}"></script>
@endsection
