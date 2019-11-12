
@extends('master.public')

@section('page-title')
  Writer Information
@endsection

@section('additional_script')
  <link rel="stylesheet" href="{{ asset('public_user/css/homepage.css') }}">
  <style media="screen">
   .writer-items {
     background: #2A3038;
   }
    span a {
      color: white;
    }
    .writer-block {
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
{{-- Writer or Author list --}}
        <div class="author-list py-2 writer-items">
          <div class="row justify-content-center">
            <div class="col-md-10">
              <div class="container">
                <div class="row">
                @php
                  $itemCount = 1;
                @endphp
                @foreach ($authors as $author)
                  @if ($curentAuthor->id == $author->id)
                    <span class="px-2 mr-3 my-1 writer-block active">
                      <a class="writer-item" href="{{ route('writer', $author->id) }}">{{$author->name}}</a>
                    </span>
                    @else
                      <span class="px-2 mr-3 my-1 writer-block">
                        <a class="writer-item" href="{{ route('writer', $author->id) }}">{{$author->name}}</a>
                      </span>
                  @endif

                  @if ($itemCount>11) {
                    <span class="px-2 mr-3 my-1 more">
                      <a class="writer-item" href="{{ route('writer.list') }}">More Writer</a>
                    </span>
                    @php break; @endphp
                  @endif
                    {{ $itemCount++ }}
                @endforeach
              </div>
            </div>
            </div>
          </div>
        </div>


        <div class="row my-4 justify-content-center">
          <div class="col-md-10">
            <div  class="w-100 py-3 px-4 ">
              <h4 class="text-light"> {{ $curentAuthor->name }} </h4>
            </div>
            <div class="details row mx-0">
              <div class="col-lg-3 col-md-5 col-sm-7 mb-2 px-0">
                <img style="width: 100%; height: 250px;" class="img-left my-2" src="{{ asset('img/writer/'.$curentAuthor->image) }}" alt="{{ $curentAuthor->image }}"/>
              </div>
              <div class="content-heading col-lg-9 col-md-7 col-sm-10">
                <p class="px-2 pb-2 h-4">
                   <h5 style="line-height: 30px">
                   {{ $curentAuthor->description }}&nbsp;&nbsp;&nbsp;
                     <a class="text-success no-underline" href="{{ $curentAuthor->more_about }}" target="_blank">More Detail...</a> </h5>
                </p>
              </div>
            </div>
          </div>
        </div>
        @php
          $totalBook = 0;
        @endphp
        @foreach ($products as $book)
            @if ($curentAuthor->id == $book->author_id)
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
              <h3>{{ $curentAuthor->name }}'s More Books</h3>
            </div>
            <!-- carousel inner -->
            <div class="row clearfix px-3">

                    @foreach ($products as $book)
                      @if ($curentAuthor->id == $book->author_id)

                      <div class="col-md-2 text-center my-4">
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
          </div>

        </div>    <!-- New Publications end -->
        @endif

</div>   <!-- bg end -->
@endsection

@section('additional_script')
  <script src="{{asset('public_user/js/scroll_tooltip.js')}}"></script>
@endsection
