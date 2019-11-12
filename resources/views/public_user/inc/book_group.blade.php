<div class="box bg-dark py-3 mb-3">
	<div class="container">
		<div class="row">
			@foreach ($groups as $group)
			<div class="col-md-3 col-lg-3 col-sm-6 book-group">
				<a href="{{ route('productByGroup', $group->id) }}" style="text-decoration: none; text-transform: capitalize">
					<img src="{{asset('img/group-book-icon.png')}}" alt="" style="height:40px; width:40px;">
					<span style="font-size: 17px;">&nbsp; {{ $group->name }}</span>
				</a>
			</div>
			@endforeach
		</div>
	</div>
</div>
