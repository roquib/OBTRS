
@extends('master.public')

@section('page-title')
  Payment Finalize
@endsection

@section('additional_script')
  <link rel="stylesheet" href="{{ asset('public_user/css/setting_prepend.css') }}" type="text/css">
  <script type="text/javascript" src="{{ asset('public_user/js/payment.js') }}"></script>
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
    $totalItem        = 0;
    $totalQty         = 0;
    $cartTotal        = 0;
    $delivery_charge  = 0;
    $discount         = 0;
    $tax              = 0;
    $grandTotal       = 0;


  @endphp
  @if(!empty(Session::get('delivery_charge')))
     @php $delivery_charge = Session::get('delivery_charge'); @endphp
  @endif
  @foreach ($cartProducts as $product)
    @php
      $totalQty += $product->qty;
      $totalItem++;
      $cartTotal += ($product->qty * $product->price);
      $tax = intval(((2*$cartTotal)/100));
      $grandTotal = $cartTotal - $discount + $tax + $delivery_charge;
    @endphp
  @endforeach

  <div class="bg m-0">

    <div class="col-md-10 mx-auto my-2 px-0">

      <div class="progress-title mt-2 p-0" style="width: 100%;">

        <!-- SHIPPING TITLE TITLE -->
        <div class="work-headers m-0 p-0">
          <h5 class="py-2 px-3 m-0 text-light" style = "background-color: #2979F3; letter-spacing: 3px; font-size: 20px; font-weight: bold;">
            Payment Term
          </h5>
        </div>

        <div class="row py-3 px-2">
          <div class="col-md-8">
            <div class="row mt-3">
              <div class="col-md-3 text-center">
                <a id="cash" href="#">
                  <img class="img-thumbnail payment-cash payment mx-2" src="{{ asset('public_user/images/cash.jpg') }}" style="height: 120px; background: #2979F3; width: 180px;" alt="">
                </a>
                <h6 class="my-3 cash-text p-text" style="color: green">Cash on delivery</h6>
              </div>
              <div class="col-md-3 text-center">
                <a id="bkash" href="#">
                  <img class="img-thumbnail payment-bkash payment mx-2" src="{{ asset('public_user/images/bkash.jpg') }}" style="height: 120px; width: 180px;" alt="">
                </a>
                <h6 class="my-3 bkash-text p-text">Payment by Bkasah</h6>
              </div>
              {{-- <div class="col-md-3 text-center">
                <a id="dbbl" href="#">
                  <img class="img-thumbnail payment-dbbl payment mx-2" src="{{ asset('public_user/images/dbbl.jpg') }}" style="height: 120px; width: 180px;" alt="">
                </a>
                <h6 class="my-3 dbbl-text p-text">payment by DBBL</h6>
              </div> --}}

            </div>
            <br><br>


            <!-- Cash on delivery section -->
            <div id="sec-cash" class="my-2" >
              <form action="{{ route('order.submit') }}" method="post">
                @csrf
                <input type="hidden" name="type" value="0">
                <input type="hidden" name="amount" value="<?php echo $grandTotal; ?>">
                <input type="hidden" name="transaction_id" value="">

                <div class="">
                  <h4 class="bg-primary py-3 text-light text-center" style="border-radius: 5px">Cash on delivery</h4>
                </div>
                <h6 class="text-primary"><span class="pb-1" style="border-bottom: 2px solid green;">Terms and conditions</span></h6>
                <p>
                  The process of cash on delivery is available only for dhaka city. When you confirm your order then you can collect your ordered book from our warehouse/shop
                  or from your own house. If you want to get the product physically then there is no extra cost without your ordered cost. If you want to get the product from
                  your house then you should pay an additional shipping cost. Shipping cost is fixed depend on your zone.
                </p>
                <div class="custom-control custom-checkbox mb-2">
                  <input type="checkbox" required class="custom-control-input" id="aggrement">
                  <label class="custom-control-label font-weight-normal pt-1" style="font-size: 14px; cursor: pointer;" for="aggrement"> Agree with the condition? </label>
                </div>
                
                <p class="mt-3">
                  <a class="btn btn-sm btn-outline-primary px-4" style="border-radius: 50px;" href="{{ asset('/') }}">Continue Shopping</a>
                  <a class="btn btn-sm btn-outline-info px-4" style="border-radius: 50px;" href="{{ route('home.shipping.product') }}">Preview order</a>

                    <button type="submit" onclick="return confirm('Are you sure to submit order?')" class="btn btn-sm btn-outline-success px-4 float-right" style="border-radius: 50px;">Submit Order</button>
                  </form>
                </p>
            </div>

            <!-- BKASH Payment section -->
            <div id="sec-bkash" class="my-2" >
              <div class="">
                <h4 class="bg-primary py-3 text-light text-center" style="border-radius: 5px">Pay by bkash</h4>
              </div>
              <label class="text-light p-2 mb-1 bg-primary m-0" style="letter-spacing: 2px;">Terms and conditions</label>
              <div class="bg-danger m-0" style="height: 3px"> </div>

              <div class="text-center mt-1" style="font-size: 24px">
                <label class="text-primary">How to Make Payment using </label>
                <label class="text-danger">Bkash Account</label>
              </div>
              <h6 class="text-center">If you have a bKash account then follow the steps below</h6>
              <div class="bg-danger m-0" style="height: 2px"> </div>

              <div class="mx-5">
                <table class="table">
                  <tr>
                    <td class="text-primary h5" style="width: 150px;">Step 1</td>
                    <td class="text-danger h5">Dial *247#</td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="text-primary h5">Step 2</td>
                    <td class="text-danger h5">Choose Option "Payment"</td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="text-primary h5">Step 3</td>
                    <td class="text-danger h5">Enter Merchant bKash Account: 01745501406</td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="text-primary h5">Step 4</td>
                    <td class="text-danger h5">Enter Amount: 520.00</td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="text-primary h5">Step 5</td>
                    <td class="text-danger h5">Enter Reference: 92628</td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="text-primary h5">Step 6</td>
                    <td class="text-danger h5">Enter Counter No: 1</td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="text-primary h5">Step 7</td>
                    <td class="text-danger h5">Enter Your Pin to Confirm the Transaction: XXXX</td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="text-primary h5">Step 8</td>
                    <td class="text-danger h6">
                      Enter your transaction Id to complete your transaction received from bKash
                      <form action="{{ route('order.submit') }}" method="post">
                        @csrf
                        <input type="hidden" name="type" value="1">
                        <input type="hidden" name="amount" value="<?php echo $grandTotal; ?> ">

                        <p class="mt-2">TrxID:
                          <input class="px-2" required name="transaction_id" style="height: 35px; border: 1px solid #0069D9; border-radius: 5px;" type="text" placeholder="Your transaction id"></p>
                        <input type="submit" class="btn btn-success btn-sm px-4" name="" value="Submit">
                      </form>
                    </td>
                    <td></td>
                  </tr>

                </table>
              </div>
            </div>
            <div id="sec-dbbl" class="my-2" >
                Dbbl payment system
            </div>

          </div>

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
                   <td>Delivery Charge</td>
                   <td class="text-right pr-2">@php echo $delivery_charge; @endphp Tk</td>
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
      </div>
    </div>



    </div>




  </div>
  @endif
@endsection
