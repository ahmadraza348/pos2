<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Inventory Management System">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, html5, responsive">
    <meta name="author" content="Dreamguys - Inventory Management System">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Raza Mall')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('backend/assets/img/favicon.jpg') }}">

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/plugins/stickynote/sticky.css') }}">

       <link
      rel="stylesheet"
      href="{{ asset('backend/assets/plugins/owlcarousel/owl.carousel.min.css') }}"
    />
    <link
      rel="stylesheet"
      href="{{ asset('backend/assets/plugins/owlcarousel/owl.theme.default.min.css') }}"
    />

    <link rel="stylesheet" href="{{ asset('backend/assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/plugins/summernote/summernote-bs4.min.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    @vite(['resources/js/app.js'])

</head>

<body>
    <!-- Global Loader -->
    <div id="global-loader">
        <div class="whirly-loader"></div>
    </div>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        @include('backend.layouts.header')
        @include('backend.layouts.sidebar')  
        <div class="page-content">
            @yield('content')
        </div>
    </div>

    <!-- JS Files -->
    <script src="{{ asset('backend/assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('backend/assets/js/jquery-ui.min.js') }}"></script>

    <script src="{{ asset('backend/assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/apexchart/chart-data.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/script.js') }}"></script>
    <script src="{{ asset('backend/customscript.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/fileupload/fileupload.min.js') }}"></script>
    <script src="{{ asset('backend/assets/plugins/owlcarousel/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('backend/assets/plugins/stickynote/sticky.js') }}"></script>


    @include('backend.layouts.scripts') 

</body>

</html>
