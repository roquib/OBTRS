
@extends('master.public')

@section('page-title')
  Writer List
@endsection

@section('additional_script')
  <link rel="stylesheet" href="{{ asset('public_user/css/homepage.css') }}">
  <style media="screen">
  .card-body img {
    height: 230px;
  }
  .card-body img:hover {
    border: 1px solid #08B0BC;
  }
  .card a:hover {
    color: #08B0BC !important;
  }
  </style>
@endsection




@section('main-content')
  <div class="">
    <div class="col-md-10 mx-auto">
      <div class="row my-3">
        @foreach ($authors as $author)
          <div class="col-md-3 mb-3">

              <div class="card text-center">
                <div class="card-body">
                  <a title="Click to know detais about {{ $author->name }}" href="{{ route('writer', $author->id) }}">
                  <img class="card-img-top" src="{{ asset('img/writer/' . $author->image) }}" alt="{{ $author->image }}">
                </a>
                </div>
                <a style="color: black" title="Click to know detais about {{ $author->name }}" href="{{ route('writer', $author->id) }}">
                  <div class="card-footer text-center">
                    {{ $author->name }}
                  </div>
                </a>
              </div>

          </div>


        @endforeach
      </div>
    </div>
  </div>
@endsection




@section('additional_script')
  <script src="{{asset('public_user/js/scroll_tooltip.js')}}"></script>
@endsection
