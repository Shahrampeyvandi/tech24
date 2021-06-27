<!--start topbar-->
<section class="topbar ">
    <div class="container container-fluid">
        <div class="topbar_row">
          
            <button-component :auth="{{ json_encode(Auth::user()) }}"></button-component>
            
                <a href="{{ URL::route('baseurl') }}">
                    <img src="{{ URL::asset('assets/imgs/Logo.png') }}" class="w-p-100" alt="Tech-one">
                </a>

                {{-- <a href="#" class=" mr-4"><i class="icon-phone mr-1"></i>
                    {{\App\Setting::where('key',\App\Setting::Mobile)->first()->value ?? '' }}</a>
                <a href="#" class=""><i class="icon-envelope mr-1"></i>
                    {{\App\Setting::where('key',\App\Setting::Email)->first()->value ?? '' }}</a> --}}
            
        </div>
    </div>
</section>
<!--end top bar-->