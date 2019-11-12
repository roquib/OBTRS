
@extends('master.public')

@section('page-title')
  Best Seller
@endsection

@section('additional_script')

@endsection




@section('main-content')
  <div class="box py-3 mb-5" style="background: #4FBFA8; letter-spacing: 3px; text-transform: uppercase">
    <div class="container text-center text-light">
        <h3 class="text-center font-weight-bold">Our Best Seller</h3>
    </div>
  </div>

  <div class="row">
    {{-- ==============   Product Section =================  --}}
    <div class="col-md-10 mx-auto">
        <div class="mr-5">
          @include('public_user.inc.product-card')
        </div>
        {{-- <div class="float-center mb-5">
          {{ $products->links() }}
        </div> --}}
    </div>
    {{-- End Product Section --}}
  </div>

@endsection
