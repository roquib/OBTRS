
<html>
	<head>
		<title> @yield('title') </title>
		<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" >
		<link rel="stylesheet" type="text/css" href="{{ asset('css/custom/login.css') }}">
		<link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}" type="text/css">

		@yield('styles')

	</head>

	<body>
		<div class="login-box">
			@yield('main-content')

		</div>


		<!-- The Modal -->
		  <div class="modal fade" id="myModal">
		    <div class="modal-dialog modal-dialog-centered">
		      <div class="modal-content">

		        <!-- Modal Header -->
		        <div class="modal-header">
		          <h4 class="modal-title">Reset Password</h4>
		          <button type="button" class="close" data-dismiss="modal">&times;</button>
		        </div>

		        <!-- Modal body -->
		        <div class="modal-body clearfix">
		          <div class="my-3">
		          	E-Mail Address <input type="email" class="form-control" name="" value="">
		          </div>
							<div class="my-2 text-center">
								<button type="button" class="btn btn-primary" name="button">Send Password Link</button>
							</div>
		        </div>


		      </div>
		    </div>
		  </div>
		  <!-- REQUIRED SCRIPTS -->
		  <script src="/js/app.js"></script>
	</body>
</html>
