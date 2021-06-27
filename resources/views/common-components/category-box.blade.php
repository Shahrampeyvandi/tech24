<div class="category_box">
        <div class="content_box_options">
            <h1 class="category_box_title">{{$item->title}}</h1>
            <button class="category_box_btn" onclick="showCategoryContent('cat--{{$item->id}}')"><i class="icon-plus"></i></button>
        </div>
        <div class="category_box_content cat--{{$item->id}}">
          @if (\App\Category::where('parent_id',$item->id)->count())
          @foreach (\App\Category::where('parent_id',$item->id)->get() as $level_one)
          @include('common-components.category-li',['item' => $level_one,'class'=>"blue-list",'post_type'=>$post_type])
          @endforeach
          @endif
        </div>
    </div>