<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\User;
use Carbon\Carbon;
use Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use Jenssegers\Agent\Facades\Agent;
use App\Mail\SignupConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Logs;
use App\Models\School;

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

        return redirect()->route('dashboard');

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

        if (auth()->check()) {
            // User is authenticated, so it's safe to access the id property.
            $log['user_id'] = auth()->user()->id;
        }

        $log['message'] = 'User Reset Password';
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

    public function signUpGet()
    {
        $schools = School::all()->sortBy('name');
        $subjects = Subject::all()->sortBy('code');

        return view('auth.signup', compact('schools', 'subjects'));
    }

    public function signUpPost()
    {

        $attributes = request()->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|numeric|min:10',
            'town' => 'required',
            'district' => 'required',
            'role' => 'required',
            'password' => 'required|min:5|max:255',
            'school' => 'required|numeric',
            'subject_1' => 'required',
            'subject_2' => 'nullable',
            'subject_3' => 'nullable',
        ]);

        $attributes['location'] = $attributes['town'].', '.$attributes['district'].', Uganda';
        $attributes['role'] = 'Teacher';
        $attributes['type'] = 'teacher';
        $attributes['email_verified_at'] = Carbon::now()->toDateTimeString();

        $user = User::create($attributes);
        $user['pass'] = '';

        Mail::to($user->email)->send(new SignupConfirmation($user));

        $log['message'] = 'User with id '. $user->id .' Created';
        $log['user_id'] = $user->id;
        $log['action'] = 'Create User';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

        return response()->json(['success' => true]);

    }

    public function signUpSuccess()
    {
        return view('auth.success');
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToGoogle(): \Illuminate\Http\RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Check if the user already exists in your database
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // Create a new user if not exists
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => Hash::make(uniqid()), // Generate a random password
                'email_verified_at' => now(),
            ]);

            $log['message'] = 'User Created via Google Login';
            $log['user_id'] = $user->id;
            $log['action'] = 'Create User';
            $log['ip_address'] = request()->ip();
            $log['platform'] = Agent::platform() . '-' . Agent::version(Agent::platform());
            $log['agent'] = Agent::browser() . '-' . Agent::version(Agent::browser());

            Logs::create($log);
        }

        // Log the user in
        Auth::login($user, true);

        // Log the sign in action
        $log['message'] = 'User SignedIn via Google Login';
        $log['user_id'] = Auth::user()->id;
        $log['action'] = 'Sign In';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' . Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' . Agent::version(Agent::browser());

        Logs::create($log);

        // Redirect to the dashboard
        return redirect()->route('dashboard');
    }

}
