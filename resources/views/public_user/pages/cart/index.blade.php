
@extends('master.public')

@section('page-title')
  Cart Manage
@endsection

@section('additional_script')

@endsection




@section('main-content')
  <div class="bg m-0">





    @if (!$cartProducts->isEmpty())
      <div class="w-100 py-4" style="background: #EAF8FC">
        <div class="col-md-10 mx-auto">
          <h3>Check in out</h3>
        </div>
      </div>


    <div class="col-md-9 mx-auto my-3 p-0">
      <table class="table table-striped">

        <tr>
          <td>Sln</td>
          <td>Book Name</td>
          <td>Image</td>
          <td>Qty</td>
          <td>Price</td>
          <td class="text-right">Subtotal</td>

          <td class="text-center"><a onclick="return confirm('Are you sure to clear all cart?')" href="{{ route('carts.destroy.all') }}" class="btn btn-outline-danger btn-sm px-3" style="border-radius: 50px">Clear Cart</a> </td>
        </tr>
          @php
            $total = 0;
          @endphp
          @foreach ($cartProducts as $product)
            <tr>
              <td>{{ $product->id }}</td>
              <td>{{ $product->name }}</td>
              <td>
                <img src="{{ asset('product/'.$product->image) }}" style="height: 100px; width: 90px;" alt="Cart product" class="image">
              </td>
              <td>
                {!! Form::open(['url' => route('carts.update'),'method' => 'POST']) !!}
                <input type="hidden" name="rowId" value="{{ $product->rowId }}">
                <input type="number" class="text-center" style="width: 50px; margin-top: 5px;" name="qty" value="{{ $product->qty }}">
                <button type="submit" onclick="return confirm('Are you sure to update quantity?')" class="btn btn-primary btn-sm" name="button">Update</button>
                {!! Form::close() !!}
              </td>
              <td>{{ $product->price }} Tk</td>
              <td class="text-right">{{ $product->qty * $product->price }} Tk</td>
              @php
                $total += ($product->qty * $product->price);
              @endphp
              <td class="text-center">
                <a onclick="return confirm('Are you sure to delete?')" href="{{ route('carts.remove.item', $product->rowId) }}" class="btn btn-danger btn-sm">Delete</a>
              </td>
            </tr>

          @endforeach



        <tfoot class="p-5">
          <tr>
            <td colspan="6" class="text-right text-success" ><span style="line-height: 60px;">Grand total : <b>@php
              echo $total;
            @endphp Tk</b></span> </td>
            <td></td>
          </tr>

          <tr>
            <td colspan="2">
                <a class="btn btn-sm btn-primary px-4" style="border-radius: 50px;" href="{{ asset('/') }}">Continue Shopping</a>
            </td>
            <td colspan="6" class="text-right" >
              <a class="btn btn-sm btn-outline-success px-4" style="border-radius: 50px;" href="{{ route('home.shipping.product') }}">Shipping</a>
            </td>
          </tr>
        </tfoot>
      </table>
    </div>
    @else
      <div class="w-100 py-5 text-center" style="background: #EAF8FC">
        <div class="col-md-10 mx-auto py-5">
          <h3>Sorry, You don't buy any product please buy something</h3>
          <a class="btn btn-outline-primary btn-sm" href="/">Home</a>
        </div>
      </div>

    @endif
  </div>

@endsection
