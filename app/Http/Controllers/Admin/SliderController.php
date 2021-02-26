<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class GroupController extends Controller
{
    public $page_title = 'اسلایدر';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'sliders' => Slider::latest()->get(),
            'title' => $this->page_title
        ];
        return view('admin.slider.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      

        $data['page_title'] = $this->page_title;
        return view('admin.slider.create', $data);
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

        if (isset($request->action)) {
            $slider = Slider::find($request->slider_id);
        } else {
            $slider = new Slider;
        }

        $slider->capacity = $request->capacity;

        if ($request->has('picture')) {
            if (isset($request->action)) {
                File::delete(public_path($slider->image));
            }
            $fileName = $this->upload_picture($request, 'group', $request->title);
            // dd($fileName);
            $slider->image = $fileName;
        }

        $slider->title = $request->title;
        $slider->type = $request->type;
        $slider->save();


        foreach ($request->members as $key => $member) {
            $members_arr[$member] = ['leader' => 0];
        }
        foreach ($request->leaders as $key => $leader) {
            $members_arr[$leader] = ['leader' => 1];
        }
        // dd($members_arr);


        $slider->members()->sync($members_arr);
        return Redirect::route('groups.index');
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
        $data['slider'] = Slider::find($id);
        return view('admin.slider.create', $data);
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
        Slider::find($id)->delete();
        return Redirect::route('slider.index');
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
