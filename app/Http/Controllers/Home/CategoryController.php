<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public $title = 'تکوان | دسته بندی';
    public function webinars(Request $request)
    {
        // dd($request->url());
        $data = [
            'title' => $this->title
        ];
        return view('home.webinars',$data);
    }
    public function courses(Request $request)
    {
        // dd($request->url());
    }
    public function podcasts(Request $request)
    {
        // dd($request->url());
    }
}
