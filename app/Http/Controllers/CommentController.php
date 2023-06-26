<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Logs;
use App\Models\Reply;
use Jenssegers\Agent\Facades\Agent;

class CommentController extends Controller
{
    public function addComment()
    {
        request()->validate([
            'target' => 'required',
            'pleriminary' => 'required_if:target,pleriminary',
            'step' => 'required_if:target,step',
            'annex' => 'required_if:target,annex',
            'comment' => 'required'
        ]);

        $attributes['user'] = request()->user;
        $attributes['lesson_plan'] = request()->lesson_plan;
        $attributes['commentable_type'] = request()->target;
        $attributes['commentable'] = request()->target == "pleriminary" ? request()->pleriminary
                                    : (request()->target == "step" ? request()->step : request()->annex);

        $attributes['comment'] = request()->comment;
        $comment = Comment::create($attributes);

        $log['message'] = 'Added Comment for Lessonplan with id '. $comment->lesson_plan;
        $log['user_id'] = Auth()->user()->id;
        $log['action'] = 'Add Comment';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

        return response()->json(['id' => request()->lesson_plan]);
    }

    public function successAddComment()
    {
        return redirect()
            ->route('get.lesson.plan', request()->id)
            ->with('status', 'The lesson plan comment has been added successfully');
    }

    public function addReply()
    {
        request()->validate([
            'reply' => 'required',
        ]);

        $reply = Reply::create(request()->all);

        $log['message'] = 'Added Comment for Lessonplan with id '. $reply->lesson_plan;
        $log['user_id'] = Auth()->user()->id;
        $log['action'] = 'Add Reply';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

        return response()->json(['id' => request()->lesson_plan]);
    }

    public function successAddReply()
    {
        return redirect()
            ->route('get.lesson.plan', request()->id)
            ->with('status', 'The lesson plan comment has been added successfully');
    }
}
