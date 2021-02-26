<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(auth()->user());

        // dd('d');
        // if($user->can('create user')){
        //     dd('true');
        // }else{
        //     dd('false');
        // }
        //         $role = Role::insert([['name' => 'admin','guard_name'=>'web'],['name' => 'teacher','guard_name'=>'web'],['name' => 'student','guard_name'=>'web']]);
        // $permission = Permission::insert([[
        //         'name' => 'create user','guard_name'=>'web'],[
        //         'name' => 'edit user','guard_name'=>'web'],[
        //         'name' => 'delete user','guard_name'=>'web'],[
        //         'name' => 'create group','guard_name'=>'web'],[
        //         'name' => 'edit group','guard_name'=>'web'],[
        //         'name' => 'delete group','guard_name'=>'web'],[
        //         'name' => 'add user to group','guard_name'=>'web'],[
        //         'name' => 'delete user from group','guard_name'=>'web'],[
        //         'name' => 'create course','guard_name'=>'web'],[
        //         'name' => 'delete course','guard_name'=>'web'],[
        //         'name' => 'edit course','guard_name'=>'web'],[
        //         'name' => 'create lesson','guard_name'=>'web'],[
        //         'name' => 'delete lesson','guard_name'=>'web'],[

        //         'name' => 'edit lesson','guard_name'=>'web'],[
        //         'name' => 'create quiz','guard_name'=>'web'],[
        //         'name' => 'delete quiz','guard_name'=>'web'],[
        //         'name' => 'edit quiz','guard_name'=>'web']]
        //         );
        //          $user = User::find(1);
        //         $user->assignRole('admin');
        //         dd('sd');

        if (isset(request()->q)) {
            $q = request()->q;
            $users = User::role($q)->get();
        } else {
            $users = User::orderBy('group')->get();
        }
        $data = [
            'users' => $users,
            'title' => 'لیست کاربران سایت'
        ];
        return view('admin.users.list', $data);
    }

    /*
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'کاربر';
        return view('admin.users.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        // dd($request->avatar);
        if(isset($request['action']) && $request['action'] == 'edit') {
            $user = User::find($request['user_id']);
            $data = [
                'fname' => 'required',
                'lname' => 'required',
                'username' => 'required|regex:/(^([a-zA-Z]+)(\d+)?$)/u|unique:users,username,'.$user->id,
                'email' => 'required|email|unique:users,email,'.$user->id,
                'password' => 'min:6',
                'mobile' => 'required|regex:/(09)[0-9]{9}/|unique:users,mobile,'.$user->id,
                'group' => 'required',
                'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
                'ability' => 'string'
            ];
            

        }else{

            $data = [
                'fname' => 'required',
                'lname' => 'required',
                'username' => 'required|unique:users|regex:/(^([a-zA-Z]+)(\d+)?$)/u',
                'email' => 'required|email|unique:users',
                'password' => 'min:6',
                'mobile' => 'required|unique:users|regex:/(09)[0-9]{9}/',
                'group' => 'required',
                'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
                'ability' => 'string'
            ];
            $user = new User;
        }
     
        $inputs = $request->validate($data);


        
        $user->fname = $request['fname'];
        $user->lname = $request['lname'];
        $user->username = $request['username'];
        $user->email = $request['email'];
        $user->password = $request['password'];
        $user->mobile = $request['mobile'];
        $user->group = $request['group'];
        $user->ability = $request['ability'];
        $user->save();


        if ($request->has('avatar')) {
            $avatar = $this->upload_picture($request, 'user', $request->mobile);
            $user->avatar = $avatar;
            $user->save();
        }

        $user->syncRoles([$request->group]);

        return Redirect::route('users.index');
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
        $data['title'] = 'کاربر';
        $data['user'] = User::find($id);
        return view('admin.users.create', $data);
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

        $user = User::find($id);
        // dd($user);
        File::delete($user->avatar);
        $user->delete();

        return Redirect::back();
    }

    public function changegroup()
    {

        $user = User::find(request('id'));
        $g = $user->group;

        if ($g == 'student') {
            $user->group = 'teacher';
            $user->syncRoles(['teacher']);
        } else {
            $user->group = 'student';
            $user->syncRoles(['student']);
        }
        $user->save();
        return response()->json(['res' => $user->group], 200);
    }

    public function upload_picture(Request $request, $type, $name)
    {
        $date = date('Y');
        if ($request->avatar) {
            $request->validate([
                'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            ]);

            $imageName = $name . '.' . $request->avatar->extension();

            $request->avatar->move(public_path('uploads/' . $date . '/' . $type), $imageName);
            return 'uploads/' . $date . '/' . $type . '/' . $imageName;
        }
        return null;
    }
}
