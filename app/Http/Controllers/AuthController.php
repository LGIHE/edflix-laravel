<?php

namespace App\Http\Controllers;

Use Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use Jenssegers\Agent\Facades\Agent;
use App\Models\Logs;

class AuthController extends Controller
{
    public function signInGet()
    {
        return view('auth.signin');
    }

    public function signInPost()
    {
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (! auth()->attempt($attributes)) {
            throw ValidationException::withMessages([
                'email' => 'The credentials provided are invalid.'
            ]);
        }

        session()->regenerate();

        $log['message'] = 'User SignedIn';
        $log['user_id'] = Auth()->user()->id;
        $log['action'] = 'Sign In';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

        return redirect('/dashboard');

    }

    public function verifyPasswordReset(){
        request()->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            request()->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);

    }

    public function resetPassword(){

        request()->validate([
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            request()->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => ($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        $log['message'] = 'User Reset Password';
        $log['user_id'] = Auth()->user()->id;
        $log['action'] = 'Reset Password';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

    public function singOut()
    {
        auth()->logout();

        return redirect('/sign-in');
    }

}
