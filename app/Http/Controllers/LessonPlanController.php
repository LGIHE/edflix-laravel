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

    public function getCreate(){
        $schools = School::all();
        $subjects = Subject::all();

        return view('lesson-plan.create', compact('schools', 'subjects'));
    }

    public function addPreliminary(){

        $attributes = request()->validate([
            'owner' => 'required',
            'status' => 'required',
            'visibility' => 'required',
            'topic' => 'required',
            'subject' => 'required',
            'class' => 'required',
            'learners_no' => 'required',
            'theme' => 'required',
            'learning_outcomes' => 'required',
            'generic_skills' => 'required',
            'values' => 'required',
            'cross_cutting_issues' => 'required',
            'key_learning_outcomes' => 'required',
            'pre_requisite_knowledge' => 'required',
            'learning_materials' => 'required',
            'learning_methods' => 'required',
            'references' => 'required',
        ]);

        LessonPlan::create($attributes);

        return response()->json(['success' => 'Lesson Plan has been saved.']);
    }
}
