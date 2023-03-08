<?php

namespace App\Imports;

use App\Models\LessonPlan;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LessonPlanImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new LessonPlan([
            'owner' => auth()->user()->id,
            'status' => 'edit',
            'visibility' => 0,
            'subject' => 4,
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
