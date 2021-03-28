<?php

namespace App\Http\Controllers\Admin;

use App\Quiz;
use App\Lesson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use \Cviebrock\EloquentSluggable\Services\SlugService;


class LessonController extends Controller
{
    public $page_title = 'درس';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $data = [
            'lessons' => Lesson::latest()->get(),
            'title' => $this->page_title
        ];
        return view('admin.lesson.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data['page_title'] = $this->page_title;
        return view('admin.lesson.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $date = date('Y');
        // $conn = ftp_connect(env('FTP_HOST'));
        // $login = ftp_login($conn, env('FTP_USERNAME'), env('FTP_PASSWORD'));
        // ftp_set_option($conn, FTP_USEPASVADDRESS, false);
        // ftp_pasv($conn, true);
        // if (ftp_nlist($conn, 'course' . '/' . $date) == false) {
        //     ftp_mkdir($conn, 'course' . '/' . $date);
        // }
        // ftp_put($conn, 'course' . '/' . $date . '/' . 'jadid.mp4', $_FILES['file']['tmp_name'], FTP_BINARY);
        // ftp_close($conn);
        // dd('d');

       
        // dd($request->all());

        $slug = SlugService::createSlug(Lesson::class, 'slug', $request->title);
        if (isset($request->action) && $request->action == 'edit') {
            $request->validate([
                'title' => 'required',
    
            ]);
            $lesson = Lesson::find($request->lesson_id);
            // dd($lesson->quiz);
        } else {
            $request->validate([
                'url' => 'required_without:file',
                'title' => 'required',
                'file' => "required|mimes:mp4,3gp"
    
            ]);
            
            $lesson = new Lesson;
        }

        if ($request->has('picture') && $request->picture ) {
            if (isset($request->action)) {
                File::delete(public_path($lesson->picture));
            }
            $fileName = $this->upload_picture($request, 'lesson', $slug);
            $lesson->picture = $fileName;
        }

       


        $lesson->title = $request->title;
        $lesson->post_id = $request->course;
        $lesson->duration = $request->duration;
        $lesson->description = $request->desc;
        $lesson->cash = $request->cash_type;
        $lesson->price = $request->cash;
        $lesson->number = $request->number;

        $lesson->save();

        if ($request->has('file')  && $request->file) {
            if (isset($request->action) && $request->action == 'edit') {
                // File::delete(public_path($lesson->url));
                // dd($lesson,$lesson->files);
                foreach ($lesson->files as $key => $file) {
                    // dd('d');
                    $this->delete_with_ftp($file->file);
                }
                $lesson->files()->delete();
            }
            // dd('ss');

            // $fileName = $this->upload($request, 'lesson', $slug, "required|mimes:mp4,3gp");

            $fileName = $slug . '.' . $request->file->extension();
            // dd($fileName);
            $url = $this->upload_with_ftp($fileName, 'course');
        } else {
            if($request->url) {
                $url = $request->url;
            }
        }

        if(isset($url)) {
            $lesson->files()->create([
                'file' => $url
            ]);
        }

        if ($request->has('quiz')&& $request->quiz) {
            if($request->quiz){
            $q = Quiz::find($request->quiz);
            $q->quizable_id = $lesson->id;
            $q->quizable_type = 'App\Lesson';
            $q->save();
            }else{
               $q = $lesson->quiz;
               $q->quizable_id = null;
               $q->quizable_type = null;
               $q->save();
            }
        }


        return Response::json(['status' => 'success', 'url' => route('lessons.index')], 200);

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
        $data['lesson'] = Lesson::find($id);
        return view('admin.lesson.create', $data);
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
        $lesson = Lesson::findOrFail($id);
        foreach ($lesson->files as $key => $file) {
            // dd('d');
            $this->delete_with_ftp($file->file);
        }
        $lesson->files()->delete();
        $lesson->delete();
        return Redirect::route('lessons.index');
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
