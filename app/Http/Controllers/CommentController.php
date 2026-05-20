<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::all();
        return view('Comment.index', compact('comments'));
    }

    public function create()
    {
        return view('Comment.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'comment' => 'required',
            'post_id' => 'required',
            'approved' => 'required'
        ]);

        Comment::create($data);
        return redirect()->route('Comment.index');
    }

    public function edit(Comment $comment)
    {
        return view('Comment.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'comment' => 'required',
            'post_id' => 'nullable|integer',
            'approved' => 'nullable|boolean'
        ]);

        $comment->update($data);
        return redirect()->route('Comment.index');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('Comment.index');
    }
}
