<div class="row">
      @php
        $count = 0;
      @endphp
      @foreach ($products as $book)
        @php
          if ($count%5 == 0) {
          echo '<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12">';
          } else {
            echo '<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12">';
          }
          $count++;
        @endphp
        {{-- <div class="col-md-2 text-center mx-auto mb-4"> --}}
      {{-- <div class="col-md-2"> --}}
        <div class="item">
          <div class="product" style="height: 270px;">
            <div class="flip-container">
              <div class="flipper">
                <div class="front"><a href="{{ route('single.help', $book->id) }}"><img style="height: 180px; width: 100%" src="{{ asset('product/'.$book->image) }}" alt="" class="img-fluid"></a></div>
                <div class="back"><a href="{{ route('single.help', $book->id) }}"><img style="height: 180px; width: 100%" src="{{ asset('product/'.$book->image) }}" alt="" class="img-fluid"></a></div>
              </div>
            </div><a href="{{ route('single.help', $book->id) }}" class="invisible"><img style="height: 180px; width: 100%" src="{{ asset('product/'.$book->image) }}" alt="" class="img-fluid"></a>

              <div class="text-center mt-2 pt-2">
              <h6>{{ $book->name }}</h6>
              <p class="price">
                {{ $book->price }} Tk.
              </p>
              </div>


              <!-- discount or off-->
              @if ($book->offer > 0)
                <div class="ribbon sale">
                  <div class="theribbon">
                  {{ $book->offer }}% Off</div>
                  <div class="ribbon-background"></div>
                </div>;
              @endif

              <!-- view product-->
              <div class="ribbon new">
                <div class="theribbon"><a style="color: white; text-decoration: none; display: block" href="{{ route('single.help', $book->id) }}">View</a> </div>
                <div class="ribbon-background"></div>
              </div>

              <!-- add to cart-->
              <div class="ribbon gift">
                <div class="theribbon pr-0">
                  <a style="color: white; text-decoration: none; display: block" href="{{ route('cart.create', $book->id) }}">Add to Cart</a>
                </div>
                <div class="ribbon-background"></div>
              </div>

          </div>
        </div>
      </div>



      @endforeach
  </div>
  @php
    $i = $count%5;
  @endphp
  @while ($i <= 5)
    <div class="col-md-2 text-center mx-auto my-4">

    </div>
    @php
      $i++;
    @endphp
  @endwhile
  {{ $products->links() }}
</div>
