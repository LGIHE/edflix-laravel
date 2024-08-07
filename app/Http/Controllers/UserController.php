<?php

namespace App\Http\Controllers;

use App\Mail\SignupConfirmation;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Subject;
use App\Models\School;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Jenssegers\Agent\Facades\Agent;
use App\Models\Logs;

class UserController extends Controller
{
    public function createUser()
    {

        if (!auth()->user()->isRoleSuperAdmin()){
            return back()->with('error', 'Unauthorized action. Please contact support.');
        }
            $attributes = request()->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'phone' => 'required|numeric|min:10',
                'location' => 'max:255',
                'role' => 'required',
                'password' => 'required|min:5|max:255',
                'school' => 'required|numeric',
                'subject_1' => 'required_if:role,==,Teacher',
                'subject_2' => 'nullable',
                'subject_3' => 'nullable',
            ]);

            $attributes['type'] = $attributes['role'] == 'Teacher' ? 'teacher' : 'admin';
            $attributes['email_verified_at'] = Carbon::now()->toDateTimeString();

            $user = User::create($attributes);

            $user['pass'] = request()->password;
            Mail::to($user->email)->send(new SignupConfirmation($user));

            $log['message'] = 'User with id '. $user->id .' Created';
            $log['user_id'] = Auth()->user()->id;
            $log['action'] = 'Create User';
            $log['ip_address'] = request()->ip();
            $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
            $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

            Logs::create($log);

            return redirect()->route('users')->with('status', 'The user has been added successfully.');

    }

    public function createUserSuccess(){
        return redirect()->route('users')->with('status', 'The user has been added successfully.');
    }

    public function getUsers(){
        $users = User::all();
        $schools = School::all();
        $subjects = Subject::all();

        return view('user.index', compact('users', 'schools', 'subjects'));
    }

    public function getFacilitators(){
        $users = User::all()->where('role', 'Facilitator');
        $schools = School::all();
        $subjects = Subject::all();

        return view('user.facilitators', compact('users', 'schools', 'subjects'));
    }

    public function getTeachers(){
        $users = User::all()->where('role', 'Teacher');
        $schools = School::all();
        $subjects = Subject::all();

        return view('user.teachers', compact('users', 'schools', 'subjects'));
    }

    public function getUser(){
        $user = User::find(request()->id);
        $schools = School::all();
        $subjects = Subject::all();

        return view('user.update', compact('user', 'schools', 'subjects'));
    }

    public static function findUser($id)
    {
        return User::where('id', $id)->first();
    }

    public function updateUser(){

        $user = User::find(request()->id);
        if (!auth()->user()->isRoleSuperAdmin() || $user->id != request()->id){
            return back()->with('error', 'Unauthorized action. Please contact support.');
        }

        $attributes = request()->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|numeric|min:10',
            'location' => 'max:255',
            'role' => 'required',
            // 'password' => 'required|min:5|max:255',
            'school' => 'required|numeric',
            'subject_1' => 'required_if:role,==,Teacher',
            'subject_2' => 'nullable',
            'subject_3' => 'nullable',
        ]);

        #Update the user
        User::find(request()->id)->update($attributes);

        $log['message'] = 'User with id '. request()->id .' Updated';
        $log['user_id'] = Auth()->user()->id;
        $log['action'] = 'Update User';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

        return redirect()->route('get.user', request()->id)->with('status', 'The user has been updated successfully.');

    }

    public function updatePassword() {
        $user = User::find(request()->id);
        if (!auth()->user()->isRoleSuperAdmin() || $user->id != request()->id){
            return back()->with('error', 'Unauthorized action. Please contact support.');
        }

        $attributes = request()->validate([
            'password' => 'required'
        ]);

        #Update the user password
        User::find(request()->id)->update($attributes);

        $log['message'] = 'Update Password for User with id '. request()->id ;
        $log['user_id'] = Auth()->user()->id;
        $log['action'] = 'Update User Password';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

        return response()->json(['id' => request()->id]);
    }

    public function updateUserPasswordSuccess()
    {
        return redirect()
            ->route('get.user', request()->id)
            ->with('status', 'The user password has been updated successfully.');
    }

    public function deleteUser(){
        if (!auth()->user()->isRoleSuperAdmin())
        {
            return back()->with('error', 'Unauthorized action. Please contact support.');
        }

        User::find(request()->id)->delete();

        $log['message'] = 'User with id '. request()->id .' Deleted';
        $log['user_id'] = Auth()->user()->id;
        $log['action'] = 'Delete User';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

        return redirect()->route('users')->with('status', 'The user has been deleted successfully.');
    }

    public function getUploadTeachers()
    {
        return view('user.upload');
    }

    public function uploadTeachers(){
        if (!auth()->user()->isRoleSuperAdmin())
        {
            return back()->with('error', 'Unauthorized action. Please contact support.');
        }

        request()->validate([
            'teacher_upload' => 'required|mimes:xlsx,xls|max:1024'
        ]);

        $import = new \App\Imports\Teachers\getTeacherSheets();

        Excel::import($import, request()->teacher_upload);

        return redirect()
            ->route('users')
            ->with('status', 'The bulk teacher upload is successful.');
    }

}
