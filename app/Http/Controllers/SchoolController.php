<?php

namespace App\Http\Controllers;

use App\Models\School;
use Jenssegers\Agent\Facades\Agent;
use App\Models\Logs;

class SchoolController extends Controller
{

    public function getAll(){
        $schools = School::all();

        return view('school.index', compact('schools'));
    }

    public function getOne(){
        $school = School::find(request()->id);

        return view('school.update', compact('school'));
    }

    public function createSchool()
    {
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'email' => 'email|nullable|max:255',
            'address' => 'max:255',
            'city' => 'max:255',
            'district' => 'required|max:255',
        ]);

        $school = School::create($attributes);

        $log['message'] = 'School with id '. $school->id .' was added';
        $log['user_id'] = Auth()->user()->id;
        $log['action'] = 'Add School';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

        return response()->json(['success' => 'The school has been added successfully.']);
    }

    public function createSuccess(){
        return redirect()->route('schools')->with('status', 'The school has been added successfully.');
    }

    public function updateSchool(){

        $attributes = request()->validate([
            'name' => 'required|max:255',
            'email' => 'email|max:255|nullable',
            'address' => 'max:255',
            'city' => 'max:255',
            'district' => 'required|max:255',
        ]);

        #Update the School
        School::find(request()->id)->update($attributes);

        $log['message'] = 'School with id '. request()->id .' was updated';
        $log['user_id'] = Auth()->user()->id;
        $log['action'] = 'Update School';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

        return redirect()->route('get.school', request()->id)->with('status', 'The school has been updated successfully.');
    }

    public function deleteSuccess(){
        School::find(request()->id)->delete();

        $log['message'] = 'School with id '. request()->id .' was deleted';
        $log['user_id'] = Auth()->user()->id;
        $log['action'] = 'Delete School';
        $log['ip_address'] = request()->ip();
        $log['platform'] = Agent::platform() . '-' .Agent::version(Agent::platform());
        $log['agent'] = Agent::browser() . '-' .Agent::version(Agent::browser());

        Logs::create($log);

        return redirect()->route('schools')->with('status', 'The school has been deleted successfully.');
    }
}
