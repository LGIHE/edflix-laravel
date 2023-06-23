<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function addComment()
    {
        $attributes = request()->validate([
            'comment' => 'required'
        ]);

        $attributes['user'] = auth()->user()->id;
        $attributes['lesson_plan'] = request()->lesson_plan;
        $attributes['commentable_type'] = request()->commentable_type;
        $attributes['commentable_id'] = request()->commentable_id;
        $attributes['is_done'] = request()->is_done;

        Comment::create($attributes);

        return redirect()
                ->route('get.lesson.plan', request()->lesson_plan)
                ->with('status', 'Comment sent successfully.');

    }
}
