<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> @yield('page-title') </title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="all,follow">
  <?php header("Access-Control-Allow-Origin: *"); ?>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Bootstrap CSS-->

  @include('public_user.inc.styles')
  <link rel="stylesheet" href="{{asset('css/meanmenu.css')}}">
  <link rel="stylesheet" href="{{asset('css/datepicker.css')}}">
  <link rel="stylesheet" href="{{asset('css/theme.default.css')}}">
  <style>
    .ui-datepicker-trigger {
      margin-top: -25px;
      float: right;
      margin-right: 5px;
    }
  </style>
  {{-- <link rel="stylesheet" href="{{asset('css/custom/ss.css')}}"> --}}
  @yield('addition-styles')

</head>

<body>
  <div id="vue-user">
    <!-- navbar-->
    @include('public_user.inc.nav-header')
    <br><br><br><br>
    {{-- ==========   HEADER END  ======== --}}
{{-- 
    <div id="all">
      <div id="content"> --}}
        @yield('main-content')
{{--       </div>
    </div> --}}
    @include('public_user.inc.footer')
  </div>
  <!-- JavaScript files-->
  <script src="{{ asset('js/app.js') }}"></script>
  @include('public_user.inc.scripts')
  <script type="text/javascript">
    // Tooltips Initialization
      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      });
  </script>
  @yield('additional_script')
</body>

</html>
