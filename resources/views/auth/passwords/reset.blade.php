
@extends('master.login')


@section('title')
	Admin - Recover Password
@endsection

@section('styles')
	<style>
		h3 {
			margin: 0;
			padding: 0 0 10px;
			text-align: center;
			font-size: 22px;
		}
		.fa-lock {
			color: #1EBBB5 !important;
			letter-spacing: 1px;
		}

		.login-box {
			height: 450 !important;
		}
	</style>
@endsection

@section('main-content')

	<h3><i class="fa fa-lock fa-4x"></i></h3>
	<h3 class="text-center mt-2 ">Recover Password</h3>
	<p class="text-center mb-3">You can reset your password here.</p>

	<form method="POST" action="{{ route('password.update') }}">
		@csrf
		<input type="hidden" name="token" value="{{ $token }}">
		<input id="email" type="email" hidden class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
			New Password
			<input id="password" placeholder="....." type="password" class="mb-3 form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
				@error('password')
						<span class="text-danger">
								<strong>Password not match</strong>
						</span>
				@enderror

			Confirm Password
			<input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="....." required autocomplete="new-password">


		<div class="form-group my-4">
			<input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Create Password" type="submit">
		</div>
	</form>

@endsection
