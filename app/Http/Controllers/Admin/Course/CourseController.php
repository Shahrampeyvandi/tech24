<?php

namespace App\Http\Controllers\Admin\Course;

use App\Category;
use App\Certificate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use App\Post;
use App\Quiz;
use App\Tag;
use App\User;
use Illuminate\Support\Facades\Redirect;

class CourseController extends Controller
{
    public $page_title = 'دوره';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Post::find(1)->delete();
        // dd(Tag::all());
        $data['page_title'] = $this->page_title;
        return view('admin.course.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        $course = new Post;
        if ($request->has('picture')) {
            $fileName = $this->upload_picture($request, 'course', $slug);
            // dd($fileName);
            $course->picture = $fileName;
        
        }
        $course->title = $request->title;
        $course->description = $request->description;
        $course->url = $request->url;
        $course->media = 'video';
        $course->post_type = 'course';
        $course->duration = $request->duration;
        $course->cach = $request->cash_type;
        $course->price = $request->price;
        $course->views = 1;
        $course->teacher_id = $request->teachers;
        $course->start_date = $request->date;
        $course->private = $request->public_type == 'private' ? 1 : 0;
      

        $cat = Category::firstOrCreate(['title' => $request->category]);
        $course->category_id = $cat->id;
        $course->save();

        if ($request->has('tags')) {
            foreach ($request->tags as $key => $item) {
                $tag  = Tag::firstOrCreate(['tagname' => $item]);
                $tag_ids[] = $tag->id;
            }
            $course->tags()->sync($tag_ids);
        }

        if(isset($request->prerequisites)){
            $course->prerequisites()->sync($request->prerequisites);
        }

        
        if ($request->has('quiz')) {
            $q = Quiz::find($request->quiz);
            $q->quizable_id = $course->id;
            $q->quizable_type = 'App\Post';
            $q->save();
        }
         
        if ($request->has('certificate')) {
            $c = Certificate::find($request->certificate);
            $c->post_id = $request->certificate;
            $c->save();
        }

        $course->teachers()->sync($request->teachers);

        return Redirect::route('courses.index');
       


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function upload_picture(Request $request, $type, $name)
    {
        $date = date('Y');
        $request->validate([
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);

        $imageName = $name . '.' . $request->picture->extension();

        $request->picture->move(public_path('uploads/' . $date . '/' . $type), $imageName);
        return 'uploads/' . $date . '/' . $type . '/' . $imageName;
    }
}
