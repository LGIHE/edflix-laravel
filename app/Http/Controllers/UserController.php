<?php

namespace App\Http\Controllers;

use Hash;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use App\Models\School;

class UserController extends Controller
{
    public function createUser()
    {
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


        $attributes['email_verified_at'] = Carbon::now()->toDateTimeString();

        // return response()->json($attributes);

        $user = User::create($attributes);

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

    public function getUser(){
        $user = User::find(request()->id);
        $schools = School::all();
        $subjects = Subject::all();

        return view('user.update', compact('user', 'schools', 'subjects'));
    }

    public function updateUser(){

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

        #Update the School
        $status = User::find(request()->id)->update($attributes);


        return redirect()->route('get.user', request()->id)->with('status', 'The user has been updated successfully.');

    }

    public function getDelete(){

        return 1;

    }

}
