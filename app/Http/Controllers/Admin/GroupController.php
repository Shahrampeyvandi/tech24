<?php

namespace App\Http\Controllers\Admin;

use App\Group;
use App\Http\Controllers\Controller;
use App\Post;
use App\User;
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

        $post = Post::find($request->post_id);
        if($post) {
            $post->group_id = $group->id;
            $post->save();
        }


        foreach ($request->members as $key => $member) {
            $members_arr[$member] = ['leader' => 0];
        }
        foreach ($request->leaders as $key => $leader) {
            $members_arr[$leader] = ['leader' => 1];
        }
        // dd($members_arr,array_keys($members_arr));
        if (isset($request->action)) {
            foreach ($group->members as $key => $val) {
                if (!in_array($val->id, array_keys($members_arr))) {
                    $val->posts()->detach($request->post_id);
                }
            }
        }



        $group->members()->sync($members_arr);

        foreach ($members_arr as $key => $val) {
            $member = User::find($key);
            // dd($member,$member->posts);
            if (! $member->posts->contains($request->post_id)) {
                $member->posts()->attach($request->post_id);
            }
        }

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
