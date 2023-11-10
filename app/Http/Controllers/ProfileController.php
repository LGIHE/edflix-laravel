<?php

namespace App\Http\Controllers;

use Hash;
use App\Models\User;
use App\Models\LessonPlan;
use Jenssegers\Agent\Facades\Agent;
use App\Models\Logs;

class ProfileController extends Controller
{
    public function get(){

        $lessonPlans = LessonPlan::join('subjects', 'lesson_plans.subject', '=', 'subjects.id')
                    ->join('users', 'lesson_plans.owner', '=', 'users.id')
                    ->join('schools', 'lesson_plans.school', '=', 'schools.id')
                    ->select('lesson_plans.*', 'subjects.name as subjectName', 'users.name as ownerName', 'schools.name as schoolName')
                    ->where('lesson_plans.owner', '=', auth()->user()->id)
                    ->orderBy('lesson_plans.created_at', 'asc')
                    ->get();


        return view('user.profile', compact('lessonPlans'));
    }

    public function updateBio()
    {

        $user = request()->user();
        $attributes = request()->validate([
            'email' => 'required|email|unique:users,email,'.$user->id,
            'name' => 'required',
            'phone' => 'required|max:10',
            'location' => 'required'
        ]);

        auth()->user()->update($attributes);

        $log['message'] = 'User with id '. $user->id .' updated their profile';
        $log['user_id'] = Auth()->user()->id;
        $log['action'] = 'Update Profile';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

        return back()->withStatus('Profile successfully updated.');
    }

    public function updatePassword(){

        $attributes = request()->validate([
            'password' => 'required|min:8|confirmed'
        ]);

        #Update the new Password
        $status = User::whereId(auth()->user()->id)->update([
            'password' => Hash::make(request()->password)
        ]);

        $log['message'] = 'User with id '. auth()->user()->id .' updated their password';
        $log['user_id'] = Auth()->user()->id;
        $log['action'] = 'Update Password';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

        return $status ? back()->with('status', 'Password updated successfully')
                    : back()->withErrors('password', 'Error in updating password.');
    }

}
