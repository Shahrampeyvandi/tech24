<!DOCTYPE html>
<html lang="fa">

<head>
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="{{URL::asset('/assets/imgs/cropped-Favicon-2-32x32.png')}}" sizes="32x32" />
  <link rel="icon" href="{{URL::asset('/assets/imgs/cropped-Favicon-2-192x192.png')}}" sizes="192x192" />
  <link rel="apple-touch-icon" href="{{URL::asset('/assets/imgs/cropped-Favicon-2-180x180.png')}}" />
  <meta name="msapplication-TileImage" content="{{URL::asset('/assets/imgs/cropped-Favicon-2-270x270.png')}}" />
  {{-- <link rel="shortcut icon" href="assets/imgs/Logo.png" type="image/x-icon"> --}}
  {!! SEOMeta::generate() !!}
  {!! OpenGraph::generate() !!}
  {!! Twitter::generate() !!}

  @include('layouts.home.head')
  <script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer>
  </script>
</head>

<body >
  <div id="app">
  @include('layouts.home.topbar-home')

  @include('layouts.home.navbar-home')

  @include('layouts.home.searchbox-home')

  
 
    @yield('content')
 

  @include('layouts.home.footer-home')
</div>
 
  @include('layouts.home.footer-script-home')

  <section class="prevloader"><div class="preloader"></div></section>

</body>

</html>