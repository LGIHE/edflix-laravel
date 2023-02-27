<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function createUser()
    {
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:5|max:255',
        ]);

        $user = User::create($attributes);

        return redirect('/users');
    }

    public function getUsers(){
        $users = User::all();

        return view('user.users', compact('users'));
    }

    public function getUser(){

        return 1;

    }

    public function getUpdate(){

        return 1;

    }

    public function getDelete(){

        return 1;

    }

}
