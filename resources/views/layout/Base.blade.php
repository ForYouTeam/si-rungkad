<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>si-rungkat</title>
  <link rel="shortcut icon" type="image/png" href="{{asset('template/src/assets/images/logos/favicon.png')}}" />
  <link rel="stylesheet" href="{{asset('template/src/assets/css/styles.min.css')}}" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    @include('layout.Sidebar')
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      @include('layout.Header')
      <!--  Header End -->
      <div class="container-fluid">
        <!--  Row 1 -->
        <div class="row">
            @yield('content')
        </div>
      </div>
      <div class="py-6 px-6 text-center">
        <p class="mb-0 fs-4">Design by <a href="https://adminmart.com/" target="_blank" class="pe-1 text-primary text-decoration-underline">IcaMager</a> Distributed by <a href="https://themewagon.com">ThemeWagon</a></p>
      </div>
    </div>
  </div>
  
</body>

<script src="{{asset('template/src/assets/libs/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('template/src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('template/src/assets/js/sidebarmenu.js')}}"></script>
  <script src="{{asset('template/src/assets/js/app.min.js')}}"></script>
  <script src="{{asset('template/src/assets/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
  <script src="{{asset('template/src/assets/libs/simplebar/dist/simplebar.js')}}"></script>
  <script src="{{asset('template/src/assets/js/dashboard.js')}}"></script>
  {{-- <script src="https://code.jquery.com/jquery-3.7.0.js"></script> --}}
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@yield('script')
</html>