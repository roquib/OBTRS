@extends('master.public')

@section('page-title')
About Us
@endsection

@section('addition-styles')
<link rel="stylesheet" href="{{asset('css/custom/about_us.css')}}" type="text/css">
<style media="screen">
  .aboutus-image-baner {
    /* background:  linear-gradient(rgba(0,0,0,.7), rgba(0,0,0,.7)), url("{{ asset('public_user/images/aboutus-baner.jpeg') }}"); */
    background: url("{{ asset('public_user/images/aboutus-baner.jpeg') }}");
    min-height: 320px;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    padding-top: 110px;
    padding-bottom: 110px;
  }
</style>
@endsection




@section('main-content')
<div class="bg m-0" style="background: white !important">

  <!-- Top baner -->
  <div class="aboutus-image-baner pl-5 text-primary">
    <h2 class="font-weight-bold display-4">About Us</h2>
    <p>To know the details more about us see the information below</p>
  </div>

  <!-- Breadcrumb Page Director -->
  <ol class="breadcrumb pl-5">
    <li class="breadcrumb-item ml-5" aria-current="page"><a href="{{route('home')}}" class="font-weight-bold"
        style="color: #723B00 !important">Home</a> </li>
    <li class="breadcrumb-item active" aria-current="page">About Us</li>
  </ol>



  {{-- Service --}}
  <div class="container">
    <div class="row p-3">
      <div class="left-description col-md-6 px-5">
        <h1 class="text-center font-weight-bold display-4">Our Service</h1>
        <div class="text-justify" style="font-size: 18px;">
          We provide a ticket reservation system on bus throw online. If you want be our customer, you have to buy
          ticket from our website. You
          will more flexibility to get the tickets. You can your reserved your ticket from within a month. If you want
          to collect a ticket by hand cash you have to pay
          delivery charge. The delivery charge is minor. One more think you can pay in two ways. One is mobile banking
          <span class="text-danger">(paymen by bkash)</span> and another is cash on trip_points before trip two day. If
          you want to pay by
          hand cash
          at first you have to pay redbus82 charge.
        </div>
      </div>
      <div class="left-description col-md-6 p-3 text-justify">
        <h2 class="font-weight-bold pb-3">Our System</h2>
        <p>Redbus is an online ticketing system for buses. We offer online ticket for making your journey fun.
          Customer can buy tickets, cancel tickets, confirm bkash payment. Can Check bus status which livetracking is
          our main feature now. </p>
        <p>Our mission is help people to find and buy ticket and our business stretches around the county. Thousand of
          signed bus companies, </p>
        <p>Redbus remains a company with a passion for tickets. Bus Company loves redbus for helping them to sell
          tickets to customers around the globe – 24 hours a day, 365 days a year.</p>
      </div>
    </div>
  </div>





  {{-- Team Members --}}

  <div class="my-5">
    <div class="row">
      <div class="col-md-6 mx-auto">
        <h1 class="text-center font-weight-bold display-4">Our Team</h1>
        <div class="text-justify">
          <p class="text-center">Our team is always ready to take the order and deliver your necessary books to your
            mailing address after checking all requirements.</p>
          <hr class="px-5">
        </div>
      </div>
    </div>
  </div>



  <!-- Profile Card Section -->
  <div class="row mt-5">
    <div class=" col-md-10 col-sm-8 mx-auto">
      <div class="row">
        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-8 mx-auto mb-2">
          <div class="card">
            <img class="card-img mx-auto mt-0" src="{{ asset('public_user/Images/team/Tithi.jpg') }}" alt=""
              style="height: 220px;">
            <div class="card-body pt-1 text-center">
              <h5 class="font-weight-bold text-primary pt-2">Tithi Mitra</h5>
              <hr>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>

              <!-- Add font awesome icons -->
              <a target="_blank" href="https://www.facebook.com/tithi.mitro"
                class="social fa fa-facebook fa-facebooks"></a>
              <a href="#" class="social fa fa-twitter"></a>
              <a href="#" class="social fa fa-google"></a>
              <a href="#" class="social fa fa-envelope"></a>
            </div>
          </div>
        </div>


        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-8 mx-auto mb-2">
          <div class="card mx-0 px-0">
            <img class="card-img mx-auto mt-0" src="{{ asset('public_user/Images/team/Roquib.jpg') }}" alt=""
              style="height: 220px;">
            <div class="card-body pt-1 text-center">
              <h5 class="font-weight-bold text-primary pt-2">Abdur Roquib</h5>
              <hr>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>

              <!-- Add font awesome icons -->
              <a target="_blank" href="https://www.facebook.com/roquib.redbytes.org"
                class="social fa fa-facebook fa-facebooks"></a>
              <a href="#" class="social fa fa-twitter"></a>
              <a href="#" class="social fa fa-google"></a>
              <a href="#" class="social fa fa-envelope"></a>
            </div>
          </div>
        </div>


        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-6 mx-0 mb-2">
          <div class="card mx-0 px-0">
            <img class="card-img mx-auto mt-0" src="{{ asset('public_user/Images/team/Raju.jpg') }}" alt=""
              style="height: 220px;">
            <div class="card-body pt-1 text-center">
              <h5 class="font-weight-bold text-primary pt-2">Yasir Arafat Raju</h5>
              <hr>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>

              <!-- Add font awesome icons -->
              <a target="_blank" href="https://www.facebook.com/raju2k12"
                class="social fa fa-facebook fa-facebooks"></a>
              <a href="#" class="social fa fa-twitter"></a>
              <a href="#" class="social fa fa-google"></a>
              <a href="#" class="social fa fa-envelope"></a>
            </div>
          </div>
        </div>


        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-8 mx-auto mb-2">
          <div class="card">
            <img class="card-img mx-auto mt-0" src="{{ asset('public_user/Images/team/Razbin.jpg') }}" alt=""
              style="height: 220px;">
            <div class="card-body pt-1 text-center">
              <h5 class="font-weight-bold text-primary pt-2">Razbin Nahar</h5>
              <hr>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>

              <!-- Add font awesome icons -->
              <a target="_blank" href="https://www.facebook.com/people/Razbin-Islam/100008093837902"
                class="social fa fa-facebook fa-facebooks"></a>
              <a href="#" class="social fa fa-twitter"></a>
              <a href="#" class="social fa fa-google"></a>
              <a href="#" class="social fa fa-envelope"></a>
            </div>
          </div>
        </div>

      </div>


    </div>
  </div>



</div>

@endsection