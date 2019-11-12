
<!DOCTYPE html>

<html lang="en">
@include('admin.included.head')

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    @include('admin.included.sidebar')

    @yield('main-content')

    @include('admin.included.footer')


  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <script src="/js/app.js"></script>
</body>
</html>
