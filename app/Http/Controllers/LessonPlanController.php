<?php

namespace App\Http\Controllers;

// use App;
use App\Models\User;
use App\Models\Subject;
use App\Models\School;
use App\Models\LessonPlan;
use App\Models\LessonStep;
use App\Models\LessonAnnex;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Jenssegers\Agent\Facades\Agent;
use App\Models\Logs;

use Barryvdh\DomPDF\Facade\Pdf as Pdfmod;

class LessonPlanController extends Controller
{
    public function getAll()
    {

        $lessonPlans = LessonPlan::join('subjects', 'lesson_plans.subject', '=', 'subjects.id')
            ->join('users', 'lesson_plans.owner', '=', 'users.id')
            ->join('schools', 'lesson_plans.school', '=', 'schools.id')
            ->select('lesson_plans.*', 'subjects.name as subjectName', 'users.name as ownerName', 'schools.name as schoolName')
            ->orderBy('lesson_plans.created_at', 'asc')
            ->get();

        if (auth()->user()->isAdmin()) {
            $yourLPs = 1;
        } else {
            $yourLPs = LessonPlan::all()->where('owner', auth()->user()->id)->count();
        }

        return view('lesson-plan.index', compact('lessonPlans', 'yourLPs'));
    }

    public function getCreate()
    {
        $teachers = User::all()->where('role', 'Teacher')->sortBy('name');
        $schools = School::all();
        $subjects = Subject::all();

        return view('lesson-plan.create', compact('schools', 'subjects', 'teachers'));
    }

    public function createLessonPlan()
    {

        $attributes = request()->validate([
            'owner' => 'required',
            'topic' => 'required',
            'subject' => 'required',
            'class' => 'required',
            'learners_no' => 'required',
            'term' => 'required',
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
            'activity_aim' => 'required',
        ]);

        $school = User::find($attributes['owner']);

        $attributes['school'] = $school->school;
        $attributes['female_learners'] = request()->female_learners;
        $attributes['male_learners'] = request()->male_learners;
        $attributes['created_by'] = request()->created_by;
        $lesson = LessonPlan::create($attributes);

        $log['message'] = 'Lessonplan with id '. $lesson->id .' was created.';
        $log['user_id'] = Auth()->user()->id;
        $log['action'] = 'Create Lessonplan';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

        return response()->json(['id' => $lesson->id]);
    }

    public function successCreate()
    {
        return redirect()
            ->route('get.lesson.plan', request()->id)
            ->with('status', 'The Lesson Plan preliminary information has been added. You can now add the steps.');
    }

    public function getLessonPlan()
    {
        $lesson = LessonPlan::find(request()->id);
        $subject = Subject::find($lesson->subject);
        $owner = User::find($lesson->owner);
        $school = School::find($owner->school);
        $steps = LessonStep::all()->where('lesson_plan', request()->id);
        $duration = LessonStep::all()->where('lesson_plan', request()->id)->sum('duration');
        $annexes = LessonAnnex::all()->where('lesson_plan', request()->id);

        return view('lesson-plan.view', compact('lesson', 'subject', 'owner', 'school', 'steps', 'duration', 'annexes'));

    }

    public function getLessonPlanUpdate()
    {
        $lesson = LessonPlan::find(request()->id);

        if (auth()->user()->isAdmin() || auth()->user()->id == $lesson->owner) {

            $subjects = Subject::all();
            $owner = User::find($lesson->owner);
            $school = School::find($owner->school);
            $teachers = User::all()->where('role', 'Teacher');
            return view('lesson-plan.update', compact('lesson', 'subjects', 'owner', 'school', 'teachers'));

        } else {
            return back()->with('error', 'Action not Authorized. Please contact asministrator.');
        }
    }

    public function updateLessonPlan()
    {

        $attributes = request()->validate([
            'owner' => 'required',
            'status' => 'required',
            'visibility' => 'required',
            'topic' => 'required',
            'subject' => 'required',
            'class' => 'required',
            'learners_no' => 'required',
            'term' => 'required',
            'competency' => 'required',
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
            'activity_aim' => 'required',
        ]);

        $school = User::find($attributes['owner']);

        $attributes['school'] = $school->school;
        $attributes['female_learners'] = request()->female_learners;
        $attributes['male_learners'] = request()->male_learners;
        $attributes['updated_by'] = request()->updated_by;

        #Update the lesson plan preliminary info
        LessonPlan::find(request()->id)->update($attributes);

        $log['message'] = 'Lessonplan with id '. request()->id .' was updated.';
        $log['user_id'] = Auth()->user()->id;
        $log['action'] = 'Updated Lessonplan';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

        return redirect()->route('get.lesson.plan', request()->id)->with('status', 'The lesson plan has been updated successfully.');
    }

    public function getUploadLessonPlan()
    {
        $subjects = Subject::all();
        $teachers = User::all()->where('role', 'Teacher')->sortBy('name');

        return view('lesson-plan.upload', compact('subjects', 'teachers'));
    }

    public function uploadLessonPlan()
    {
        request()->validate([
            'subject' => 'required',
            'lesson_plan_file' => 'required|mimes:xlsx,xls|max:1024'
        ]);

        $import = new \App\Imports\Lessonplan\getSheets();

        Excel::import($import, request()->lesson_plan_file);

        $log['message'] = 'Lessonplan was uploaded.';
        $log['user_id'] = Auth()->user()->id;
        $log['action'] = 'Upload Lessonplan';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

        return redirect()
            ->route('lesson.plans')
            ->with('status', 'The Lesson Plan has been uploaded successfully.');
    }

    public function deleteLessonPlan()
    {
        $lesson = LessonPlan::find(request()->id);

        if (auth()->user()->isAdmin() || auth()->user()->id == $lesson->owner) {

            $lesson->delete();
            $steps = LessonStep::where('lesson_plan', request()->id);
            $steps->delete();

            $annexes = LessonAnnex::where('lesson_plan', request()->id);

            if ($annexes) {
                foreach ($annexes as $annex) {
                    unlink(storage_path() . '/app/public/annex-uploads/' . $annex->annex_file);
                    LessonAnnex::find($annex->id)->delete();
                }
            }

            $log['message'] = 'Lessonplan with id '. request()->id .' was deleted.';
            $log['user_id'] = Auth()->user()->id;
            $log['action'] = 'Delete Lessonplan';
            $log['ip_address'] = request()->ip();
            $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
            $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

            Logs::create($log);

            return redirect()->route('lesson.plans')->with('status', 'The lesson plan has been deleted successfully.');

        } else {

            return back()->with('error', 'Action not Authorized. Please contact asministrator.');
        }
    }


    public function AddStep()
    {
        request()->validate([
            'step' => 'required',
        ]);

        LessonStep::create(request()->all());

        $log['message'] = 'Step added for Lessonplan with id '. request()->id;
        $log['user_id'] = Auth()->user()->id;
        $log['action'] = 'Add Step';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

        return response()->json(['id' => request()->lesson_plan]);
    }

    public function successAddStep()
    {
        return redirect()
            ->route('get.lesson.plan', request()->id)
            ->with('status', 'The lesson plan step has been uploaded successfully');
    }

    public function deleteStep()
    {
        $step = LessonStep::find(request()->id);
        $step->delete();

        $log['message'] = 'Step deleted for Lessonplan with id '. $step->lesson_plan;
        $log['user_id'] = Auth()->user()->id;
        $log['action'] = 'Delete Step';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

        return redirect()
            ->route('get.lesson.plan', $step->lesson_plan)
            ->with('status', 'The lesson plan step has been deleted successfully');
    }

    public function updateStep()
    {
        request()->validate([
            'step' => 'required',
        ]);

        #Update the Lesson Plan Step
        LessonStep::find(request()->id)->update(request()->all());

        $log['message'] = 'Step updated for Lessonplan with id '. request()->lesson_plan;
        $log['user_id'] = Auth()->user()->id;
        $log['action'] = 'Update Step';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

        return response()->json(['id' => request()->lesson_plan]);

    }

    public function successUpdateStep()
    {
        return redirect()
            ->route('get.lesson.plan', request()->id)
            ->with('status', 'The lesson plan annex has been updated successfully');
    }

    public function addAnnex()
    {

        $attributes = request()->validate([
            'title' => 'required',
            'annex_file' => 'required|file|mimes:png,jpeg,jpg,doc,docx,pdf|max:5120'
        ]);

        $file = request()->file('annex_file');
        $mimeType = $file->getMimeType();
        $file_name = time() . '.' . $file->getClientOriginalExtension();

        if (strpos($mimeType, 'image/') === 0) {
            $img = Image::make($file->getRealPath())->resize(800, 600);
            $img->save(public_path('annex/' . $file_name));
        } else {
            $file->storeAs(public_path('annex/'), $file_name);
        }

        $attributes['annex_file'] = $file_name;
        $attributes['lesson_plan'] = request()->lesson_plan;
        $attributes['created_by'] = auth()->user()->id;

        #Add Annex
        LessonAnnex::create($attributes);

        $log['message'] = 'Annex added for Lessonplan with id '. request()->lesson_plan;
        $log['user_id'] = Auth()->user()->id;
        $log['action'] = 'Add Annex';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

        return response()->json(['id' => request()->lesson_plan]);

    }

    public function successAddAnnex()
    {
        return redirect()
            ->route('get.lesson.plan', request()->id)
            ->with('status', 'The lesson plan annex has been uploaded successfully');
    }

    public function updateAnnex()
    {
        $annex = LessonAnnex::find(request()->id);

        $attributes = request()->validate([
            'title' => 'required'
        ]);

        if (request()->annex_file) {
            request()->validate([
                'annex_file' => 'required|mimes:jpg,png,jpeg|max:5120'
            ]);

            unlink(public_path('annex/' . $annex->annex_file));

            $file = request()->file('annex_file');
            $mimeType = $file->getMimeType();
            $file_name = time() . '.' . $file->getClientOriginalExtension();

            if (strpos($mimeType, 'image/') === 0) {
                $img = Image::make($file->getRealPath())->resize(800, 600);
                $img->save(public_path('annex/' . $file_name));
            } else {
                $file->storeAs(public_path('annex/'), $file_name);
            }

            $attributes['annex_file'] = $file_name;
        }

        $attributes['updated_by'] = auth()->user()->id;

        #Update the Lesson Plan Annex
        $annex->update($attributes);

        $log['message'] = 'Annex updated for Lessonplan with id '. $annex->lesson_plan;
        $log['user_id'] = Auth()->user()->id;
        $log['action'] = 'Update Annex';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

        return response()->json(['id' => $annex->lesson_plan]);

    }

    public function successUpdateAnnex()
    {
        return redirect()
            ->route('get.lesson.plan', request()->id)
            ->with('status', 'The lesson plan annex has been updated successfully');
    }

    public function deleteAnnex()
    {
        $annex = LessonAnnex::find(request()->id);

        unlink(public_path('annex/' . $annex->annex_file));

        $annex->delete();

        $log['message'] = 'Annex deleted for Lessonplan with id '. $annex->lesson_plan;
        $log['user_id'] = Auth()->user()->id;
        $log['action'] = 'Delete Annex';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

        return redirect()
            ->route('get.lesson.plan', $annex->lesson_plan)
            ->with('status', 'The lesson plan annex has been deleted successfully');
    }

    public function downloadLessonPlan()
    {
        $lesson = LessonPlan::find(request()->id);
        $subject = Subject::find($lesson->subject);
        $owner = User::find($lesson->owner);
        $school = School::find($owner->school);
        $steps = LessonStep::all()->where('lesson_plan', request()->id);
        $duration = LessonStep::all()->where('lesson_plan', request()->id)->sum('duration');
        $annexes = LessonAnnex::all()->where('lesson_plan', request()->id);

        $data['lesson'] = $lesson;
        $data['subject'] = $subject;
        $data['owner'] = $owner;
        $data['school'] = $school;
        $data['steps'] = $steps;
        $data['duration'] = $duration;
        $data['annexes'] = $annexes;

        // $pdf = Pdfmod::loadView('components.template.lp', $data);
        // $pdf->setPaper('a4', 'landscape')->setWarnings(false);

        // return $pdf->download('invoice.pdf');

        $log['message'] = 'Lessonplan with id '. request()->id . ' downloaded';
        $log['user_id'] = Auth()->user()->id;
        $log['action'] = 'Download Annex';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

        return view('components.template.lp',compact('lesson', 'subject', 'owner', 'school', 'steps', 'duration', 'annexes'))->render();

    }

}
