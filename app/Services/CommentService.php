<?php

namespace App\Services;

use App\Models\Comment;

class CommentService
{
    public  function  getComment()
    {
        return Comment::paginate(2);
    }

    public function createComment(array  $data)
    {
        try {
            $Comment = Comment::create($data);
            return $Comment;
        }catch (\Exception $exception){
            throw $exception;
        }
    }

    public function updateComment(Comment $comment,array $data)
    {
        $comment->update($data);
        return $comment;
    }

    public function destroyComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
    }
}
