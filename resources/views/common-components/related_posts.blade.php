<!--start webinar section-->
<section class="webinar mb-5">
    <div class="container">
        <div class="d-flex text-center justify-content-sm-between align-items-center mb-4">
            <h1 class="section_heading">{!! $title_section !!}</h1>
            <div class="divider"></div>
            <menu class="dropdown">
                <button class="dropdown-toggle btn btn-lg" data-toggle="dropdown"> همه {{ $title }} ها </button>
                <ul class="dropdown-menu">
                    <li class="dropdown-item" onclick="showCategory('all')"> همه {{ $title }} ها </li>
                    <div class="dropdown-divider"></div>
                    <li class="dropdown-item" onclick="showCategory('new')">جدیدترین {{ $title }} ها</li>
                    <div class="dropdown-divider"></div>
                    <li class="dropdown-item" onclick="showCategory('popular')">پرفروش ترین ها</li>
                </ul>
            </menu>
        </div>
        <!--BOX ROW-->
        <div class="box_row">

        @foreach ($related_posts as $item)
        @include('common-components.post-item',['post'=>$item])
        @endforeach
           
        </div>
    </div>
</section>
<!--end webinar section-->