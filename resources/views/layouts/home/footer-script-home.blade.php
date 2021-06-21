
 
  
      <script src="{{ asset('js/app.js') }}"></script>
      <script src="{{ URL::asset('assets/js/toastr.min.js') }}"></script>
      {!! Toastr::message() !!}
      <!--ADD BOOTSTRAP JS FILE-->
     
      <script>
       window.Token = $('meta[name="csrf-token"]').attr('content')
        token = $('meta[name="csrf-token"]').attr('content')
        mainUrl = '{{route("baseurl")}}'
    </script>
    <script src="{{URL::asset('/assets/js/script.js')}}"></script>
    
     @yield('scripts')