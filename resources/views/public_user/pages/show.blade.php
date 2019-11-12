
@extends('master.public')

@section('page-title')
  Home - View Product Detail
@endsection


@section('main-content')
  <div class="container clearfix">

    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a style="color: black !important" href="/">Home</a></li>
        <li class="breadcrumb-item"><a style="color: black" href="#">View Detail</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
      </ol>
    </nav>

        <div class="row py-3">
            <div class="col-lg-3 col-md-5 col-sm-7 mb-2">
              <a target="_blank" href="{{ asset('product/'.$product->image) }}"><img style="width: 100%; height: 350px;" class="img-left img-thumbnail" src="{{ asset('product/'.$product->image) }}"/></a>
            </div>
            <div class="content-heading col-lg-9 col-md-7 col-sm-12 mb-2">
              <h4>{{ $product->name }}</h4>
              <p>{{ $product->author->name }} (Author)</p>
              <p>Our Price : Tk. {{ $product->price }}
                @if ($product->offer)
                  <span class="text-danger font-weight-bold mx-2">({{ $product->offer}}% OFF)</span>
                  <span class="text-success">Regular Price : Tk. {{ $product->price - (($product->offer/100) * $product->price) }} </span>
                @endif
                </p>
              <p>Category : {{ $product->category->name }}</p>
              @if ($product->isbn_no)
                <p>ISBN No : {{ $product->isbn_no }}</p>

              @endif
              <p>Publication : {{ $product->publication->name }}</p>
              <br>
              <p>
                <a class="btn btn-primary btn-sm" href="/">Back</a>
                <a class="btn btn-success btn-sm" href="{{ route('cart.create', $product->id) }}">Add to Cart</a>

              </p>
          </div>
       </div>

       <div id="new_published" class="carousel row mr-auto px-0">


         <div class="clearfix px-3">


             <div class="">
               <div class="row" >
                 <div class="mb-5 py-3 col-12" style="background: #4FBFA8; letter-spacing: 3px; text-transform: uppercase">
                   <div class="container text-center text-light">
                       <h3 class="text-center font-weight-bold" >related books</h3>
                   </div>
                 </div>
                 @include('public_user.inc.product-card')


             </div>
           </div>
         </div> 	<!-- end carousel inner -->

       </div>
  
   </div>    <!-- New Publications end -->


@endsection
