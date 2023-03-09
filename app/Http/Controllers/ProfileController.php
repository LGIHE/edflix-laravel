<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LessonPlan;

class ProfileController extends Controller
{
    public function get(){
        $lessonPlans = LessonPlan::all()->where('owner', auth()->user()->id);

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

        return $status ? back()->with('status', 'Password updated successfully')
                    : back()->withErrors('password', 'Error in updating password.');
    }

}
