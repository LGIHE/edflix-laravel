<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\LessonStep;
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
            'step_field' => 'required_if:target,step',
            'annex' => 'required_if:target,annex',
            'comment' => 'required'
        ]);

        $step = LessonStep::find(request()->step);

        $attributes['user'] = request()->user;
        $attributes['lesson_plan'] = request()->lesson_plan;
        $attributes['commentable_type'] = request()->target;
        $attributes['commentable'] = request()->target == "pleriminary" ? request()->pleriminary
                                    : (request()->target == "step" ? $step->step : request()->annex);

        $attributes['step_field'] = request()->step_field;

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
        $attributes = request()->validate([
            'reply' => 'required',
        ]);

        $attributes['user'] = request()->user;
        $attributes['lesson_plan'] = request()->lesson_plan;
        $attributes['comment'] = request()->comment;
        $reply = Reply::create($attributes);

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
            ->with('status', 'The reply has been added successfully');
    }

    public function markDone()
    {
        Comment::find(request()->id)->update(['is_done' => 1]);
        $done = Comment::find(request()->id)->first();

        return redirect()
            ->route('get.lesson.plan', $done->lesson_plan)
            ->with('status', 'Comment marked as done');
    }
}
