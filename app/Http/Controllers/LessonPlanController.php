<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\User;
use App\Models\Subject;
use App\Models\School;
use App\Models\LessonPlan;
use App\Models\LessonAnnex;
use App\Imports\LessonPlanImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class LessonPlanController extends Controller
{
    public function getAll(){

        $lessonPlans = LessonPlan::join('subjects', 'lesson_plans.subject', '=', 'subjects.id')
                            ->join('users', 'lesson_plans.owner', '=', 'users.id')
                            ->join('schools', 'lesson_plans.school', '=', 'schools.id')
                            ->select('lesson_plans.*', 'subjects.name as subjectName', 'users.name as ownerName', 'schools.name as schoolName')
                            ->orderBy('lesson_plans.created_at', 'asc')
                            ->get();

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

        $school = User::find($attributes['owner']);

        $attributes['school'] = $school->school;
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
        $annexes = LessonAnnex::all()->where('lesson_plan', request()->id);

        return view('lesson-plan.lesson', compact('lesson', 'subject', 'owner', 'school', 'annexes'));

    }

    public function AddStep(){
        return true;
    }

    public function getStep(){
        return true;
    }

    public function getLessonPlanUpdate(){
        $lesson = LessonPlan::find(request()->id);

        if(auth()->user()->isAdmin() || auth()->user()->id == $lesson->owner){

            $subjects = Subject::all();
            $owner = User::find($lesson->owner);
            $school = School::find($owner->school);
            $teachers = User::all()->where('role', 'Teacher');
            return view('lesson-plan.update', compact('lesson', 'subjects', 'owner', 'school', 'teachers'));

        }else{
            return back()->with('error', 'Action not Authorized. Please contact asministrator.');
        }
    }

    public function updateLessonPlan(){

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

        $school = User::find($attributes['owner']);

        $attributes['school'] = $school->school;
        $attributes['updated_by'] = request()->updated_by;

        #Update the lesson plan preliminary info
        $status = LessonPlan::find(request()->id)->update($attributes);


        return redirect()->route('get.lesson.plan', request()->id)->with('status', 'The lesson plan has been updated successfully.');
    }

    public function getUploadLessonPlan(){
        $subjects = Subject::all();

        return view('lesson-plan.upload', compact('subjects'));
    }

    public function uploadLessonPlan(){

        $file = request()->validate([
            'subject' => 'required',
            'lesson_plan_file' => 'required|mimes:xlsx,xls|max:1024'
        ]);

        Excel::import(new LessonPlanImport, request()->lesson_plan_file);

        return redirect()
            ->route('lesson.plans')
            ->with('status', 'The Lesson Plan has been uploaded successfully.');
    }

    public function deleteSuccess(){
        $lesson = LessonPlan::find(request()->id);

        if(auth()->user()->isAdmin || auth()->user()->id == $lesson->owner){

            $status = LessonPlan::find(request()->id)->delete();

            return redirect()->route('lesson.plans')->with('status', 'The lesson plan has been deleted successfully.');

        }else{

            return back()->with('error', 'Action not Authorized. Please contact asministrator.');
        }
    }

    public function addAnnex(){

        $attributes = request()->validate([
            'title' => 'required',
            'annex_file' => 'required|mimes:png,jpeg,jpg|max:1024'
        ]);

        $file_name = request()->file('annex_file')->store('annex-uploads', 'public');
        $attributes['annex_file'] = explode('/', $file_name)[1];
        $attributes['lesson_plan'] = request()->lesson_plan;
        $attributes['created_by'] = auth()->user()->id;

        #Update the School
        $status = LessonAnnex::create($attributes);

        return response()->json(['id' => request()->lesson_plan]);

    }

    public function successAddAnnex(){
        return redirect()
            ->route('get.lesson.plan', request()->id)
            ->with('status', 'The lesson plan annex has been uploaded successfully');
    }

    public function updateAnnex(){

        $attributes = request()->validate([
            'title' => 'required',
            'annex_file' => 'required|mimes:jpg,png,jpeg|max:1024'
        ]);

        // $attributes['annex_file'] = request()->file('annex_file')->store('image', 'public');

        $imageName = time().'.'.request()->annex_file->extension();
        request()->annex_file->move(public_path('uploads'), $imageName);

        $attributes['annex_file'] = $imageName;
        $attributes['lesson_plan'] = request()->lesson_plan;
        $attributes['created_by'] = auth()->user()->id;

        #Update the School
        $status = LessonAnnex::find(request()->annex)->update($attributes);


        return response()->json(['id' => request()->lesson_plan]);

    }

}
