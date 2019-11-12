
@extends('master.public')

@section('page-title')
  Novel List
@endsection

@section('additional_script')

@endsection




@section('main-content')
  

    <div class="box py-3 mb-5" style="background: #4FBFA8; letter-spacing: 3px; text-transform: uppercase">
    	<div class="container text-center text-light">
    			<h3 class="text-center font-weight-bold">All Novel</h3>
    	</div>
    </div>


    <div class="row">
      <div class="col-md-9 mx-auto">
        <div class="row">

          {{-- ==============   Product Section =================  --}}
          {{-- <div class="col-md-10"> --}}
              @include('public_user.inc.product-card')
              <div class="float-right mb-5">
                {{ $products->links() }}
              </div>

          {{-- </div> --}}
          {{-- End Product Section --}}


       </div>

      </div>
    </div><!-- End Product + Category sidebar-->



@endsection

@section('additional_script')
  <script src="{{ asset('public_user/js/scroll_tooltip.js') }}"></script>
@endsection
