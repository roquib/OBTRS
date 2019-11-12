
@extends('master.login')


@section('title')
	Admin - Forgot Password
@endsection

@section('styles')
	<style>
		h3 {
			margin: 0;
			padding: 0 0 10px;
			text-align: center;
			font-size: 22px;
		}
		.fa-lock, p {
			color: #1EBBB5 !important;
			letter-spacing: 1px;
		}

	</style>
@endsection

@section('main-content')
	<h3><i class="fa fa-lock fa-5x"></i></h3>
	@if (session('status'))
			<h4 class="text-center mt-3">Dear user!</h4>
			<p class="text-center mb-3 ">We send you a password reset link to your gmail.</p>
			<form method="POST" target="_blank" action="https://mail.google.com/mail/u/0/?tab=wm#inbox">
						@csrf
				<div class="form-group mt-5">
					<input name="recover-submit" class="btn btn-lg btn-success btn-block" value="Go to link" type="submit">
				</div>
			</form>
	@else
		<h4 class="text-center mt-3">Forgot Password?</h4>
		<p class="text-center mb-3">You can reset your password here.</p>


	<br>
	<form method="POST" action="{{ route('password.email') }}">
			@csrf
	<div class="input-group mt-3">
		<div class="input-group-prepend">
			 <span class="input-group-text">
				 <i class="fa fa-envelope color-blue" ></i>
			 </span>
		 </div>
		<input id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" type="email"name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

			@error('email')
					<span class="text-danger">
							<strong>Please insert your registered email</strong>
					</span>
			@enderror
	</div>
	<div class="form-group my-4">
		<input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
	</div>
	@endif
	</form>
@endsection
