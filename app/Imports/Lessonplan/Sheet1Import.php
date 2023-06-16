<?php

namespace App\Imports\Lessonplan;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use App\Rules\classIsOneOf;
use App\Rules\requiredInLPUpload;
use App\Rules\learnersNumber;
use App\Models\LessonPlan;

class Sheet1Import implements ToCollection, WithHeadingRow
{

    /**
    * @param array $row
    *
    */
    public function collection(Collection $rows)
    {
        Validator::make($rows->toArray(), [
            '*.theme' => new requiredInLPUpload('theme'),
            '*.topic' => new requiredInLPUpload('topic'),
            '*.class' => [new requiredInLPUpload('class'), new classIsOneOf],
            '*.learners_no' => [new requiredInLPUpload('learners_no'), new learnersNumber],
            '*.competency' => new requiredInLPUpload('competency'),
            '*.learning_outcomes' => new requiredInLPUpload('learning_outcomes'),
            '*.generic_skills' => new requiredInLPUpload('generic_skills'),
            '*.values' => new requiredInLPUpload('values'),
            '*.cross_cutting_issues' => new requiredInLPUpload('cross_cutting_issues'),
            '*.key_learning_outcomes' => new requiredInLPUpload('key_learning_outcomes'),
            '*.learning_materials' => new requiredInLPUpload('learning_materials'),
            '*.learning_methods' => new requiredInLPUpload('learning_methods'),
            '*.references' => new requiredInLPUpload('references'),
        ])->validate();

        $user = request()->teacher != null ? request()->teacher : auth()->user()->id;

        $getUser = User::find($user);

        foreach ($rows as $row) {
            return LessonPlan::create([
                'owner' => $user,
                'status' => 'edit',
                'visibility' => 0,
                'subject' => request()->subject,
                'school' => $getUser->school,
                'theme' => $row['theme'],
                'topic' => $row['topic'],
                'class' => $row['class'],
                'term' => $row['term'],
                'competency' => $row['competency'],
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
                'created_by' => $user,
            ]);
        }
    }

}
