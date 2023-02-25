<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            // an admin
            return view('dashboard.admin');
        } elseif (auth()->user()->isAdmin()) {
            // a facilitator
            return view('dashboard.admin');
        }else{
            //a teacher
            // return view('dashboard.index');
        }
        return auth()->user()->isAdmin() == 'admin' ? redirect('/dashboard/admin') : redirect('/dashboard/admin');
    }
}
