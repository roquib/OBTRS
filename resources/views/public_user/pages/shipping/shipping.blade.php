
@extends('master.public')

@section('page-title')
  Product Shipping
@endsection

@section('addition-styles')
  <link rel="stylesheet" href="{{ asset('css/custom/setting_prepend.css') }}" type="text/css">
@endsection




@section('main-content')


  @if ($cartProducts->isEmpty())
    <div class="w-100 py-5 text-center" style="background: #EAF8FC">
      <div class="col-md-10 mx-auto py-5">
        <h3>Sorry, You don't buy any product please buy something</h3>
        <a class="btn btn-outline-primary btn-sm" href="/">Home</a>
      </div>
    </div>
  @else

  @php
    $customer_name   = "";
    $customer_mobile = "";
    $email           = "";
    $contact_person  = "";
    $reciver_number  = "";
    $zone            = 0;
    $address         = "";
    $delivery_charge = "";

    // Cart Variable
    $totalItem        = 0;
    $totalQty         = 0;
    $cartTotal        = 0;
    $delivery_charge  = 0;
    $discount         = 0;
    $tax              = 0;
    $grandTotal       = 0;

    $zoneOption = array("Inside Dhaka", "Gazipur District",
    "Other's District in dhaka division",
    "Rangpur division","Rajshahi Division","Chittagang Division",
    "Syllet Division","Maymunsing Division","Own Delivery");

  @endphp
  @foreach ($cartProducts as $product)
    @php
      $totalQty += $product->qty;
      $totalItem++;
      $cartTotal += ($product->qty * $product->price);
      $tax = intval(((2*$cartTotal)/100));
      $grandTotal = $cartTotal - $discount + $tax;
    @endphp
  @endforeach


  @if(!empty(Session::get('customer_name')))
     @php $customer_name = Session::get('customer_name'); @endphp
  @endif
  @if(!empty(Session::get('customer_mobile')))
     @php $customer_mobile = Session::get('customer_mobile'); @endphp
  @endif
  @if(!empty(Session::get('email')))
     @php $email = Session::get('email'); @endphp
  @endif
  @if(!empty(Session::get('contact_person')))
     @php $contact_person = Session::get('contact_person'); @endphp
  @endif
  @if(!empty(Session::get('reciver_number')))
     @php $reciver_number = Session::get('reciver_number'); @endphp
  @endif
  @if(!empty(Session::get('zone')))
     @php $zone = Session::get('zone'); @endphp
  @endif
  @if(!empty(Session::get('address')))
     @php $address = Session::get('address'); @endphp
  @endif
  @if(!empty(Session::get('delivery_charge')))
     @php $delivery_charge = Session::get('delivery_charge'); @endphp
  @endif


  <div class="bg m-0">

    <div class="col-md-9 mx-auto my-3 px-0">
      <!-- SHIPPING TITLE TITLE -->

      {{-- form start --}}
      {!! Form::open([ 'url' => route('home.shipping.cart'), 'method'=>'post', 'role'=>'form', 'enctype'=>'multipart/form-data', 'name'=>'productEditForm']) !!}

      <div class="mx-0">
          <!-- Shopping heading -->
          <div class="work-headers m-0 p-0">
            <h5 class="py-3 px-3 m-0 text-light font-weight-bold" style="background: #4FBFA8; letter-spacing: 3px; text-transform: uppercase">
              Shipping Information
            </h5>
          </div>
          <!-- End Shopping heading -->



          <!-- Slider + Order Summery -->
          <div class="row py-3 ml-0">
            <!-- Slider -->
            <div class="col-md-8 px-0">

              <!-- Image Slider -->
              <div id="baner_carousel" class="carousel slide product-delivery px-0 mx-0 mb-4" data-ride="carousel" style="height:250px; border-top: 2px solid gray; border-bottom: 2px solid gray;">

                  <!-- Carousel Indicator -->
                  <ul class="carousel-indicators">
                    <li data-target="#baner_carousel" data-slide-to="0" class="active"></li>
                    <li data-target="#baner_carousel" data-slide-to="1"></li>
                    <li data-target="#baner_carousel" data-slide-to="2"></li>
                    <li data-target="#baner_carousel" data-slide-to="3"></li>
                  </ul>
                  <!-- End Carousel Indicator -->

                  <!-- carousel inner body -->
                  <div class="carousel-inner">
                      <div class="carousel-item active">
                        <img src="{{asset('public_user/images/delivery/delivery (1).jpg')}}" alt=""  style="height:250px; width: 100%">
                      </div>

                      <div class="carousel-item">
                        <img src="{{asset('public_user/images/delivery/delivery (2).jpg')}}" alt=""  style="height:250px; width: 100%">
                      </div>

                      <div class="carousel-item">
                        <img src="{{asset('public_user/images/delivery/delivery (3).jpg')}}" alt="" style="height:250px; width: 100%">
                      </div>

                      <div class="carousel-item">
                        <img src="{{asset('public_user/images/delivery/delivery (4).jpg')}}" alt="" style="height:250px; width: 100%">
                      </div>

                    </div> 	<!-- end carousel inner -->
                  <!-- End carousel inner body -->

                  <!-- arrow buttons -->
                  <a class="carousel-control-prev" href="#baner_carousel" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                  </a>
                  <a class="carousel-control-next" href="#baner_carousel" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                  </a>
                  <!-- end arrow buttons -->
              </div>
            </div>
            <!-- End Slider -->

            <!-- Order Summery -->
            <div class="col-md-4 ml-auto">
              <div class="p-0" style="width: 100%; border: 1px solid #166C8A;">

                <div class="work-headers m-0 p-0 mb-">
                  <h5 class="text-center p-2 m-0 text-light" style = "background: #166C8A; font-size: 20px; font-weight: bold;">
                    Order Summary
                  </h5>
                </div>

                <div class="group mx-3 py-2">
                   <table class="table table-sm">
                    <tr>
                     <td>Total Item</td>
                     <td class="text-right pr-2">@php echo $totalItem; @endphp</td>
                    </tr>
                    <tr>
                     <td>Total Quantity</td>
                     <td class="text-right pr-2">@php echo $totalQty; @endphp Pcs</td>
                    </tr>
                    <tr>
                     <td>Total Price</td>
                     <td class="text-right pr-2">@php echo $cartTotal; @endphp Tk</td>
                    </tr>
                    <tr>
                     <td>Discount</td>
                     <td class="text-right pr-2">(-) @php echo $discount; @endphp Tk</td>
                    </tr>
                    <tr>
                     <td>Estimated Tax</td>
                     <td class="text-right pr-2">(+) @php echo $tax; @endphp Tk</td>
                    </tr>
                    <tr>
                     <td class="font-weight-bold">Total</td>
                     <td class="text-right pr-2">@php echo $grandTotal; @endphp Tk</td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <!-- End Order Summery -->
          </div>
          <!-- End Slider + Order Summery -->




          <!-- Shipping info + Zon wise shipping cost -->
          <div class="row py-3 ml-0">


            <!-- Shipping info form -->
            <div class="col-md-8">
                <div class="text-center text-dark mb-3" style="background:#4FBFA8;">
                  <span style="line-height: 40px; letter-spacing: 1px;">
                    Fillup shipping information for your ordered books.
                  </span>
                </div>

                <!-- Your name -->
                <div class="input-group parent-top" >
                  <div class="bg-secondary input-group-prepend label_parent">
                    <label class="input-group-text">Your Name</label>
                  </div>
                  <input name="customer_name" type="text" class="form-control
                  @if($errors->has('customer_name'))is-invalid @endif
                  " value="<?php echo $customer_name; ?>" placeholder="Your Name" autofocus>
                </div>
                <div class="text-danger ml-auto text-center">
                  <small>{{ $errors->first('customer_name') }}</small>
                </div>

                <!-- Mobile Number -->
                <div class="input-group parent-top mt-2" >
                  <div class="bg-secondary input-group-prepend label_parent">
                    <label class="input-group-text">Your Mobile No.</label>
                    <span class="text-danger" id="customer_mobile_error"></span>
                  </div>
                  <input name="customer_mobile" type="number" class="form-control
                  @if($errors->has('customer_mobile'))is-invalid @endif
                  " value="<?php echo $customer_mobile ?>" placeholder="Mobile number" autofocus>
                </div>
                <div class="text-danger ml-auto text-center">
                  <small>{{ $errors->first('customer_mobile') }}</small>
                </div>

                <!-- Email -->
                <div class="input-group parent-top mt-2" >
                  <div class="bg-secondary input-group-prepend label_parent">
                    <label class="input-group-text">Email Address</label>
                  </div>
                  <input name="email" type="email" class="form-control
                
                " value="<?php echo $email; ?>" placeholder="Email Address" autofocus>
              </div>
              




                <!-- Contact Person -->
                <div class="input-group parent-top mt-2" >
                  <div class="bg-secondary input-group-prepend label_parent">
                    <label class="input-group-text">Contact Person</label>
                  </div>
                  <input name="contact_person" class="form-control @if($errors->has('contact_person'))is-invalid @endif
                  " value="<?php echo $contact_person; ?>" placeholder="Contact Person/Reciever" autofocus>
                </div>
                <div class="text-danger ml-auto text-center">
                  <small>{{ $errors->first('contact_person') }}</small>
                </div>

                <!-- Contact Number -->
                <div class="input-group parent-top mt-2" >
                  <div class="bg-secondary input-group-prepend label_parent">
                    <label class="input-group-text">Mobile Number</label>
                  </div>
                  <input name="reciver_number" class="form-control @if($errors->has('reciver_number'))is-invalid @endif
                  " value="<?php echo $reciver_number; ?>" placeholder="01xxxxxxxxx" autofocus>
                </div>
                <div class="text-danger ml-auto text-center">
                  <small>{{ $errors->first('reciver_number') }}</small>
                </div>


                <!-- Zone -->
                <div class="input-group parent-top mt-2" >
                  <div class="bg-secondary input-group-prepend label_parent">
                    <label class="input-group-text">Zone</label>
                  </div>

                  <select class="form-cntrol" name="zone">
                    <option value="<?php echo $zone; ?>"><?php echo $zoneOption[$zone]; ?></option>
                    @for ($i=0; $i < 9; $i++)
                      @if ($i != $zone)
                      <option value="<?php echo $i; ?>"><?php echo $zoneOption[$i]; ?></option>
                      @endif
                    @endfor

                  </select>
                </div>

                <!-- Address -->
                <div class="input-group parent-top mt-2" >
                  <div class="bg-secondary input-group-prepend label_parent">
                    <label class="input-group-text">Address</label>
                  </div>
                  <textarea name="address" class="@if($errors->has('address'))border-danger @endif" placeholder="Shipping address" rows="3" cols="80">@php echo $address @endphp</textarea>
                </div>
                <div class="text-danger ml-auto text-center">
                  <small>{{ $errors->first('address') }}</small>
                </div>



              </div>
              <!-- End Shipping info form -->


            <!-- Zone wise shipping cost -->
            <div class="col-md-4 ml-auto">
              <div class="p-0" style="width: 100%; border: 1px solid #166C8A;">
                <div class="work-headers m-0 p-0">
                  <h5 class="text-center p-2 m-0 text-light" style = "background: #166C8A; font-size: 20px; font-weight: bold;">
                     Zone wise shipping charge
                  </h5>
                </div>

                <div class="group mx-2">
                  <table class="table table-sm">
                    <tr>
                      <td>Inside Dhaka</td>
                      <td class="text-right pr-2" style="width:600x">30 Tk</td>
                    </tr>
                    <tr>
                      <td>Gazipur District</td>
                      <td class="text-right pr-2" style="width: 70px">50 Tk</td>
                    </tr>
                    <tr>
                      <td>Other's District in dhaka division</td>
                      <td class="text-right pr-2" style="width: 70px">70 Tk</td>
                    </tr>
                    <tr>
                      <td>Rangpur division</td>
                      <td class="text-right pr-2" style="width: 70px">100 Tk</td>
                    </tr>
                    <tr>
                      <td>Rajshahi Division</td>
                      <td class="text-right pr-2" style="width: 70px">100 Tk</td>
                    </tr>
                    <tr>
                      <td>Chittagang Division</td>
                      <td class="text-right pr-2" style="width: 70px">100 Tk</td>
                    </tr>
                    <tr>
                      <tr>
                        <td>Syllet Division</td>
                        <td class="text-right pr-2" style="width: 70px">90 Tk</td>
                      </tr>
                      <tr>
                        <td>Maymunsing Division</td>
                        <td class="text-right pr-2" style="width: 70px">80 Tk</td>
                      </tr>
                      <tr>
                        <td>Own Delivery</td>
                        <td class="text-right pr-2" style="width: 70px">No Cost</td>
                      </tr>
                    </table>
                </div>
              </div>
            </div>
            <!-- End Zone wise shipping cost -->
          </div>
          <!-- Shipping info + Zon wise shipping cost -->








          {{-- submit shipping info --}}
          <table class="table mt-5">
            <tfoot class="p-5">
              <tr>
                <td colspan="2">
                    <a class="btn btn-sm btn-primary px-4" style="border-radius: 50px;" href="{{ asset('/') }}">Continue Shopping</a>
                  </td>
                  <td colspan="6" class="text-right" >
                    <button type="submit" class="btn btn-sm btn-outline-success px-4" style="border-radius: 50px;" href="">Checkout</button>
                  </td>
                </tr>
              </tfoot>
          </table>
          {{-- END submit shipping info --}}




      </div>
      {!! Form::close() !!}
    {{-- </form> --}}

    </div>
  </div>

  @endif
@endsection
