@extends('master.public')

@section('page-title')
Online Bus Ticket Reservation System
@endsection

@section('additional_script')

@endsection





@section('main-content')
<div class="row">
  <div class="col-md-8 mx-auto">
    @if (session()->has('success'))
    @include('public_user.success-alert')
    @endif
  </div>
</div>


{{-- Baner slider --}}
<div class="container">
  @include('public_user.inc.search')
</div>
{{-- Baner slider --}}
<div class="">
  @include('public_user.inc.banner_slider')
</div>


{{-- Book group --}}
@include('public_user.inc.book_group')

<div class="row">

  <div class="col-md-12 mx-auto">
    <div class="row">



      <!-- Category Lists Sidebar -->
      <div class="col-md-3 col-lg-3 col-sm-12" style="height: 100%;">
        @include('public_user.inc.sidebar-category')
      </div>
      <!-- End Category Lists Sidebar -->



      {{-- ==============   Product Section =================  --}}
      <div class="col-md-8 col-lg-8 col-sm-10 mx-auto">
        @include('public_user.inc.product-card')


      </div>
      {{-- End Product Section --}}


    </div>
  </div>
</div>
<br><br>

@endsection

@section('additional_script')
<script src="{{ asset('public_user/js/scroll_tooltip.js') }}"></script>
@endsection
