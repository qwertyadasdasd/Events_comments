<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with('event')
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
            'post_id' => 'nullable|integer',
            'event_id' => 'nullable|integer',
        ]);

        $createData = [
            'title' => 'Комментарий от ' . $data['name'],
            'content' => $data['comment'],
            'author' => $data['name'],
            'email' => $data['email'],
            'category' => 'Общий',
            'rating' => 0,
            'event_id' => $data['event_id'] ?? 1,
            // 'approved' => false,
        ];

        Comment::create($createData);

        return redirect()->route('comments.index')
            ->with('success', 'Комментарий успешно добавлен и ожидает модерации.');
    }

    public function edit(Comment $comment)
    {
        return view('Comment.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comment' => 'required|string|min:2',
            'post_id' => 'nullable|integer',
            'approved' => 'sometimes|boolean'
        ]);

        // Преобразуем comment в content для БД
        if (isset($data['comment'])) {
            $data['content'] = $data['comment'];
            unset($data['comment']);
        }

        $comment->update($data);

        return redirect()->route('comments.index')
            ->with('success', 'Комментарий успешно обновлен.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->route('comments.index')
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
