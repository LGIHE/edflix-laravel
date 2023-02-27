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

    public function createSchool()
    {
        $attributes = request()->validate([
            'name' => 'required|max:255',
            // 'email' => 'email|max:255',
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
}
