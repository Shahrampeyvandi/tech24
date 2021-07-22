<?php

namespace App\Http\Controllers\Admin;

use App\Media;
use App\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    public $page_title = 'تنظیمات';


    public function index()
    {
        $data = [
            'settings' => Setting::all(),
            'title' => $this->page_title
        ];
        return view('admin.setting.index', $data);
    }


    public function create()
    {
        $data['page_title'] = $this->page_title;
        return view('admin.setting.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        if (isset($request->action)) {
            $setting = Setting::find($request->setting_id);
        } else {

            $setting = new Setting;
        }


        $setting->key = $request->key;
        $setting->value = $request->value;
        $setting->save();

        return Redirect::route('settings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data['page_title'] = $this->page_title;
        $data['setting'] = Setting::find($id);
        return view('admin.setting.create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Setting::find($id)->delete();
        return Redirect::route('settings.index');
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


    public function uploadMedia()
    {
        $data['page_title'] = 'رسانه';
        return view('admin.media.add', $data);
    }

    public function submitUploadMedia(Request $request): \Illuminate\Http\RedirectResponse
    {

        $media = new Media;
        $slug = SlugService::createSlug(Media::class, 'slug', $request->name);
        $fileName = $slug . '.' . $request->file->extension();
        // dd(mime_content_type($request->file));
        if(isset($_FILES['file'])) {
            $mime = $_FILES['file']['type'];
            if(strstr($mime, "video/")){
            $filetype = "video";
            }else if(strstr($mime, "image/")){
            $filetype = "image";
            }else {
            return back();
            } 
            
        }
       
        $date = date('Y');
        $path = 'public_html/media/' . $date . '/' . $fileName;

        $conn = ftp_connect(env('FTP_HOST'));
        $login = ftp_login($conn, env('FTP_USERNAME'), env('FTP_PASSWORD'));
        ftp_set_option($conn, FTP_USEPASVADDRESS, false);
        ftp_pasv($conn, true);


        if (ftp_nlist($conn, 'public_html/media/' . $date) == false) {
            ftp_mkdir($conn, 'public_html/media/' . $date);
        }

        if (in_array($path, ftp_nlist($conn, 'public_html/media/' . $date))) {
            $fileName = $slug . '-' . Str::random() . '.' . $request->file->extension();
        }

        ftp_put($conn, 'public_html/media/' . $date . '/' . $fileName, $_FILES['file']['tmp_name'], FTP_BINARY);
        ftp_close($conn);
        $url = env('DL_HOST_URL') . '/media/' . $date . '/' . $fileName;

        $media->name = $request->name;
        $media->url = $url;
        $media->media = $filetype;
        $media->save();

        return Redirect::route('media.index');
    }

    public function mediaIndex()
    {
        $data = [
            'medias' => Media::latest()->get(),
            'title' => 'رسانه'
        ];
        return view('admin.media.index', $data);
    }

    public function robot()
    {
        // $robot_file
        $data = [
            'page_title' => 'robot'
        ];
        return view('admin.setting.robots', $data);
    }

    public function storeRobots()
    {
        file_put_contents(public_path('robots.txt'),request()->post('robots'));
        return back();
    }
}
