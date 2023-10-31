<?php

namespace App\Http\Controllers;

// use App;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\User;
use App\Models\Subject;
use App\Models\School;
use App\Models\LessonPlan;
use App\Models\LessonStep;
use App\Models\LessonAnnex;
use Intervention\Image\Facades\Image;
use Jenssegers\Agent\Facades\Agent;
use App\Models\Logs;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Spipu\Html2Pdf\Html2Pdf;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Validator;

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

        $subjects = Subject::all();

        if (auth()->user()->isAdmin()) {
            $yourLPs = 1;
        } else {
            $yourLPs = LessonPlan::all()->where('owner', auth()->user()->id)->count();
        }

        return view('lesson-plan.index', compact('lessonPlans', 'yourLPs', 'subjects'));
    }

    public function getCreate()
    {
        $teacher = User::where('role', 'Teacher')->orderBy('name');
        $facilitator = User::where('role', 'Facilitator')->orderBy('name');
        $teachers = $teacher->union($facilitator)->orderBy('name')->get();

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
            'competency' => 'required',
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
        $log['lesson_plan'] = $lesson->id;
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
        $steps = LessonStep::all()->where('lesson_plan', request()->id)->sortBy('step');
        $duration = LessonStep::all()->where('lesson_plan', request()->id)->sum('duration');
        $annexes = LessonAnnex::all()->where('lesson_plan', request()->id);
        $comments = Comment::all()->where('lesson_plan', request()->id);
        $replies = Reply::all()->where('lesson_plan', request()->id);
        $logs = Logs::all()->where('message', 'Lessonplan with id '.request()->id.' was updated.');
        // $logs = Logs::all()->where('message', 'LIKE', '%Lessonplan with id '.request()->id.' was updated.');

        // return view('lesson-plan.view', compact('lesson', 'subject', 'owner', 'school', 'steps', 'duration', 'annexes', 'comments', 'replies', 'logs'));
        return view('lesson-plan.lp', compact('lesson', 'subject', 'owner', 'school', 'steps', 'duration', 'annexes', 'comments', 'replies', 'logs'));

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
        $log['lesson_plan'] = request()->id;
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
        // request()->validate([
        //     'subject' => 'required',
        //     'lesson_plan_file' => 'required|mimes:xlsx,xls|max:1024'
        // ]);

        // $import = new \App\Imports\Lessonplan\getSheets();

        // Excel::import($import, request()->lesson_plan_file);

        // $log['message'] = 'Lessonplan was uploaded.';
        // $log['user_id'] = Auth()->user()->id;
        // $log['action'] = 'Upload Lessonplan';
        // $log['ip_address'] = request()->ip();
        // $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        // $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        // Logs::create($log);

        // return redirect()
        //     ->route('lesson.plans')
        //     ->with('status', 'The Lesson Plan has been uploaded successfully.');

        request()->validate([
            'teacher' => 'required',
            'subject' => 'required',
            'lesson_plan_file' => 'required|mimetypes:application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ]);

        // Get the uploaded Word file
        $uploadedFile = request()->file('lesson_plan_file');

        // Load the Word document using phpoffice/phpword
        $phpWord = IOFactory::load($uploadedFile);

        // Extract data from the Word document
        $data = [];

        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if (get_class($element) == 'PhpOffice\PhpWord\Element\Table') {
                    $rows = $element->getRows();

                    if (!empty($rows)) {
                        $tableData = [];

                        foreach ($rows as $row) {
                            $cells = $row->getCells();
                            $rowData = [];

                            foreach ($cells as $cell) {
                                $els = $cell->getElements();
                                $cellText = '';

                                foreach ($els as $e) {
                                    if (get_class($e) == 'PhpOffice\PhpWord\Element\TextRun') {
                                        // Handle TextRun elements within the cell
                                        foreach ($e->getElements() as $textElement) {
                                            if (get_class($textElement) == 'PhpOffice\PhpWord\Element\Text') {
                                                $cellText .= $textElement->getText();
                                                // if($textElement->getText() != 'INFO 1' || $textElement->getText() != 'INFO 2' || $textElement->getText() != 'STEPS')
                                                // {
                                                //     $cellText .= $textElement->getText().', ';
                                                // }
                                                // else{
                                                //     $cellText .= $textElement->getText();
                                                // }
                                                // var_dump($cellText);
                                            }
                                        }
                                    }
                                }

                                // Add the cell text to rowData array
                                $rowData[] = $cellText;
                            }

                            // Add the row data to tableData array
                            $tableData[] = $rowData;
                        }

                        // Add the table data to the $data array, with a unique key for each table
                        $data[] = $tableData;
                    }
                }
            }
        }

        $response = [];

        foreach ($data as $contents)
        {
            if ($contents[0][0] == 'INFO 1')
            {
                $info_1_rows = array_slice($contents, 1);
                $col_1 = $info_1_rows[0];
                $col_2 = $info_1_rows[1];
                $col_3 = $info_1_rows[2];

                $info_1['theme'] = $col_1[1];
                $info_1['topic'] = $col_1[3];
                $info_1['class'] = $col_2[1];
                $info_1['term'] = $col_2[3];
                $info_1['male_learners'] = intval($col_3[1]);
                $info_1['female_learners'] = intval($col_3[3]);
            }

            if ($contents[0][0] == 'INFO 2')
            {
                $info_2_rows = array_slice($contents, 1);


                $info_2['competency'] = $info_2_rows[0][1];
                $info_2['learning_outcomes'] = $info_2_rows[1][1];
                $info_2['generic_skills'] = $info_2_rows[2][1];
                $info_2['values'] = $info_2_rows[3][1];
                $info_2['cross_cutting_issues'] = $info_2_rows[4][1];
                $info_2['key_learning_outcomes'] = $info_2_rows[5][1];
                $info_2['pre_requisite_knowledge'] = $info_2_rows[6][1];
                $info_2['learning_materials'] = $info_2_rows[7][1];
                $info_2['learning_methods'] = $info_2_rows[8][1];
                $info_2['references'] = $info_2_rows[9][1];
                $info_2['activity_aim'] = $info_2_rows[10][1];
            }


            if ($contents[0][0] == 'STEPS')
            {
                $steps_rows = array_slice($contents, 2);
                $steps = [];
                for ($ct = 0; $ct < count($steps_rows); $ct++)
                {
                    if ($ct < count($steps_rows))
                    {
                        $steps_data['step'] = $steps_rows[$ct][0];
                        $steps_data['duration'] = $steps_rows[$ct][1];
                        $steps_data['teacher_activity'] = $steps_rows[$ct][2];
                        $steps_data['student_activity'] = $steps_rows[$ct][3];
                        $steps_data['knowledge'] = $steps_rows[$ct][4];
                        $steps_data['skills'] = $steps_rows[$ct][5];
                        $steps_data['values'] = $steps_rows[$ct][6];
                        $steps_data['output'] = $steps_rows[$ct][7];
                        $steps_data['assessment_criteria'] = $steps_rows[$ct][8];
                    }
                    $steps[] = $steps_data;
                }
            }
        }

        $lp_info_array = array_merge($info_1, $info_2);
        $lp_info_array['owner'] = intval(request()->teacher);
        $lp_info_array['subject'] = intval(request()->subject);
        $lp_info_array['learners_no'] = $info_1['male_learners'] + $info_1['female_learners'];

        $lp_rules = [
            'topic' => 'required',
            'subject' => 'required',
            'class' => 'required',
            'learners_no' => 'required',
            'term' => 'required',
            'theme' => 'required',
            'competency' => 'required',
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
        ];

        $validate_lp = Validator::make($lp_info_array, $lp_rules);

        if ($validate_lp->fails()) {
            // Validation failed
            $errors = $validate_lp->errors();
            return back()
                    ->with('error', $errors);
        }

        $school = User::find(request()->teacher);

        $lp_info_array['school'] = intval($school->school);
        $lp_info_array['created_by'] = auth()->user()->id;
        $lesson = LessonPlan::create($lp_info_array);

        if($steps)
        {
            foreach ($steps as $step)
            {
                $step_rules = [
                    'step' => 'required',
                ];

                $validate_step = Validator::make($step, $step_rules);

                if ($validate_step->fails()) {
                    // Validation failed
                    $errors = $validate_step->errors();
                    return redirect()
                        ->back()
                        ->with('error', $errors);
                }

                $step['lesson_plan'] = $lesson->id;
                $step['created_by'] = auth()->user()->id;

                LessonStep::create($step);
            }
        }

        $log['message'] = 'Lessonplan was uploaded and created with id '.$lesson->id;
        $log['user_id'] = Auth()->user()->id;
        $log['lesson_plan'] = $lesson->id;
        $log['action'] = 'Upload Lessonplan';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

        return redirect()
                ->route('get.lesson.plan', $lesson->id)
                ->with('status', 'Lesson plan created successfully.');
        // return response()->json($steps);
    }

    public function deleteLessonPlan()
    {
        $lesson = LessonPlan::find(request()->id);

        if ($lesson->owner !== auth()->user()->id && auth()->user()->type == 'teacher')
        {
            return redirect()
                ->route('get.lesson.plan', request()->lesson_plan)
                ->with('error', 'Unauthorized. Only the owner can delete.');
        }

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
            $log['lesson_plan'] = request()->id;
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
        $user = LessonPlan::find(request()->lesson_plan);

        if ($user->owner !== auth()->user()->id && auth()->user()->type == 'teacher')
        {
            return redirect()
                ->route('get.lesson.plan', request()->lesson_plan)
                ->with('error', 'Unauthorized. Only the owner can add a step.');
        }

        request()->validate([
            'step' => 'required',
        ]);

        LessonStep::create(request()->all());

        $log['message'] = 'Step added for Lessonplan with id '. request()->id;
        $log['user_id'] = Auth()->user()->id;
        $log['lesson_plan'] = request()->id;
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
            ->with('status', 'The lesson plan step has been added successfully');
    }

    public function deleteStep()
    {
        $step = LessonStep::find(request()->id);

        $user = LessonPlan::find($step->lesson_plan);

        if ($user->owner !== auth()->user()->id && auth()->user()->type == 'teacher')
        {
            return redirect()
                ->route('get.lesson.plan', $step->lesson_plan)
                ->with('error', 'Unauthorized. Only the owner can delete.');
        }

        $step->delete();

        $log['message'] = 'Step deleted for Lessonplan with id '. $step->lesson_plan;
        $log['user_id'] = Auth()->user()->id;
        $log['lesson_plan'] = $step->lesson_plan;
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
        $log['lesson_plan'] = request()->lesson_plan;
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
        $user = LessonPlan::find(request()->lesson_plan);

        if ($user->owner !== auth()->user()->id && auth()->user()->type == 'teacher')
        {
            return redirect()
                ->route('get.lesson.plan', request()->lesson_plan)
                ->with('error', 'Unauthorized. Only the owner can add an annex.');
        }

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
        $log['lesson_plan'] = request()->lesson_plan;
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
        $log['lesson_plan'] = $annex->lesson_plan;
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

        $user = LessonPlan::find($annex->lesson_plan);

        if ($user->owner !== auth()->user()->id && auth()->user()->type == 'teacher')
        {
            return redirect()
                ->route('get.lesson.plan', $annex->lesson_plan)
                ->with('error', 'Unauthorized. Only the owner can delete.');
        }

        unlink(public_path('annex/' . $annex->annex_file));

        $annex->delete();

        $log['message'] = 'Annex deleted for Lessonplan with id '. $annex->lesson_plan;
        $log['user_id'] = Auth()->user()->id;
        $log['lesson_plan'] = $annex->lesson_plan;
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
        $user = LessonPlan::find(request()->id);

        if ($user->owner !== auth()->user()->id && auth()->user()->type == 'teacher')
        {
            return redirect()
            ->route('get.lesson.plan', request()->id)
            ->with('error', 'Unauthorized. Lesson Plan is still under review and can only be downloaded when approved');
        }

        $lesson = LessonPlan::find(request()->id);
        $subject = Subject::find($lesson->subject);
        $owner = User::find($lesson->owner);
        $school = School::find($owner->school);
        $steps = LessonStep::all()->where('lesson_plan', request()->id)->sortBy('step');
        $duration = LessonStep::all()->where('lesson_plan', request()->id)->sum('duration');
        $annexes = LessonAnnex::all()->where('lesson_plan', request()->id);

        $html = View::make('components.template.lp', compact('lesson', 'subject', 'owner', 'school', 'steps', 'duration', 'annexes'))->render();
        $html2pdf = new Html2Pdf('L', 'A4','en', true, null, array(10, 5, 5, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($html);
        $html2pdf->output('lesson_plan.pdf', 'D');

        $log['message'] = 'Lessonplan with id '. request()->id . ' downloaded';
        $log['user_id'] = Auth()->user()->id;
        $log['lesson_plan'] = request()->id;
        $log['action'] = 'Downloaded Lesson Plan';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

    }

    public function updateLessonPlanField()
    {
        $user = LessonPlan::find(request()->id);

        if ($user->owner !== auth()->user()->id && auth()->user()->type == 'teacher')
        {
            return response()->json(['error' => 'Unauthorized. Only the owner can edit.'], 403);
        }

        $field = [];
        if(request()->target == 'pleriminary')
        {
            $field[request()->field] = request()->value;

            #Update the lesson plan preliminary info
            LessonPlan::find(request()->id)->update($field);
        }

        if(request()->target == 'step')
        {
            request()->validate([
                'step' => 'required',
            ]);

            #Update the Lesson Plan Step
            LessonStep::find(request()->step)->fill(request()->except('step'))->save();
        }

        if(request()->target == 'annex')
        {
            $annex = LessonAnnex::find(request()->annex);

            $attributes = request()->validate([
                'title' => 'required'
            ]);

            if (request()->hasFile('annex_file')) {
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
        }

        $log_target = request()->target == 'step' ? 'Step ' . request()->step_no . ' for ' :
            (request()->target == 'annex' ? 'Annex- ' . request()->title . ' for ': ucfirst(request()->field).' for ');

        $target = request()->target == 'step' ? 'Step ' . request()->step_no :
                    (request()->target == 'annex' ? 'Annex- ' . request()->title : ucfirst(request()->field));

        $log['lesson_plan'] = request()->id;
        $log['message'] = $log_target . 'Lessonplan with id '. request()->id .' was updated.';
        $log['user_id'] = Auth()->user()->id;
        $log['lesson_plan'] = request()->id;
        $log['action'] = 'Updated Lessonplan '.$target;
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

        return response()->json(['id' => request()->id, 'target' => $log_target]);
    }

    public function successUpdateLessonPlanFields()
    {
        return redirect()
            ->route('get.lesson.plan', request()->id)
            ->with('status', 'The ' . request()->target . ' the lesson plan has been updated successfully');
    }

    public function updateLessonPlanStatus(){
        $lp = LessonPlan::find(request()->id);

        // Check if the record exists
        if (!$lp) {
            return redirect()
                ->route('get.lesson.plan', request()->id)
                ->with('error', 'The lesson plan was not found.');
        }

        // Update the 'status' field to 'submitted'
        $lp->update(['status' => 'submitted']);

        return redirect()
            ->route('get.lesson.plan', request()->id)
            ->with('status', 'The lesson plan has been submitted for review.');
    }

    public function filterLessonPlans(Request $request)
    {
        $class = $request->input('class');
        $subject = $request->input('subject');
        $term = $request->input('term');
        $theme = $request->input('theme');
        $topic = $request->input('topic');
        $learning_outcomes = $request->input('learning_outcomes');
        $status = $request->input('status');

        // Build your query based on the selected filters
        $query = LessonPlan::query();

        if ($class) {
            $query->where('class', $class);
        }

        if ($subject) {
            $query->where('subject', $subject);
        }

        if ($term) {
            $query->where('term', $term);
        }

        if ($theme) {
            $query->where('theme', $theme);
        }

        if ($topic) {
            $query->where('topic', $topic);
        }

        if ($learning_outcomes) {
            $query->where('learning_outcomes', $learning_outcomes);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $lessonPlans = $query->get();

        // Iterate through the results and retrieve the subject name
        foreach ($lessonPlans as $lessonPlan) {
            // Add the subject name to the lessonPlan object
            $subjectId = $lessonPlan->subject;
            $subject = Subject::find($subjectId);
            $lessonPlan->subject = $subject->id ? $subject->name : 'N/A';

            // Add the owner name to the lessonPlan object
            $ownerId = $lessonPlan->owner;
            $owner = User::find($ownerId);
            $lessonPlan->owner = $owner->id ? $owner->name : 'N/A';

            // Add the school name to the lessonPlan object
            $schoolId = $lessonPlan->school;
            $school = School::find($schoolId);
            // $lessonPlan->school = $school->id ? $school->name : 'N/A';
            if ($owner) {
                $lessonPlan->owner = $owner->id ? $owner->name : 'N/A';
            } else {
                $lessonPlan->owner = 'N/A';
            }

            // Get the duration from the steps
            $lessonPlan->duration = LessonStep::where(['lesson_plan' => $lessonPlan->id])->sum('duration');

            $lessonPlan->visibility = $lessonPlan->visibility == 1 ? 'Yes' : 'No';

            // Make the status first letter uppercase
            $lessonPlan->status = ucfirst($lessonPlan->status);
        }

        return response()->json($lessonPlans);
    }

}
