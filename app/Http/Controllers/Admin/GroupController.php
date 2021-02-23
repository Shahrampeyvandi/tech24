<?php

namespace App\Http\Controllers\Admin;

use App\Group;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class GroupController extends Controller
{
    public $page_title = 'گروه';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'groups' => Group::latest()->get(),
            'title' => $this->page_title
        ];
        return view('admin.group.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      

        $data['page_title'] = $this->page_title;
        return view('admin.group.create', $data);
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
            $group = Group::find($request->group_id);
        } else {

            $group = new Group;
        }

        $group->capacity = $request->capacity;

        if ($request->has('picture')) {
            if (isset($request->action)) {
                File::delete(public_path($group->image));
            }
            $fileName = $this->upload_picture($request, 'group', $request->title);
            // dd($fileName);
            $group->image = $fileName;
        }

        $group->title = $request->title;
        $group->type = $request->type;
        $group->save();


        foreach ($request->members as $key => $member) {
            $members_arr[$member] = ['leader' => 0];
        }
        foreach ($request->leaders as $key => $leader) {
            $members_arr[$leader] = ['leader' => 1];
        }
        // dd($members_arr);


        $group->members()->sync($members_arr);
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
        $data['group'] = Group::find($id);
        return view('admin.group.create', $data);
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
        Group::find($id)->delete();
        return Redirect::route('groups.index');
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
