<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | TechOne Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="تک وان " name="description" />
    <meta content="" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- App favicon -->
    <link rel="icon" href="assets/imgs/cropped-Favicon-2-32x32.png" sizes="32x32" />
<link rel="icon" href="assets/imgs/cropped-Favicon-2-192x192.png" sizes="192x192" />
<link rel="apple-touch-icon" href="assets/imgs/cropped-Favicon-2-180x180.png" />
<meta name="msapplication-TileImage" content="assets/imgs/cropped-Favicon-2-270x270.png" />
    @include('layouts.head')
</head>

@section('body')
@show
<body data-layout="detached" data-topbar="colored">
    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner-chase">
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
            </div>
        </div>
    </div>
    <!-- Begin page -->
    <div class="container-fluid">
        <div id="layout-wrapper">
            @include('layouts.topbar')
            @include('layouts.sidebar')
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    
                    @yield('content')
                </div>
                <!-- End Page-content -->
                @include('layouts.footer')
            </div>
            <!-- end main content-->
        </div>
        <!-- END layout-wrapper -->
    </div>
    <!-- END container-fluid -->


  
    <!-- JAVASCRIPT -->
    @include('layouts.footer-script')
</body>

</html>