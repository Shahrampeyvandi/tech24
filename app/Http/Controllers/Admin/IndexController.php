<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $notifications = \App\Notification::latest()->paginate(5);
        return view('admin.index',['notifications'=>$notifications]);
    }
}
