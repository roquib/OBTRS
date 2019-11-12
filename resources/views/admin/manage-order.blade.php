
@extends('master.admin')

@section('page-title')
  Admin - Manage Order
@endsection

@section('main-content')

@php
  $zoneOption = array("Inside Dhaka", "Gazipur District",
  "Other's District in dhaka division",
  "Rangpur division","Rajshahi Division","Chittagang Division",
  "Syllet Division","Maymunsing Division","Own Delivery");

  $status = array('Pending', 'processing', 'Delivered');
  $statusColor = array('text-danger', 'text-info', 'text-success');
  $total_quantity = 0;

  foreach ($orderedProducts as $orderedProduct) {
    $total_quantity += $orderedProduct->quantity;
  }
@endphp


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="vue-user">

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid pt-3">
        <div class="container">
          <div class="row">
            <div class="col-12">

              {{-- Success message --}}
              @if( Session::has("success") )
                @include('public_user.inc.success-alert')
              @endif


              <div class="wel p-2 my-3">
                {!! Form::open(['url' => route('admin.order.update', $order->id ),'method' => 'POST']) !!}


                <div class="p-2" style="border-left: 7px solid #6CB2EB; background: white">


                  <h5><strong>Orer No.</strong> :
                    @php
                      $format = "";
                    @endphp
                    @if ($order->id < 10)
                      @php $format = "0000"; @endphp
                    @elseif ($order->id < 100)
                      @php $format = "000"; @endphp
                    @elseif ($order->id < 1000)
                      @php $format = "00"; @endphp
                    @elseif ($order->id < 10000)
                      @php $format = "0"; @endphp
                    @endif
                    @php $format = "#" . $format . $order->id @endphp
                    <span class="badge badge-light">@php echo $format; @endphp</span>
                    <button type="submit" onclick="return confirm('Are you sure to update info?')" class="btn btn-primary mb-5 px-3 mr-3 btn-sm float-right">Update</button>

                  </h5>
                  <h3 style="font-size: 14px; margin-top: 0" class="mr-3">Date: {{ $order->created_at }}</h3>


                </div>
                <div class="row mx-0 px-0 mt-3" style="border-left: 7px solid #6CB2EB; background: white">
                  <div class="col-md-5 pt-2 px-2">
                    <h5><strong class="p-2">Customer Detail</strong></h5>
                    <table class="table table-sm">
                      <tr>
                        <td>Order By</td>
                        <td>:</td>
                        <td><input type="text" class="form-control form-control-sm" name="name" value="{{ $order->name }}"> </td>
                      </tr>
                      <tr>
                        <td>Mobile</td>
                        <td>:</td>
                        <td><input type="text" class="form-control form-control-sm" name="mobile" value="{{ $order->mobile }}"></td>
                      </tr>
                      <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td><input type="text" class="form-control form-control-sm" name="email" value="{{ $order->email }}"></td>
                      </tr>
                      <tr>
                        <td>Contact Person</td>
                        <td>:</td>
                        <td><input type="text" class="form-control form-control-sm" name="contact_person" value="{{ $order->contact_person }}"></td>
                      </tr>
                      <tr>
                        <td>Mobile Number</td>
                        <td>:</td>
                        <td><input type="text" class="form-control form-control-sm" name="contact_mobile" value="{{ $order->contact_mobile }}"></td>
                      </tr>
                      <tr>
                        <td>Zone</td>
                        <td>:</td>
                        <td>
                          <select class="form-control form-control-sm" name="zone">
                            <option value="{{ $order->zone }}">{{ $zoneOption[$order->zone] }}</option>
                            @for ($i=0; $i < 9; $i++)
                              @if($i != $order->zone)
                              <option value="{{ $i }}">{{ $zoneOption[$i] }}</option>
                              @endif
                            @endfor
                          </select>
                          </td>
                      </tr>
                      <tr>
                        <td>Address</td>
                        <td>:</td>
                        <td> <textarea class="form-control" name="address" rows="2" cols="20">{{ $order->address }}</textarea>
                          </td>
                      </tr>
                    </table>
                  </div>

                  <div class="col-md-4 ml-auto pt-2 px-2">
                    <h5><strong>Other's info</strong></h5>
                    <table class="table table-sm">
                      <tr>
                        <td>Order Status</td>
                        <td>:</td>
                        <td>
                          <select class="form-control form-control-sm" name="status">
                            <option value="{{ $order->status }}">{{ $status[$order->status] }}</option>
                            @for ($i=0; $i < 3; $i++)
                              @if($i != $order->status)
                              <option value="{{$i}}">{{ $status[$i] }}</option>
                              @endif
                            @endfor
                          </select>
                          </td>
                      </tr>
                      <tr>
                        <td>Total Quantity</td>
                        <td>:</td>
                        <td><input type="text" readonly class="form-control form-control-sm" value="{{ $total_quantity }}"></td>
                      </tr>
                      <tr>
                        <td>Total Amount</td>
                        <td>:</td>
                        <td><input type="text" readonly class="form-control form-control-sm" name="total_price" value="{{ $order->total_price }}"></td>
                      </tr>
                      <tr>
                        <td>Shipping Cost</td>
                        <td>:</td>
                        <td><input type="text" class="form-control form-control-sm" name="shipping_cost" value="{{ $order->shipping_cost }}"></td>
                      </tr>
                      <tr>
                        <td>Tax</td>
                        <td>:</td>
                        <td><input type="text" class="form-control form-control-sm" name="tax" value="{{ $order->tax }}"></td>
                      </tr>
                      <tr>
                        <td>Grand Total</td>
                        <td>:</td>
                        <td><input type="text" readonly class="form-control form-control-sm" value="{{ $order->total_price + $order->shipping_cost + $order->tax }}"></td>
                      </tr>
                    </table>
                  </div>
                </div>

                {!! Form::close() !!}

              </div>



              <div class="card">
                <div class="card-header" style="background: #563D7C">
                  <h3 class="card-title text-light">
                    Product List
                  </h3>
                </div>

                <div class="card-body table-responsive p-0">
                  <table class="table table-hover">
                    <tbody>
                      <tr class="bg-primary">
                        <th>ID</th>
                        <th>Book Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                      </tr>
                      @php $rowCount = 1; @endphp

                      @foreach ($orderedProducts as $orderedProduct)

                        <tr>
                          <td>@php echo $rowCount++; @endphp</td>
                          <td>
                            <a style="text-decoration: none; color: black;" target="_blank" href="{{ route('single.help', $orderedProduct->product_id) }}">{{ $products[$orderedProduct->product_id]->name }}</a>
                          </td>
                          <td> {{ $orderedProduct->quantity }} Pc</td>
                          <td> {{ $orderedProduct->price }} Tk.</td>
                          <td> {{ $orderedProduct->quantity * $orderedProduct->price }} Tk.</td>
                          <td>
                            <a class="text-center" href="{{ route('delete.order.item', $orderedProduct->id) }}" onclick="return confirm('Are you sure to cancel this item?')">
                              <i class="fas fa-trash red" style="font-size: 20px;"></i>
                            </a>
                          </td>


                        </tr>

                      @endforeach


                    </tbody>
                  </table>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
