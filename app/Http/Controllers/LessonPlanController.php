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
        $teachers = User::all()->where('role', 'Teacher');
        $schools = School::all();
        $subjects = Subject::all();

        return view('lesson-plan.create', compact('schools', 'subjects', 'teachers'));
    }

    public function createLessonPlan(){

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

        $attributes['created_by'] = request()->created_by;
        $lesson = LessonPlan::create($attributes);

        return response()->json(['id' => $lesson->id]);
    }

    public function successCreate(){
        return redirect()
            ->route('get.lesson.plan', request()->id)
            ->with('status', 'The Lesson Plan preliminary information has been added. You can now add the steps.');
    }

    public function getLessonPlan(){
        $lesson = LessonPlan::find(request()->id);
        $subject = Subject::find($lesson->subject);
        $owner = User::find($lesson->owner);
        $school = School::find($owner->school);

        return view('lesson-plan.lesson', compact('lesson', 'subject', 'owner', 'school'));

    }

    public function AddStep(){
        return true;
    }

    public function getStep(){
        return true;
    }

}
