<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Jenssegers\Agent\Facades\Agent;
use App\Models\Logs;

class SubjectController extends Controller
{

    public function getAll(){
        $subjects = Subject::all();

        return view('subject.index', compact('subjects'));
    }

    public function getOne(){
        $subject = Subject::find(request()->id);

        return view('subject.update', compact('subject'));
    }

    public function createSubject()
    {
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'code' => 'max:255',
            'short' => 'max:255',
            'description' => 'max:255',
            'level' => 'max:255',
        ]);

        $subject = Subject::create($attributes);

        $log['message'] = 'Subject with id '. $subject->id .' was added';
        $log['user_id'] = Auth()->user()->id;
        $log['action'] = 'Add Subject';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

        return response()->json(['success' => 'The subject has been added successfully.']);
    }

    public function createSuccess(){
        return redirect()->route('subjects')->with('status', 'The subject has been added successfully.');
    }

    public function updateSubject(){

        $attributes = request()->validate([
            'name' => 'required|max:255',
            'code' => 'max:255',
            'short' => 'max:255',
            'description' => 'max:255',
            'level' => 'max:255',
        ]);

        #Update the Subject
        Subject::find(request()->id)->update($attributes);

        $log['message'] = 'Subject with id '. request()->id .' was updated';
        $log['user_id'] = Auth()->user()->id;
        $log['action'] = 'Update Subject';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

        return redirect()->route('get.subject', request()->id)->with('status', 'The subject has been updated successfully.');
    }

    public function deleteSuccess(){
        Subject::find(request()->id)->delete();

        $log['message'] = 'Subject with id '. request()->id .' was deleted';
        $log['user_id'] = Auth()->user()->id;
        $log['action'] = 'Delete Subject';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

        return redirect()->route('subjects')->with('status', 'The subject has been deleted successfully.');
    }
}
