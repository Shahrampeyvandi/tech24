<?php

namespace App\Http\Controllers\Admin;

use App\Certificate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class CertificateController extends Controller
{
    public $page_title = 'مدرک';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'certificates' => Certificate::latest()->get(),
            'title' => $this->page_title
        ];
        return view('admin.certificate.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // \DB::table('users')->insert([
        //     array(
        //         'fname'=>'reza',
        //         'lname'=>'shiri',
        //         'avatar'=>null,
        //         'mobile'=>'09381699939',
        //         'username'=>'reza11',
        //         'password'=>\Hash::make('123456'),
        //         'email'=>'test1@gmail.com',
        //         'remember_token'=>null

        //     ),array(
        //         'fname'=>'ali',
        //         'lname'=>'rezai',
        //         'avatar'=>null,
        //         'mobile'=>'09381693949',
        //         'username'=>'ali4',
        //         'password'=>\Hash::make('123456'),
        //         'email'=>'test3@gmail.com',
        //         'remember_token'=>null

        //     ),array(
        //         'fname'=>'javad',
        //         'lname'=>'khiabani',
        //         'avatar'=>null,
        //         'mobile'=>'09381692949',
        //         'username'=>'javati',
        //         'password'=>\Hash::make('123456'),
        //         'email'=>'test4@gmail.com',
        //         'remember_token'=>null

        //         )]
        // );

        $data['page_title'] = $this->page_title;
        return view('admin.certificate.create', $data);
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

        if(isset($request->action)){
            $certificate = Certificate::find($request->group_id);
        }else{
            $certificate = new Certificate;
        }
       
        if ($request->has('file')) {
            if(isset($request->action)){
                File::delete(public_path($certificate->cfile));
            }
            $fileName = $this->upload($request, 'certificate', $request->title);
            // dd($fileName);
            $certificate->cfile = $fileName;
        }
        $certificate->title = $request->title;
        $certificate->save();

        return Redirect::route('certificates.index');

       


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
        $data['certificate'] = Certificate::find($id);
        return view('admin.certificate.create',$data);
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
        Certificate::find($id)->delete();
        return Redirect::route('groups.index');

    }

    public function upload(Request $request, $type, $name)
    {
        $date = date('Y');
        $request->validate([
            "file" => "required|mimes:pdf|max:10000"
        ]);

        $imageName = $name . '.' . $request->file->extension();

        $request->file->move(public_path('uploads/' . $date . '/' . $type), $imageName);
        return 'uploads/' . $date . '/' . $type . '/' . $imageName;
    }
}
