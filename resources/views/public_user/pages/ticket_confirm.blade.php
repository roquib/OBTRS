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
	<div class="row">
		<div class="col-md-8">
			<div class="p_head" style="border-bottom: 3px solid red;">
				<h5>Passenger Details</h5>
			</div>
		</div>
		<div class="col-md-4">
			<div class="page-title" style="border-bottom: 2px solid black;">
				<h4>Journey Details</h4>
			</div>
		</div>
	</div>
</div>
@endif
@endsection
