<?php

namespace App\Http\Controllers\Admin;

use App\AdobeGroup;
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
use Illuminate\Support\Facades\Response;

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

        // dd($request->all());

        // dd($_FILES['picture']['tmp_name']);


        if (isset($request->action) && $request->action == 'edit') {

            $post = Post::find($request->post_id);
            $rules = ['title' => 'required|unique:posts,title,' . $post->id];
            if ($request['post_type'] == 'podcast' && isset($request->file)) {
                $post->files()->delete();
            }
        } else {
            $post = new Post;
            $rules = ['title' => 'required|unique:posts'];
        }


        if ($request['post_type'] == 'podcast') {
            $rules['file'] =  'mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav';
            $rules['url'] = 'required_without:file';
            $mime = 'audio';
        } else {
            $mime = null;
        }

        if ($request['post_type'] == 'webinar') {
            $rules['group_name'] = 'required';
        }

        $request->validate($rules);
        // dd($request->all());




        try {
            $slug = SlugService::createSlug(Post::class, 'slug', $request->title);

            // $res =   $this->getInfoSCO($request->sco_id);
            
            // if (is_array($res) && isset($res['status']['@attributes']['code']) && $res['status']['@attributes']['code'] == 'ok') {
            // $post->sco_id = $request->sco_id;
            // dd($res);
            // // 50422
            // }else{
            //     return Response::json(['message'=>'احتمالا کد sco وارد شده اشتباه است'],500);
            // }


            if ($request->has('picture') && $request->picture) {
                if (isset($request->action) && $request->action == 'edit') {
                    File::delete(public_path($post->picture));
                }
                $fileName = $this->upload_picture($request, $this->post_type, $slug);
                $post->picture = $fileName;
            }
            $post->title = $request->title;
            $post->sco_url = isset($request->sco_id) && $request->sco_id ? $request->sco_id : null;
            $post->description = $request->desc;
            $post->short_description = $request->short_description ? $request->short_description : null;
            $post->media = $mime ? 'audio' : 'video';
            $post->post_type = $this->post_type;
            $post->duration = $request->duration;
            $post->cash = $request->cash_type;
            $post->price = $request->price;
            $post->views = 1;
            $post->teacher_id = $request->teachers;
            $post->group_id = $request->group;
            $post->start_date = $request->date ? carbonDate($request->date) : '';
            $post->private = $request->public_type == 'private' ? 1 : 0;

            if ($request->archive == 'yes') {
                $post->archive = 1;
            }

            $cat = Category::firstOrCreate([
                'title' => $request->category,
                'parent_id' => $request->parent_category
            ], [
                'slug' => SlugService::createSlug(Category::class, 'slug', $request->category),
            ]);
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


            if (isset($request->file) && $request->file) {
                if (isset($request->action) && $request->action == 'edit') {
                    foreach ($post->files as $key => $file) {
                        $this->delete_with_ftp($file->file);
                    }
                    $post->files()->delete();
                }
                $fileName =  $slug . '.' . $request->file->extension();
                $url =  $this->upload_with_ftp($fileName, $this->post_type);

                //    $url=  $this->upload($request, 'podcast', $slug, 'required|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav');
            } elseif (isset($request->url) && $request->url) {
                $url = $request->url;
            }

            if(isset($url)) {
                $post->files()->create([
                    'file' => $url
                ]);
            }

            if (isset($request->action) && $request->action == 'edit') {
            } else {
                if ($request->group_name) {
                    $response =  $this->create_group_adobe($post, $request->group_name);
                    if ($response['status']['@attributes']['code'] == 'ok') {
                        $group = new AdobeGroup;
                        $group->principal_id = $response['principal']['@attributes']['principal-id'];
                        $group->account_id = $response['principal']['@attributes']['account-id'];
                        $group->name = $response['principal']['name'];
                        $group->post_id = $post->id;
                        $group->save();
                    }
                }
            }


            $post->teachers()->sync($request->teachers);
        } catch (\Throwable $th) {
            throw $th;
        }
        return Response::json(['status' => 'success', 'url' => url('admin-panel/posts') . '?post_type=' . $request['post_type'] . ''], 200);
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

        // $file = 'http://download.techone24.com/uploads/webinar/2021/وبینار-گذشته.mp4';
        // $conn = ftp_connect(env('FTP_HOST'));
        // $login = ftp_login($conn, env('FTP_USERNAME'), env('FTP_PASSWORD'));
        // ftp_set_option($conn, FTP_USEPASVADDRESS, false);
        // ftp_pasv($conn, true);
        // dd(ftp_nlist($conn, 'course/2021'));
        // // if (ftp_nlist($conn, $path) == true) {

        // //     ftp_delete($conn, $path);
        // // }
        // ftp_close($conn);

        $post = Post::find($id);
        File::delete($post->picture);
        $post->tags()->detach();
        $post->quiz()->delete();
        $post->prerequisites()->detach();


        $group = Group::find($post->group_id);
        if ($group) {

            $group->members()->detach();
            Group::find($post->group_id)->delete();
        }

        foreach ($post->files as $key => $file) {
            $this->delete_with_ftp(implode('/', array(explode('/', $file->file)[4], explode('/', $file->file)[5], explode('/', $file->file)[6])));
        }
        $post->files()->delete();

        $post->delete();
        return Redirect::back();
    }

    public function parent_category()
    {
        // dd(\request()->title);
        $cat = Category::whereTitle(request()->title)->first();
        if ($cat) {
            if ($cat->parent_id !== 0) {

                $parent = Category::where('id', $cat->parent_id)->first();
                $parent_id = $parent->id;
            } else {
                $parent_id = 0;
            }
            return Response::json(['id' => $parent_id], 200);
        }
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

    protected function create_group_adobe($groupname)
    {



        try {
            $ch = curl_init('' . env('ADOBE_CONNECT_HOST') . '/api/xml?action=login&login=' . env('ADOBE_CONNECT_USER_NAME') . '&password=' . env('ADOBE_CONNECT_PASSWORD') . '');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies');
            curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies');
            $data = curl_exec($ch);
            curl_close($ch);

            $ch = curl_init('' . env('ADOBE_CONNECT_HOST') . '/api/xml?action=principal-update&has-children=1&type=group&name=' . $groupname . '');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies');
            curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies');
            $data = curl_exec($ch);
            curl_close($ch);
            return $arr = json_decode(json_encode(simplexml_load_string($data)), true);
        } catch (\Exception $th) {
            throw $th;
        }
    }

    public function getInfoSCO($sco_id)
    {

        $ch = curl_init('http://online.techone24.com/api/xml?action=login&login=test@gmail.com&password=123456');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies');
        curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies');
        $data = curl_exec($ch);
        // dd($data);
        curl_close($ch);

        $ch = curl_init('' . env('ADOBE_CONNECT_HOST') . '/api/xml?action=sco-info&sco-id=' . $sco_id . '');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies');
        curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies');
        $data = curl_exec($ch);
        // echo '<pre>';
        // var_dump($data);
        // echo '</pre>';
        return json_decode(json_encode(simplexml_load_string($data)), true);
    }
}
