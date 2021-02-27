<ul class="{{ $class }}">
                <li><a href="{{ url($post_type.'s',['category'=>$item->slug]) }}">{{ $item->title }}</a></li>
                @if (\App\Category::where('parent_id',$item->id)->count())
                @foreach (\App\Category::where('parent_id',$item->id)->get() as $item)
                    @include('common-components.category-li',['item'=>$item,'class'=>"pr-4"])
                @endforeach
                @endif
               
</ul>