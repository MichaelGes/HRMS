<!DOCTYPE html>
<html lang="en">










<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>@yield('title')</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href=" {{ asset('assets/admin/css/app.min.css') }}">
  <link rel="stylesheet" href=" {{ asset('assets/admin/bundles/izitoast/css/iziToast.min.css') }}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/css/components.css') }}">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{ asset('assets/admin/css/custom.css') }}">
  <link rel="stylesheet" href=" {{ asset('assets/admin/bundles/prism/prism.css') }}">

  <!-- Select2 -->
  <link rel="stylesheet" href=" {{ asset('assets/admin/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href=" {{ asset('assets/admin/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

  <link rel='shortcut icon' type='image/x-icon' href='{{ asset('assets/admin/img/favicon.ico') }} ' />
</head>

<body>

      <!--nav -->
      @include('admin.includes.navbar')
      <!-- END-nav -->
     <!--Sidebar -->
     @include('admin.includes.sidebar')
     <!--END-Sidebar -->
      <!-- Main Content -->
@include('admin.includes.content')
      <!-- End-Main Content -->
     <!--Footer-->
     @include('admin.includes.footer')
     <!--End-Footer-->
     
    </div>
  </div>
  <!-- General JS Scripts -->
  <script src="{{ asset('assets/admin/js/app.min.js') }}"></script>
  <!-- JS Libraies -->
  <script src="{{ asset('assets/admin/bundles/izitoast/js/iziToast.min.js') }}"></script>
  <!-- Page Specific JS File -->
  <script src="{{ asset('assets/admin/js/page/toastr.js') }}"></script>
  <!-- Template JS File -->
  <script src="{{ asset('assets/admin/js/scripts.js') }}"></script>
  <!-- Custom JS File -->
  <script src="{{ asset('assets/admin/js/custom.js') }}"></script>
  <script src="{{ asset('assets/admin/js/General.js') }}"></script>
<script src="{{ asset('assets/admin/select2/js/select2.full.min.js') }}"></script>
  <!-- Template JS File -->
  @yield('script')








</body>



</html>