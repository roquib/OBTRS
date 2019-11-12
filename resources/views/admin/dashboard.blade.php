
@extends('master.admin')

@section('page-title')
  Admin - Dashboards
@endsection

@section('main-content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="vue-user">

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid pt-5">

        {{-- <dashboard-component>

        </dashboard-component> --}}
        <div class="row">
          <div class="col-md-3">
              <div class="card border-success mx-sm-1 p-3">
                  <div class="card border-success shadow text-success p-3 my-card" >
                    <span class="fa fa-book"  aria-hidden="true"></span>
                  </div>
                  <div class="text-success text-center mt-3">
                    <h4><a style="text-decoration: none" class="text-success" href="{{ route('todays.orders') }}">Todays Orders</a></h4>
                  </div>
                  <div class="text-success text-center mt-2">
                    <h2>{{ $todaysTotalOrder->count() }}</h2>
                  </div>
              </div>
          </div>
          <div class="col-md-3">
              <div class="card border-info mx-sm-1 p-3">
                  <div class="card border-info shadow text-info p-3 my-card" >
                    <span class="fa fa-user" aria-hidden="true"></span>
                  </div>
                  <div class="text-info text-center mt-3">
                    <h4><a style="text-decoration: none" class="text-info" href="#">Pending Orders</a></h4>
                  </div>
                  <div class="text-info text-center mt-2"><h2>{{ $totalPendingOrder->count() }}</h2></div>
              </div>
          </div>
          <div class="col-md-3">
              <div class="card border-danger mx-sm-1 p-3">
                  <div class="card border-danger shadow text-danger p-3 my-card" >
                    <span class="fa fa-edit" aria-hidden="true"></span>
                  </div>
                  <div class="text-danger text-center mt-3"><h4>Rejected</h4></div>
                  <div class="text-danger text-center mt-2"><h1>0</h1></div>
              </div>
          </div>
          <div class="col-md-3">
              <div class="card border-primary mx-sm-1 p-3">
                  <div class="card border-primary shadow text-primary p-3 my-card" ><span class="fa fa-car" aria-hidden="true"></span></div>
                  <div class="text-primary text-center mt-3"><h4>Completed</h4></div>
                  <div class="text-primary text-center mt-2"><h1>0</h1></div>
              </div>
          </div>

        </div>

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
