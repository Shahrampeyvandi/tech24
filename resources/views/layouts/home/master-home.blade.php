<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title','تکوان')</title>
  <link rel="icon" href="{{URL::asset('/assets/imgs/cropped-Favicon-2-32x32.png')}}" sizes="32x32" />
  <link rel="icon" href="{{URL::asset('/assets/imgs/cropped-Favicon-2-192x192.png')}}" sizes="192x192" />
  <link rel="apple-touch-icon" href="{{URL::asset('/assets/imgs/cropped-Favicon-2-180x180.png')}}" />
  <meta name="msapplication-TileImage" content="{{URL::asset('/assets/imgs/cropped-Favicon-2-270x270.png')}}" />
  {{-- <link rel="shortcut icon" href="assets/imgs/Logo.png" type="image/x-icon"> --}}
  @include('layouts.home.head')
</head>

<body>
  @include('layouts.home.topbar-home')

  @include('layouts.home.navbar-home')

  @include('layouts.home.searchbox-home')

  @yield('content')

  @include('layouts.home.footer-home')
  
  @include('layouts.home.footer-script-home')

  <section class="prevloader"><div class="preloader"></div></section>

</body>

</html>