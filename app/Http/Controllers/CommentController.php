<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with('post')
        ->orderBy('created_at', 'desc')
        ->paginate(20);

        return view('Comment.index', compact('comments'));
    }

    public function create()
    {
        return view('Comment.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comment' => 'required|string|min:2',
            'post_id' => 'required|integer',
        ]);


        $data['approved'] = false;

        Comment::create($data);

        return redirect()->route('comment.index')
            ->with('success', 'Комментарий успешно добавлен и ожидает модерации.');
    }

    public function edit(Comment $comment)
    {
        // $posts = Post::pluck('title', 'id');
        return view('Comment.edit', compact('comment')); //, 'posts'));
    }

    public function update(Request $request, Comment $comment)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comment' => 'required|string|min:2',
            'post_id' => 'sometimes|nullable|integer|exists:posts,id', // sometimes вместо nullable
            'approved' => 'sometimes|boolean'
        ]);

        $comment->update($data);

        return redirect()->route('Comment.index')
            ->with('success', 'Комментарий успешно обновлен.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->route('Comment.index')
            ->with('success', 'Комментарий успешно удален.');
    }

    public function approve(Comment $comment)
    {
        $comment->update(['approved' => true]);

        return back()->with('success', 'Комментарий одобрен.');
    }

    public function reject(Comment $comment)
    {
        $comment->update(['approved' => false]);

        return back()->with('success', 'Комментарий отклонен.');
    }
}
