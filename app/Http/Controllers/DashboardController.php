<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use App\Models\School;
use App\Models\LessonPlan;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $teachers = User::all()->where('role', 'Teacher');
            $facilitators = User::all()->where('role', 'Facilitator');
            $schools = School::all();

            // an admin
            return view('dashboard.admin', compact('teachers', 'facilitators', 'schools'));

        }else{
            //a teacher
            $teachers = User::all()->where('role', 'Teacher');
            $facilitators = User::all()->where('role', 'Facilitator');
            $schools = School::all();
            $lessonPlans = LessonPlan::all();

            // an admin
            return view('dashboard.teacher', compact('teachers', 'facilitators', 'schools', 'lessonPlans'));
        }
    }
}
