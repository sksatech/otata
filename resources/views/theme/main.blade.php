<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Otata') }}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png">
	<link rel="stylesheet" href="{!! asset('theme/vendor/chartist/css/chartist.min.css') !!}">
    <link href="{!! asset('theme/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') !!}" rel="stylesheet">
	<link href="{!! asset('theme/vendor/owl-carousel/owl.carousel.css') !!}" rel="stylesheet">
    <link rel="stylesheet" href="{!! asset('theme/vendor/toastr/css/toastr.min.css') !!}">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="{{ asset('theme/css/style.css') }}" rel="stylesheet">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
        @include('theme.header')
        @include('theme.sidebar')
                
       <div id="page-wrapper">
           @yield('content')
      </div>
       <!-- /#page-wrapper -->
   </div>
   <!-- /#wrapper -->
<footer>
    
    <!-- jQuery -->
    <script src="{{ asset('theme/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('theme/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('theme/vendor/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('theme/js/custom.min.js') }}"></script>
    <script src="{{ asset('theme/js/deznav-init.js') }}"></script>
    <script src="{{ asset('theme/vendor/owl-carousel/owl.carousel.js') }}"></script>
    
    <!-- Chart piety plugin files -->
    <script src="{{ asset('theme/vendor/peity/jquery.peity.min.js') }}"></script>

    <!-- Toastr -->
    <script src="{{ asset('theme/vendor/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('theme/js/plugins-init/toastr-init.js') }}"></script>
    
    @stack('script')
    </footer>
</body>
</html>