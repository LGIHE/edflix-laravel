<?php

namespace App\Imports;

use DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use App\Rules\classIsOneOf;
use App\Rules\requiredInLPUpload;
use App\Rules\learnersNumber;

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
             '*.theme' => new requiredInLPUpload('theme'),
             '*.topic' => new requiredInLPUpload('topic'),
             '*.class' => [new requiredInLPUpload('class'), new classIsOneOf],
             '*.learners_no' => [new requiredInLPUpload('learners_no'), new learnersNumber],
             '*.learning_outcomes' => new requiredInLPUpload('learning_outcomes'),
             '*.generic_skills' => new requiredInLPUpload('generic_skills'),
             '*.values' => new requiredInLPUpload('values'),
             '*.cross_cutting_issues' => new requiredInLPUpload('cross_cutting_issues'),
             '*.key_learning_outcomes' => new requiredInLPUpload('key_learning_outcomes'),
             '*.learning_materials' => new requiredInLPUpload('learning_materials'),
             '*.learning_methods' => new requiredInLPUpload('learning_methods'),
             '*.references' => new requiredInLPUpload('references'),
         ])->validate();

        foreach ($rows as $row) {
            $id = DB::table('lesson_plans')->insertGetId([
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
