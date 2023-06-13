<?php

namespace App\Imports\Lessonplan;

use App\Models\LessonPlan;
use App\Models\LessonStep;
use DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use App\Rules\requiredInLPUpload;

class Sheet2Import implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     */
    public function collection(Collection $rows)
    {
        Validator::make($rows->toArray(), [
            '*.step' => new requiredInLPUpload('step'),
            '*.duration' => new requiredInLPUpload('duration'),
        ])->validate();

        $lp = LessonPlan::where('owner', auth()->user()->id)->orderBy('created_at', 'desc')->first();

        foreach ($rows as $row) {
            LessonStep::create([
                'step' => $row['step'],
                'duration' => $row['duration'],
                'lesson_plan' => $lp->id,
                'teacher_activity' => $row['teacher_activity'],
                'student_activity' => $row['student_activity'],
                'knowledge' => $row['knowledge'],
                'skills' => $row['skills'],
                'values' => $row['step_values'],
                'output' => $row['output'],
                'assessment_criteria' => $row['assessment_criteria'],
                'facilitator_note' => $row['facilitator_note'],
                'created_by' => auth()->user()->id
            ]);
        }
    }

}
