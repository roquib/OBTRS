<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('page-title')</title>

  <!-- REQUIRED CSS -->
  {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" >
  {{-- <link rel="stylesheet" href="/css/app.css"> --}}
  <style>
  .my-card
    {
      position:absolute;
      left:40%;
      top:-20px;
      border-radius:50%;
    }
  </style>
</head>
