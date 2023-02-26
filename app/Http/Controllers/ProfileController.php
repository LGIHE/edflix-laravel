<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function create()
    {
        return view('pages.new');
    }

    public function update()
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

        // $status = Password::reset(
        //     request()->only('email', 'password', 'password_confirmation', 'token'),
        //     function ($user, $password) {
        //         $user->forceFill([
        //             'password' => ($password)
        //         ])->setRememberToken(Str::random(60));

        //         $user->save();

        //         event(new PasswordReset($user));
        //     }
        // );

        // return $status === Password::PASSWORD_RESET
        //             ? redirect()->route('login')->with('status', __($status))
        //             : back()->withErrors(['email' => [__($status)]]);

        #Update the new Password
        $status = User::whereId(auth()->user()->id)->update([
            'password' => Hash::make(request()->password)
        ]);

        return $status ? back()->with('status', 'Password updated successfully')
                    : back()->withErrors('password', 'Error in updating password.');
    }

}
