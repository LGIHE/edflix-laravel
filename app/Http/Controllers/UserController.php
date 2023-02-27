<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function createUser()
    {
        return 1;
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
