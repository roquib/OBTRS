
@extends('master.public')

@section('page-title')
  Order Success
@endsection

@section('main-content')
  @if ($order == null)
    <div class="container">
      you don't have any order
    </div>
  @else
  <div class="container my-5">
    <div id="invoice">
      <h2 class="text-center">Congratulations, <strong style="font-size: 18px;">{{ $order->name }}</strong>

      </h2>
      <p class="text-center">Dear customer, We have got your order, we will check and inform you as early as possible.</p>

      <strong>Ordered Date: {{ $order->created_at }}</strong> <br>
      <strong>Order No.: #0002{{ $order->id }}</strong>

      @php
      $zoneOption = array("Inside Dhaka", "Gazipur District",
      "Other's District in dhaka division",
      "Rangpur division","Rajshahi Division","Chittagang Division",
      "Syllet Division","Maymunsing Division","Own Delivery");

      @endphp
      <div class="row mt-4">
        <div class="col-md-6">
          <strong>Order Details</strong>
          <table class="table table-sm">
            <tr>
              <td>Sln</td>
              <td>Book Name</td>
              <td>Quantity</td>
              <td>Price</td>
              <td class="text-right pr-4">Subtotal</td>
            </tr>
            @php
              $item = 1;
              $itemTotal = 0;
              
            @endphp
            @foreach ($order->orderedProduct as $product)
              <tr>
              <td>@php echo $item++; @endphp</td>
              <td>
                @foreach ($products as $pro)
                    @if ($product->product_id == $pro->id)
                        {{ $pro->name }}
                    @endif
                @endforeach
              </td>
              <td>{{ $product->quantity }}</td>
                <td>{{ $product->price }} Tk.</td>
                @php $itemTotal += $product->quantity * $product->price; @endphp
                <td class="text-right pr-4">{{ $product->quantity * $product->price }} Tk.</td>
              </tr>
              {{-- <tr>
                <td>@php echo $item++; @endphp</td>
                <td>{{ $products[$product->id]->name }}</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ $product->price }} Tk.</td>
                @php $itemTotal += $product->quantity * $product->price; @endphp
                <td class="text-right pr-4">{{ $product->quantity * $product->price }} Tk.</td>
              </tr> --}}
            @endforeach
            <tr>
              <td colspan="3"></td>
              <td>Total Price</td>
              <td class="text-right pr-4">@php echo $itemTotal; @endphp Tk.</td>
            </tr>
            <tr>
              <td colspan="3"></td>
              <td>Shipping</td>
              <td class="text-right pr-4">{{ $order->shipping_cost }} Tk.</td>
            </tr>
            <tr>
              <td colspan="3"></td>
              <td>Tax</td>
              <td class="text-right pr-4">{{ $order->tax }} Tk.</td>
            </tr>
            <tr>
              <td colspan="3"></td>
              <td>Grand Total</td>
              <td class="text-right pr-4">{{ $order->shipping_cost + $itemTotal + $order->tax }} Tk.</td>
            </tr>
          </table>
        </div>


        <div class="col-md-5 ml-auto">
          <strong>Shipping Details</strong>
          <table class="table table-sm">
            <tr>
              <td>Your Email</td>
              <td>{{ $order->email }}</td>
            </tr>
            <tr>
              <td>Your Mobile</td>
              <td>{{ $order->mobile }}</td>
            </tr>
            <tr>
              <td>Contact Person</td>
              <td>{{ $order->contact_person }}</td>
            </tr>
            <tr>
              <td>Reciever Mobile</td>
              <td>{{ $order->contact_mobile }}</td>
            </tr>
            <tr>
              <td>Zone</td>
              <td> @php echo $zoneOption[$order->zone]; @endphp </td>
            </tr>
            <tr>
              <td>Address</td>
              <td>{{ $order->address }}</td>
            </tr>

          </table>
        </div>

      </div>

      <div class="text-center">
        If you need any information please contact with this number <strong style="color: green">+8801976-829262</strong> or you can <a target="_blank" style="color: green; text-decoration: none;" href="{{ route('contact') }}"> <strong>Email</strong> </a> us. We are always ready to servive you. <br> If you feel that you are satisfied with our service, you will most definitely buy a book from us.<strong class="text-primary">Thanks from Soptoborno</strong>.
      </div>
    </div>


    <a href="#" class="btn btn-outline-success btn-sm px-3" onclick="printInvoice('invoice')" style="border-radius: 50px;">Print</a>
    {{-- <a class="btn btn-outline-success btn-sm px-3" style="border-radius: 50px;" href="{{ route('invoice', 6) }}">Save Order</a> --}}
    <a class="btn btn-outline-primary btn-sm px-3" style="border-radius: 50px;" href="{{ route('home') }}">Home</a>

  </div>

  @endif
@endsection



@section('additional_script')
  <script>
    function printInvoice(el) {
      var restorepage  = $('body').html();
      var printcontent = $('#' + el).clone();
      var enteredtext  = $('#printable').val();
      $('body').empty().html(printcontent);
      window.print();
    }
  </script>
@endsection
{{-- http://127.0.0.1:8000/order/invoice/27 --}}