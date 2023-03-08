<?php

namespace App\Imports;

use App\Models\LessonPlan;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

class LessonPlanImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
         Validator::make($rows->toArray(), [
             '*.theme' => 'required|max:255',
             '*.topic' => 'required|max:255',
             '*.class' => 'required',
             '*.learners_no' => 'required|numeric',
             '*.learning_outcomes' => 'required|max:255',
             '*.generic_skills' => 'required|max:255',
             '*.values' => 'required|max:255',
             '*.cross_cutting_issues' => 'required|max:255',
             '*.key_learning_outcomes' => 'required|max:255',
             '*.learning_materials' => 'required|max:255',
             '*.learning_methods' => 'required|max:255',
             '*.references' => 'required|max:255',
         ])->validate();

        foreach ($rows as $row) {
            LessonPlan::create([
                'owner' => auth()->user()->id,
                'status' => 'edit',
                'visibility' => 0,
                'subject' => request()->subject,
                'school' => auth()->user()->school,
                'theme' => $row['theme'],
                'topic' => $row['topic'],
                'class' => $row['class'],
                'learners_no' => $row['learners_no'],
                'learning_outcomes' => $row['learning_outcomes'],
                'generic_skills' => $row['generic_skills'],
                'values' => $row['values'],
                'cross_cutting_issues' => $row['cross_cutting_issues'],
                'key_learning_outcomes' => $row['key_learning_outcomes'],
                'pre_requisite_knowledge' => $row['pre_requisite_knowledge'],
                'learning_materials' => $row['learning_materials'],
                'learning_methods' => $row['learning_methods'],
                'references' => $row['references'],
                'created_by' => auth()->user()->id,
            ]);
        }
    }

}
