<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

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

        Subject::create($attributes);

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
        $status = Subject::find(request()->id)->update($attributes);


        return redirect()->route('get.subject', request()->id)->with('status', 'The subject has been updated successfully.');
    }

    public function deleteSuccess(){
        $status = Subject::find(request()->id)->delete();

        return redirect()->route('subjects')->with('status', 'The subject has been deleted successfully.');
    }
}
