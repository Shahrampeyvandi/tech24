
  <!--ADD JQUERY JS FILE-->
  <script src="{{URL::asset('/assets/js/jquery-3.2.1.min.js')}}"></script>
    <!--ADD POPPER JS FILE-->
    {{-- <script src="{{URL::asset('/assets/js/popper.min.js')}}"></script> --}}
    <!--ADD BOOTSTRAP JS FILE-->
    {{-- <script src="{{URL::asset('/assets/js/bootstrap.min.js')}}"></script> --}}

    <script src="{{ URL::asset('assets/js/toastr.min.js') }}"></script>
    {!! Toastr::message() !!}
    <!--ADD BOOTSTRAP JS FILE-->
    <script>
      token = $('meta[name="csrf-token"]').attr('content')
      mainUrl = '{{route("baseurl")}}'
  </script>
    <script src="{{URL::asset('/assets/js/script.js')}}"></script>
      <script src="{{ asset('js/app.js') }}"></script>

     @yield('scripts')