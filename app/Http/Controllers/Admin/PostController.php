<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use App\Post;
use App\Quiz;
use App\User;
use App\Group;
use App\Category;
use App\Certificate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class PostController extends Controller
{
    public $page_title = 'دوره';
    public $post_type = 'course';

    public function __construct()
    {
        if (isset(request()->post_type)) {
            if (request()->post_type == 'webinar') {
                $this->post_type = 'webinar';
                $this->page_title = 'وبینار';
            } elseif (request()->post_type == 'podcast') {
                $this->post_type = 'podcast';
                $this->page_title = 'پادکست';
            } elseif (request()->post_type == 'course') {
                $this->post_type = 'course';
                $this->page_title = 'دوره';
            } else {
                abort(404);
            }
        } else {
            $this->post_type = 'course';
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {



        $data = [
            'posts' => Post::where('post_type', $this->post_type)->latest()->get(),
            'title' => $this->page_title,
            'post_type' => $this->post_type
        ];
        return view('admin.course.index', $data);
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
        $data['post_type'] = $this->post_type;
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


        // dd($_FILES['picture']['tmp_name']);


        if ($request['post_type'] == 'podcast') {
            $request->validate([
                'file' => 'mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',
                'url' => 'required_without:file',
                'title' => 'required',

            ]);

            $mime = 'audio';
        } else {
            $mime = null;
        }

        $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        if (isset($request->action) && $request->action == 'edit') {
            $post = Post::find($request->post_id);
            if ($request['post_type'] == 'podcast' && isset($request->file)) {
                $post->files()->delete();
            }
            // dd($post->group);
        } else {
            $post = new Post;
        }

        if ($request->has('picture')) {
            if (isset($request->action) && $request->action == 'edit') {
                File::delete(public_path($post->picture));
            }
            $fileName = $this->upload_picture($request, $this->post_type, $slug);
            $post->picture = $fileName;
        }
        $post->title = $request->title;
        $post->description = $request->description;
        $post->url = $request->url;
        $post->media = $mime ? 'audio' : 'video';
        $post->post_type = $this->post_type;
        $post->duration = $request->duration;
        $post->cash = $request->cash_type;
        $post->price = $request->price;
        $post->views = 1;
        $post->teacher_id = $request->teachers;
        $post->group_id = $request->group;
        $post->start_date = $request->date;
        $post->private = $request->public_type == 'private' ? 1 : 0;


        $cat = Category::firstOrCreate(['title' => $request->category, 'parent_id' => $request->parent_category]);
        $post->category_id = $cat->id;
        $post->save();

        if ($request->has('tags')) {
            foreach ($request->tags as $key => $item) {
                $tag  = Tag::firstOrCreate(['tagname' => $item]);
                $tag_ids[] = $tag->id;
            }
            $post->tags()->sync($tag_ids);
        }
        if ($request['post_type'] == 'course') {

            if (isset($request->prerequisites)) {
                $post->prerequisites()->sync($request->prerequisites);
            }


            if ($request->has('quiz') && $request->quiz) {
                $q = Quiz::find($request->quiz);
                $q->quizable_id = $post->id;
                $q->quizable_type = 'App\Post';
                $q->save();
            }

            // if ($request->has('group') && $request->group) {
            //     $g = Group::find($request->group);
            //     $g->post_id = 3;
            //     $g->save();
            // }

            if ($request->has('certificate') && $request->certificate) {
                $c = Certificate::find($request->certificate);
                $c->post_id = $request->certificate;
                $c->save();
            }
        }

        if ($request['post_type'] == 'podcast') {
            if (isset($request->file)) {
                if (isset($request->action) && $request->action == 'edit') {
                    $post->files()->delete();
                }
                $fileName =  $slug . '.' . $request->file->extension();
                $url =  $this->upload_with_ftp($fileName, 'podcast');

                //    $url=  $this->upload($request, 'podcast', $slug, 'required|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav');
            } else {
                $url = $request->url;
            }
            $post->files()->create([
                'file' => $url
            ]);
        }




        $post->teachers()->sync($request->teachers);

        return Redirect::route('posts.index', ['post_type' => $request['post_type']]);
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
        $data['page_title'] = $this->page_title;
        $data['post_type'] = $this->post_type;
        $data['post'] = Post::find($id);
        // dd($data['course']->quiz);
        return view('admin.course.create', $data);
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
