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

        $comments = $comments->whereApproved(1)->latest()->paginate(15);
        return view('admin.comments.approved-list', compact('comments'));
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
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Comment $comment
     * @return RedirectResponse|Redirector
     */
    public function update(Request $request, Comment $comment)
    {
        $comment->update(['approved' => 1]);
        return back();
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
