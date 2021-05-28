<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use App\Blog;
use App\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class BlogController extends Controller
{
    public $page_title = 'بلاگ';
    public function create()
    {
        $data['page_title'] = $this->page_title;
        return view('admin.blog.add', $data);
    }

    public function UploadImage()
    {
        if (request()->hasFile('upload')) {

            $tmpName = $_FILES['upload']['tmp_name'];

            $size = $_FILES['upload']['size'];
            $filePath = "blogs/images-content/" . date('d-m-Y-H-i-s');
            $filename = request()->file('upload')->getClientOriginalName();

            if (!file_exists($filePath)) {
                mkdir($filePath, 0755, true);
            }
            $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $type = $_GET['type'];
            $funcNum = isset($_GET['CKEditorFuncNum']) ? $_GET['CKEditorFuncNum'] : null;

            if ($type == 'image') {
                $allowedfileExtensions = array('jpg', 'jpeg', 'gif', 'png');
            } else {
                //file
                $allowedfileExtensions = array('jpg', 'jpeg', 'gif', 'png', 'pdf', 'doc', 'docx');
            }


            //contrinue only if file is allowed
            if (in_array($fileExtension, $allowedfileExtensions)) {

                if (request()->file('upload')->move(public_path($filePath), $filename)) {
                    // if (move_uploaded_file($tmpName, $filePath)) {
                    $file = "$filePath/$filename";
                    // $filePath = str_replace('../', 'http://filemanager.localhost/elfinder/', $filePath);
                    $data = ['uploaded' => 1, 'fileName' => $filename, 'url' => URL::to('/') . '/' . $file];

                    if ($type == 'file') {

                        return "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$filePath','');</script>";
                    }
                } else {

                    $error = 'There has been an error, please contact support.';

                    if ($type == 'file') {
                        $message = $error;

                        return "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$filePath', '$message');</script>";
                    }

                    $data = array('uploaded' => 0, 'error' => array('message' => $error));
                }
            } else {

                $error = 'The file type uploaded is not allowed.';

                if ($type == 'file') {
                    $funcNum = $_GET['CKEditorFuncNum'];
                    $message = $error;

                    return "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$filePath', '$message');</script>";
                }

                $data = array('uploaded' => 0, 'error' => array('message' => $error));
            }

            //return response
            return json_encode($data);
        }
    }

    public function store(Request $request)
    {

        $slug = SlugService::createSlug(Blog::class, 'slug', $request->title);

        if (isset($request->action) && $request->action == 'edit') {
            $blog = Blog::find($request->blog_id);
        }else{
            $blog = new Blog;
        }

        if ($request->has('picture')) {
            if (isset($request->action) && $request->action == 'edit') {
                File::delete(public_path($blog->picture));
            }
            $fileName = $this->upload_picture($request, 'blog', $slug);
            // dd($fileName);
            $blog->picture = $fileName;
        }

        $blog->title = $request->title;
        $blog->url = $request->url;
        if (isset($request->action) && $request->action == 'edit' && $request->change_desc ) {
            $blog->description = $request->description;
        }else{

            $blog->description = $request->description ? $request->description : '';
        }
        $blog->short_description = $request->short_description ? $request->short_description : '';
        $blog->views = 10;

        if($request->category) {
            $cat = BlogCategory::firstOrCreate(['name' => $request->category]);
            $blog->category_id = $cat->id ?? null;
        }
        $blog->video_frame = $request->video_frame;

        $blog->seo_title = $request->seo_title;
        $blog->seo_description = $request->seo_description;
        $blog->seo_canonical = $request->seo_canonical;

        $blog->save();

        if ($request->has('tags')) {
            $tag_ids = [];
            foreach ($request->tags as $key => $item) {
                $tag  = Tag::firstOrCreate(['tagname' => $item]);
                $tag_ids[] = $tag->id;
            }
            $blog->tags()->sync($tag_ids);
        }


        return redirect()->route('blogs.index');
    }

    function index()
    {
        $data = [
            'blogs' => Blog::latest()->get(),
            'title' => $this->page_title
        ];
        return view('admin.blog.list',$data);
    }

    public function destroy($id)
    {

        $blog = Blog::find($id);
        File::delete(public_path($blog->picture));
        $blog->tags()->detach();
        // $blog->comments()->delete();
        // $blog->videos()->delete();
        // $blog->links()->delete();
        $blog->delete();



        return back();
    }

    public function Edit(Blog $blog)
    {

        $data['page_title'] = $this->page_title;
        $data['blog'] = $blog;
        return view('admin.blog.add', $data);
    }

    public function SaveEdit(Request $request, Blog $blog)
    {

        $destinationPath = "blogs";
        if ($request->hasFile('poster')) {
            File::delete(public_path() . $blog->poster);
            $picextension = $request->file('poster')->getClientOriginalExtension();
            $fileName = $request->name .  '-poster_' . date("Y-m-d") . '_' . time() . '.' . $picextension;
            $request->file('poster')->move($destinationPath, $fileName);
            $Poster = "$destinationPath/$fileName";
        } else {
            $Poster = $blog->poster;
        }

        $blog->title = $request->name;
        $blog->poster = $Poster;
        $blog->description = $request->desc;
        $blog->views = 10;
        $blog->category_id = $request->category;

        $blog->update();






        $blog->links()->delete();

        foreach ($request->link_name as $key => $name) {
            if (!is_null($name)) {
                $blog->links()->create([
                    'name' => $name,
                    'url' => $request->link_url[$key]
                ]);
            }
        }


        return redirect()->route('Panel.BlogList');
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
