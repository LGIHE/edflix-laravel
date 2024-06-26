<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\LessonStep;
use App\Models\Logs;
use App\Models\Reply;
use Illuminate\Http\Request;
use Jenssegers\Agent\Facades\Agent;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\CommentNotification;
use App\Models\LessonPlan;

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

        LessonStep::find(request()->step);

        $attributes['user'] = request()->user;
        $attributes['lesson_plan'] = request()->lesson_plan;
        $attributes['commentable_type'] = request()->target;
        $attributes['commentable'] = request()->target == "pleriminary" ? request()->pleriminary
                                    : (request()->target == "step" ? request()->step_no : request()->annex);

        $attributes['target_field'] = request()->target == "step" ? request()->step_field : request()->annex_field;

        $attributes['comment'] = request()->comment;
        $comment = Comment::create($attributes);

        if($comment){
            $lesson_plan = LessonPlan::find(request()->lesson_plan);
            $user = User::find($lesson_plan->owner);
            $user->lesson_plan = $lesson_plan;
            $user->comment = $comment;
            Mail::to($user->email)->send(new CommentNotification($user));
        }

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

    public function getComments(Request $request)
    {
        if($request->target == 'pleriminary')
        {
            $comments = Comment::join('users', 'comments.user', '=', 'users.id')
                            ->where('comments.lesson_plan', $request->lesson)
                            ->where('comments.commentable_type', $request->target)
                            ->where('comments.commentable', $request->content)
                            ->orderBy('comments.created_at', 'desc')
                            ->select('comments.*', 'users.name as username')
                            ->get();
        }
        else {
            $comments = Comment::join('users', 'comments.user', '=', 'users.id')
                            ->where('comments.lesson_plan', $request->lesson)
                            ->where('comments.commentable_type', $request->target)
                            ->where('comments.commentable', $request->content)
                            ->where('comments.target_field', $request->target_field)
                            ->orderBy('comments.created_at', 'desc')
                            ->select('comments.*', 'users.name as username')
                            ->get();
        }

        return response()->json($comments);
    }

    public function getFieldComments(Request $request)
    {
        if($request->target === 'pleriminary')
        {
            $comments = Comment::where('lesson_plan', $request->lesson)
                                ->where('commentable_type', $request->target)
                                ->where('commentable', $request->commentable)
                                ->get();
        }
        else {
            $comments = Comment::where('lesson_plan', $request->lesson)
                                ->where('commentable_type', $request->target)
                                ->where('commentable', $request->commentable)
                                ->where('target_field', $request->field)
                                ->get();
        }

        return response()->json($comments);
    }

    public function updateComment()
    {
        if (request()->user != auth()->user()->id) {
            return redirect()
            ->route('get.lesson.plan', request()->lesson_plan)
            ->with('error', 'Unauthorized action.');
        }

        request()->validate([
            'comment' => 'required'
        ]);

        $comment = Comment::find(request()->id);
        $comment->update(['comment' => request()->comment]);

        return response()->json(['id' => request()->lesson_plan]);
    }

    public function successUpdateComment()
    {
        return redirect()
            ->route('get.lesson.plan', request()->id)
            ->with('status', 'The comment was updated successfully');
    }

    public function deleteComment()
    {
        $comment = Comment::find(request()->id);
        $lp = $comment->lesson_plan;

        if (!auth()->user()->isAdmin() && $comment->user != auth()->user()->id) {
            return redirect()
            ->route('get.lesson.plan', $lp)
            ->with('error', 'Unauthorized action. You cannot delete this comment.');
        }

        $comment->delete();

        return redirect()
            ->route('get.lesson.plan', $lp)
            ->with('status', 'Comment has been deleted.');
    }

}
