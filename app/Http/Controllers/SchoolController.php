<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;

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

        School::create($attributes);

        return response()->json(['success' => 'The School has been Added Successfully.']);
    }

    public function createSuccess(){
        return redirect()->route('schools')->with('status', 'The School has been Added Successfully.');
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
        $status = School::find(request()->id)->update($attributes);


        return redirect()->route('get.school', request()->id)->with('status', 'The school has been updated successfully.');
    }

    public function deleteSuccess(){
        $status = School::find(request()->id)->delete();

        return redirect()->route('schools')->with('status', 'The school has been deleted successfully.');
    }
}
