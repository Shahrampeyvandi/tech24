<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CommentController extends Controller
{

    public function __construct()
    {
//        $this->middleware('can:show-comments')->only(['index']);
//        $this->middleware('can:unapproved-comments')->only(['unapproved', 'update']);
//        $this->middleware('can:delete-comment')->only(['destroy']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */

    public function index()
    {
        $comments = Comment::query();

        if ($keyword = request('search')) {
            $comments->where('comment', 'LIKE', "%{$keyword}%")->orWhereHas('user', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%$keyword%");
            });
        }

        if(request()->query('q') == 'unapproved') {
            $approved = 0;
        }else{
            $approved = 1;
        }

        $data['comments'] = $comments->whereApproved($approved)->latest()->get();
        $data['count'] = [
            'approvedComments' => Comment::where('approved',1)->count(),
            'unapprovedComments' => Comment::where('approved',0)->count(),
        ];

        return view('admin.comments.index',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Factory|View
     */
    public function unapproved()
    {
        $comments = Comment::whereApproved(0)->latest()->paginate(15);
        return view('admin.comments.unapproved-list', compact('comments'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        // dd($comment);
        return view('admin.comments.create',['comment'=>$comment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Comment $comment
     * @return RedirectResponse|Redirector
     */
    public function update(Request $request, Comment $comment) : RedirectResponse
    {
        
        $comment->update(['approved' => 1,'comment'=>$request->comment]);
        return Redirect::route('comments.index',['q'=>'approved']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Comment $comment
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return back();
    }
}
