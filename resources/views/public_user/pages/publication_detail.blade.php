
@extends('master.public')

@section('page-title')
  Publication Information
@endsection

@section('additional_script')
  <link rel="stylesheet" href="{{ asset('public_user/css/homepage.css') }}">
  <style media="screen">
   .publication-items {
     background: #2A3038;
   }
    span a {
      color: white;
    }
    .publication-block {
      background: #363D47;
    }
    .active {
      background: #3EAA94;
    }

    .more {
      background: #363D47;
      border: 1px solid green;
    }
    .more:hover {
      background: green !important;
      color: red !important;
    }

  </style>
@endsection


@section('main-content')
{{-- publication  list --}}
        <div class="author-list py-2 publication-items">
          <div class="row justify-content-center">
            <div class="col-md-10">
              <div class="container">
                <div class="row">
                @php
                  $itemCount = 1;
                @endphp
                @foreach ($publications as $publication)
                  @if ($curentPublication->id == $publication->id)
                    <span class="px-2 mr-3 my-1 publication-block active">
                      <a class="publication-item" href="{{ route('publication', $publication->id) }}">{{$publication->name}}</a>
                    </span>
                    @else
                      <span class="px-2 mr-3 my-1 publication-block">
                        <a class="publication-item" href="{{ route('publication', $publication->id) }}">{{$publication->name}}</a>
                      </span>
                  @endif
                  @php
                  if ($itemCount>11) {
                    echo
                    '<span class="px-2 mr-3 my-1 more">
                      <a class="publication-item" href="/all-publication/">More publication</a>
                    </span>';
                    break;
                  }
                    $itemCount++;
                  @endphp
                @endforeach
              </div>
            </div>
            </div>
          </div>
        </div>


        <div class="row my-3">
          <div class="mx-auto">
            <div class="card text-center" style="width: 180px;">
              <div class="card-body publication">
                <a href="{{ route('publication', $curentPublication->id) }}">
                  <img class="card-img-top" src="{{ asset('public_user/images/publication.jpg') }}" style="height: 140px; width: 120px;" alt="Publication">
                </a>
              </div>
              <div class="card-footer px-0 pt-1 pb-0">
                <p>By
                  <a style="text-decoration: none; color: black !important; font-weight: bold" href="{{ route('publication', $curentPublication->id) }}">
                    {{ $curentPublication->name }}
                  </a>
                </p>
              </div>
            </div>
          </div>
        </div>
        @php
          $totalBook = 0;
        @endphp
        @foreach ($products as $book)
            @if ($curentPublication->id == $book->publication_id)
              @php
                $totalBook++;
              @endphp
            @endif
        @endforeach
        @if ($totalBook > 0)
        <!-- New publication -->
        <div  class="row m-0 p-0">



          <div id="new_published" class="carousel slide col-md-10 mx-auto px-0">
            
                
            <div class="text-center py-3" style="background: #B3DCED">
              <h3>More Related Books of {{ $curentPublication->name }} Publication's </h3>
            </div>
            
            <!-- carousel inner -->
            <div class="row my-5 clearfix px-3">


                    @foreach ($products as $book)
                      @if ($curentPublication->id == $book->publication_id)

                      <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12 text-center mb-4">
                        <div class="con">
                          <div class="custom-container mx-3">

                            <img src="{{ asset('product/'.$book->image) }}" style="height: 220px; width: 100%" alt="Avatar" class="image">
                            <div class="middle m-0 p-0">
                              <div class="text m-0 p-0">
                                <a class="btn btn-primary" href="{{ route('single.help', $book->id) }}">View Details</a>
                                <br><br>
                                <a class="btn btn-success" href="{{ route('cart.create', $book->id) }}">Add to Cart</a>
                              </div>
                            </div>

                            <label style="margin-top: 5px; margin-bottom: 0; font-size: 16px;">
                                {{ $book->name }}
                            </label><br>

                            <label style="margin-top: 0; margin-bottom: 0; font-size: 12px;">
                                {{ $book->price }} Tk.
                            </label>
                          </div>
                        </div>
                      </div>

                    @endif
                @endforeach

            </div> 	<!-- end carousel inner -->
            @endif
          </div>

      </div>    <!-- New Publications end -->


</div>   <!-- bg end -->
@endsection

@section('additional_script')
  <script src="{{asset('public_user/js/scroll_tooltip.js')}}"></script>
@endsection
