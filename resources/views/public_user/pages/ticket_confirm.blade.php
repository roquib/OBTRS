@extends('master.public')
@section('page-title')
Ticket Confirmation
@endsection
@section('main-content')
@if (empty($seats) && empty($trip_id) && empty($boarding_point))
<h1 class="display-4">
	The Pages you are searching is not found.
</h1>
@else
<div class="container">
	<form action="{{ route('ticketconfirm') }}" method="post">
		@csrf
		<div class="row mb-5">
			<div class="col-md-8">
				<div class="p_head" style="border-bottom: 2px solid red;">
					<h5>Passenger Details</h5>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-8">
							<label for="name">Name*</label>
							<input type="text" class="form-control" name="p_name" id="name"
								placeholder="Enter your Name">
						</div>
						<div class="col-md-4">
							<label for="gender">Gender*</label>
							<div class="form-group">
								<input type="radio" name="p_gender" id="gender" value="male">M
								<input type="radio" name="p_gender" id="gender" value="female">F
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="contact_title" style="border-bottom: 2px solid black;">
							<h4>Contact Information</h4>
						</div>
						<div class="form-group">
							<label for="mobile">Mobile*</label>
							<input type="text" name="p_mobile" class="form-control" id="mobile"
								placeholder="Enter Mobile Number">
						</div>
						<div class="form-group-sm">
							<label for="email">Email*</label>
							<input type="text" name="p_email" id="email" class="form-control-sm"
								placeholder="Enter your Email">
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="page-title" style="border-bottom: 2px solid black;">
					<h4>Journey Details</h4>
				</div>
				@php
				$dep_date = "temp";
				@endphp
				@foreach ($detail as $dt)
				<h4 class="text-danger">{{$dt->origin_city_name}} - {{$dt->destination_city_name}}</h4>
				<input type="hidden" name="trip_id" value="{{$dt->trip_id}}">
				<input type="hidden" name="origin_city_name" value="{{$dt->origin_city_name}}">
				<input type="hidden" name="destination_city_name" value="{{$dt->destination_city_name}}">
				<p>{{$dt->company_name}}</p>
				<input type="hidden" name="company_name" value="{{$dt->company_name}}">
				<p>{{$dt->departure_date}},{{$dt->departure_time}}</p>
				<input type="hidden" name="departure_date" value="{{$dt->departure_date}}">
				@php
				$dep_date = $dt->economy_class_fare;
				@endphp
				<input type="hidden" name="departure_time" value="{{$dt->departure_time}}">
				{{-- <p>{{date('d,Y',strtotime($dt->departure_date))}}</p> --}}
				Seat NO(s):
				@foreach ($seats as $key => $value)
				<span class="text-danger">{{$value }} </span>
				<input type="hidden" name="{{$value}}" value="{{$value}}">
				@endforeach
				<p>Boarding Point: <span>{{$boarding_point}}</span> </p>
				<input type="hidden" name="boarding_point" value="{{$boarding_point}}">
				@endforeach
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="fare_title" style="border-bottom: 1px solid black;">
					<h4>Fare Details</h4>
				</div><br>
				@php
				$ticket_price = (int)$dep_date;
				$total = 0;
				$discount = 0;
				@endphp
				<div class="ticket_price">
					<div class="float-left">
						Ticket Price
					</div>
					<div class="float-right">
						@foreach ($seats as $seat)
						@php
						$total += $ticket_price;
						@endphp
						@endforeach
						{{$total}}
						<input type="hidden" name="total" value="{{$total}}">
					</div>
				</div> <br>
				<div class="discount" style="border-bottom: 1px solid black;">
					<div class="float-left">Discount</div>
					<div class="float-right">{{$discount}}</div>
				</div> <br>
				<div class="total" style="border-bottom: 1px solid black;">
					<div class="float-left">Total</div>
					@php
					$total += $discount;
					@endphp
					<div class="float-right">{{$total}}</div>
				</div> <br>
			</div>
			<div class="col-md-8">
				<div class="payment_title mb-1" style="border-bottom: 1px solid black;">
					<h4>Payment Details</h4>
				</div>
				<div class="card">
					<div class="card-body">
						<h4 class="text-center">
							Total Amount Payable: ৳. {{$total}}
						</h4>
					</div>
				</div>
				<div class="tabs mb-2" style="background: white;">
					<ul class="nav nav-pills" id="pills-tab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="pills-cash-tab" data-toggle="pill" href="#pills-cash"
								role="tab" aria-controls="pills-cash" aria-selected="true">Cash</a>
						</li>
						<input type="hidden" name="payment" value="cash">
						<li class="nav-item">
							<a class="nav-link" id="pills-bkash-tab" data-toggle="pill" href="#pills-bkash" role="tab"
								aria-controls="pills-bkash" aria-selected="false">Bkash</a>
						</li>
					</ul>
					<div class="tab-content" id="pills-tabContent">
						<div class="tab-pane fade show active" id="pills-cash" role="tabpanel"
							aria-labelledby="pills-cash-tab">
							<span class="text-center" style="font-size: 12px;">
								your ticket(s) would be reserved and inactive till our call center agents call you
								and verify your credentials Ticket would become active when you pay the due amount
								during the delivery of ticket(s) at your doorstep.
							</span>
							<div class="row">
								<div class="col">
									<label for="city">City</label>
									<input type="text" class="form-control" name="city" placeholder="Dhaka">
								</div>
								<div class="col">
									<label for="Area">Area</label>
									<input type="text" class="form-control" name="area" placeholder="Abdullapur">
								</div>
							</div>
							<div class="row">
								<div class="col">
									<label for="first_name">First Name</label>
									<input type="text" class="form-control" name="first_name"
										placeholder="Enter First Name">
								</div>
								<div class="col">
									<label for="last_name">Last Name</label>
									<input type="text" class="form-control" name="last_name"
										placeholder="Enter Last Name">
								</div>
							</div>
							<div class="row">
								<div class="col">
									<label for="address">Address</label>
									<input type="text" name="address" placeholder="Enter Address" class="form-control">
								</div>
							</div>
							<div class="row">
								<div class="col">
									<label for="alternate_contact">Alternate Contact Number</label>
									<input type="text" name="alternate_contact"
										placeholder="Enter Alternate Contact Number" class="form-control">
								</div>
							</div>
							<input type="submit" class="text-center btn btn-primary mt-2" value="Confirm Reservation">
						</div>
					</div>
					<div class="tab-pane fade" id="pills-bkash" role="tabpanel" aria-labelledby="pills-bkash-tab">
						Bkash</div>
				</div>
			</div>
		</div>

</div>
</form>
</div>
@endif
@endsection
@section('addition-styles')
<style>
	.nav>li>a {
		padding: 10px;
	}
</style>
@endsection