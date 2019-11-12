@extends('master.public')

@section('page-title')
Online Bus Ticket Reservation System
@endsection

@section('additional_script')

@endsection





@section('main-content')
{{-- <div class="row">
  <div class="col-md-8 mx-auto">
    @if (session()->has('success'))
    @include('public_user.success-alert')
    @endif
  </div>
</div>
 --}}

<div class="container-fluid">
  <div class="clearfix"></div>
  <div class="row">
    {{-- Baner slider --}}
      @include('public_user.inc.search')
    {{-- Baner slider --}}
      @include('public_user.inc.banner_slider')
  </div>
</div>
@endsection
@section('addition-styles')
  <style>
    .srch_container {
        padding: 10px;
        /* border-top: 2px solid #079d49; */
        border-bottom: 2px solid #079d49;
        /* background: #ffffff; */
        font-size: 12px;
        margin-bottom: 30px;
    }
  </style>
@endsection
@section('additional_script')
<script src="{{ asset('public_user/js/scroll_tooltip.js') }}"></script>
@endsection
