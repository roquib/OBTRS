
@extends('master.login')


@section('title')
	Admin - Login
@endsection

@section('main-content')
	<img src="{{URL::to('img/avatar.png')}}" class="avatar">
	<h1 class="mt-5 font-weight-bold" style="letter-spacing: 2px;">Login Here</h1>
	<form method="POST" action="{{ route('login') }}">
			@csrf
			<div class="mt-1">
				<p>Email</p>
				<input class="px-2" type="text" name="email" placeholder="Email Address">
				@if ($errors->has('email'))
					@if (($errors->first('email')) == "These credentials do not match our records.")
						<span class="text-danger font-weight-bold" >
							Invalid username or password
						</span>
					@else
						<span class="email-required" >
							{{ $errors->first('email') }}
						</span>
					@endif
				@endif
			</div>
			<div class="">
				<p>Password</p>
				<input id="password" type="password" placeholder="....." class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
				@if ($errors->has('password'))
					<span class="py-1" >
							<small class="text-primary">{{ $errors->first('password') }}</small>
					</span>
				@endif
			</div>
			<input class="mb-1" type="submit" name="btnLogin" value="Login">
			@if ($errors->has('email'))
					@if (($errors->first('email')) == "These credentials do not match our records.")
						<div style="font-size: 16px" class="text-center mt-1">
							@if (Route::has('password.request'))
								Lost your
							<a style="color: #1DC9B7" href="{{ route('password.request') }}">
								{{ __('password?') }}
							</a>
							@endif
						</div>
					@endif
			@endif

	</form>
@endsection
