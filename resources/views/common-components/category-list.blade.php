<div class="col-lg-3 mt-2">
    <h1 class="font_size_2 text-bold black-text">دسته بندی</h1>
  @if (\App\Category::where('parent_id',0)->count())
  @foreach (\App\Category::where('parent_id',0)->get() as $item)
  @include('common-components.category-box',['post_type'=>$post_type])
  @endforeach
  @endif

    <br><br>
    @include('common-components.latest-posts',['posts'=>$latest_posts,'title' => 'وبلاگ های اخیر'])
</div>