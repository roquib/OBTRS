
@extends('master.admin')

@section('page-title')
  Admin - Todays Order List
@endsection

@section('main-content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="vue-user">

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid pt-5">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header" style="background: #563D7C">
                  <h3 class="card-title text-light">
                    Todays order List
                  </h3>
                </div>

                <div class="card-body table-responsive p-0">
                  <table class="table table-hover">
                    <tbody>
                      <tr class="bg-primary">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Total Price</th>
                        <th>Order Status</th>
                        <th>Action</th>
                      </tr>

                      @php $count = 1; @endphp

                      @foreach ($todaysTotalOrder as $order)
                        <tr>
                          <td>@php echo $count++; @endphp</td>
                          <td>{{ $order->name }}</td>
                          <td>{{ $order->mobile }}</td>
                          <td>{{ $order->total_price }} Tk.</td>
                          <td>
                            @if ($order->status == 0)
                              <small class="badge badge-danger">Pending</small>
                            @elseif ($order->status == 1)
                              <small class="badge badge-primary">Processing</small>
                            @else
                              <small class="badge badge-success">Delivered</small>
                            @endif
                          <td><a class="btn btn-primary btn-sm" href="{{ route('manage.order', $order->id) }}">Manage</a> </td>
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
