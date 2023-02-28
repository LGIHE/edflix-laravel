<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use App\Models\School;
use App\Models\LessonPlan;

class LessonPlanController extends Controller
{
    public function getAll(){
        $lessonPlans = LessonPlan::all();

        return view('lesson-plan.index', compact('lessonPlans'));
    }
}
