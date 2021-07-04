<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{

    public $page_title = 'دسته بندی پست ها';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $data = [
            'categories' => Category::with('parent')->latest()->get(),
            'title' => $this->page_title,

        ];

        // dd($data);

        return view('admin.category.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data['page_title'] = $this->page_title;
        return view('admin.category.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'title' => 'required'
        ]);

        if ($request->action == 'edit') {
            $q = Category::find($request->category_id);
        } else {
            $q = new Category();
        }

        $slug = SlugService::createSlug(Category::class, 'slug', $request->title);
        $q->title = $request->title;
        $q->parent_id = $request->parent_id;
        $q->slug = $slug;

        if ($request->image) {
            if ($request->action == 'edit') {
                File::delete(public_path($q->picture));
            }
            
            $date = date('Y');
            $imageName = $slug . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/' . $date . '/' . 'category'), $imageName);
            $q->picture = 'uploads/' . $date . '/' . 'category' . '/' . $imageName;
        }




        $q->appearance = $request->appearance;

        $q->save();


        return Redirect::route('categories.index');
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
        $data['category'] = Category::find($id);
        return view('admin.category.create', $data);
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
        // dd($id);
        $cat = Category::find($id);
        Category::where('parent_id', $cat->id)->delete();
        $cat->delete();
        return Redirect::route('categories.index');
    }
}
