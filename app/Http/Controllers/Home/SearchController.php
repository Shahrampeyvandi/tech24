<?php

namespace App\Http\Controllers\Home;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class SearchController extends Controller
{
    
    public function index()
    {
       
        return view('home.search.index');
    }

    /**
     * search
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function search(Request $request) : JsonResponse
    {
        
        $type = $request['q'];
        
        $posts = Post::search($request['word'])->latest()->paginate(8);
        if($type !== 'all') $posts=Post::search($request['word'])->where('post_type',$type)->latest()->paginate(8);
        return Response::json(['data'=>$posts,'status'=>'success'],200);
    }
}
