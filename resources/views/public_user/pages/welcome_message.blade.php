@extends('master.public')

@section('page-title')
Online Bus Ticket Reservation System - Welcome
@endsection
@section('main-content')
<div class="container">
	<h6 class="display-4">
		<strong>Welcome {{$name}}</strong>, Thank you for choosing redbus <br>
		your ticket(s) would be reserved and inactive till our call center agents call you to
		<strong>{{$contact}}</strong>
		and verify your credentials Ticket would become active when you pay the due amount
		during the delivery of ticket(s) at your doorstep. your ticket will be sent to this email address {{$email}}
	</h6>
</div>
@endsection
@section('additional_script')
<script>

</script>
@endsection