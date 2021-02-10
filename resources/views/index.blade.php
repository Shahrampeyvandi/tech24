@extends('layouts.master')

@section('title') داشبورد @endsection

@section('content')

@component('common-components.breadcrumb')
@slot('title') داشبورد @endslot
@slot('title_li') @endslot
@endcomponent

<div class="row">
    <div class="col-md-3">

        @component('common-components.dashboard-widget')

        @slot('title') دوره ها @endslot
        @slot('iconClass') mdi mdi-teach @endslot
        @slot('price') 10 @endslot


        @endcomponent
    </div>
    <div class="col-md-3">
        @component('common-components.dashboard-widget')

        @slot('title') وبینارها @endslot
        @slot('iconClass') mdi mdi-teach @endslot
        @slot('price') 2,456 @endslot


        @endcomponent

    </div>
    <div class="col-md-3">
        @component('common-components.dashboard-widget')

        @slot('title') دانشجوها @endslot
        @slot('iconClass') mdi mdi-account-multiple-outline @endslot
        @slot('price') 2456 @endslot


        @endcomponent

    </div>
    <div class="col-md-3">
        @component('common-components.dashboard-widget')

        @slot('title') اساتید @endslot
        @slot('iconClass') mdi mdi-account-multiple-outline @endslot
        @slot('price') 23 @endslot


        @endcomponent

    </div>
    <div class="col-md-3">
        @component('common-components.dashboard-widget')

        @slot('title') پادکست ها @endslot
        @slot('iconClass') mdi mdi-microphone-outline @endslot
        @slot('price') 2 @endslot


        @endcomponent

    </div>
    <div class="col-md-3">
        @component('common-components.dashboard-widget')

        @slot('title') New Users @endslot
        @slot('iconClass') mdi mdi-account-multiple-outline @endslot
        @slot('price') 2,456 @endslot


        @endcomponent

    </div>
    <div class="col-md-3">
        @component('common-components.dashboard-widget')

        @slot('title') New Users @endslot
        @slot('iconClass') mdi mdi-account-multiple-outline @endslot
        @slot('price') 2,456 @endslot


        @endcomponent

    </div>
    <div class="col-md-3">
        @component('common-components.dashboard-widget')

        @slot('title') New Users @endslot
        @slot('iconClass') mdi mdi-account-multiple-outline @endslot
        @slot('price') 2,456 @endslot


        @endcomponent

    </div>


</div>
<!-- end row -->




@endsection

@section('script')
<!-- plugin js -->
<script src="{{ URL::asset('libs/apexcharts/apexcharts.min.js')}}"></script>

<!-- jquery.vectormap map -->
<script src="{{ URL::asset('libs/jquery-vectormap/jquery-vectormap.min.js')}}"></script>

<!-- Calendar init -->
<script src="{{ URL::asset('js/pages/dashboard.init.js')}}"></script>
@endsection