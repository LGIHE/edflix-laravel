<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EDFLIX-LP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }

        .col {
            font-size: 14px;
        }

        .page-break {
            page-break-after: always !important;
        }

        @media print {
            @page {
                size: landscape;
                orientation: landscape;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <img class="logo" src="{{ asset('assets/img/logos/EDPLAN.png') }}" width="250" height="75"
        alt="EDFLIX">

    <h1 class="lp-heading">Lesson Plan Details</h1>

    <table class="mt-4" style="border-collapse: collapse; border: none;margin-left:20pt" cellspacing="0" cellpadding="0">
        <tr style="border: none;height: 33pt">
            <td class="column" style="border: none;width:300pt;">
                <p class="s2 column-head"><strong>School: </strong>{{ $school->name }}</p>
            </td>
            <td class="column" style="border: none;width: 300pt;">
                <p class="s2 column-head"><strong>Teacher: </strong>{{ $owner->name }}</p>
            </td>
        </tr>
        <tr style="border: none;height: 33pt">
            <td class="column" style="border: none;width: 300pt;">
                <p class="s2 column-head"><strong>Class: </strong>{{ $lesson->class }}</p>
            </td>
            <td class="column" style="border: none;width: 300pt;">
                <p class="s2 column-head"><strong>Subject: </strong>{{ $subject->name }}</p>
            </td>
        </tr>
        <tr style="border: none;height: 33pt">
            <td class="column" style="border: none;width: 300pt;">
                <p class="s2 column-head"><strong>Theme: </strong>{{ $lesson->theme }}</p>
            </td>
            <td class="column" style="border: none;width: 300pt;">
                <p class="s2 column-head"><strong>Topic: </strong>{{ $lesson->topic }}</p>
            </td>
        </tr>
        <tr style="border: none;height: 33pt">
            <td class="column" style="border: none;width: 300pt;">
                <p class="s2 column-head">
                    <strong>Number of learners: </strong>
                {{ $lesson->learners_no }}
                (<strong>Female: </strong>{{ $lesson->female_learners }} <strong>Male: </strong>{{ $lesson->male_learners }})
                </p>
            </td>
            <td class="column" style="border: none;width: 300pt;">
                <p class="s2 column-head">
                    <strong>Duration:
                    </strong>{{ Carbon\CarbonInterval::minutes($duration)->cascade()->forHumans() ?? '' }}
                </p>
            </td>
        </tr>
        <tr style="border: none;height: 33pt">
            <td class="column" style="border: none;width: 300pt;">
                <p class="s2 column-head">
                    <strong>Term: </strong>{{ $lesson->term }}
                </p>
            </td>
        </tr>
    </table>
    <div class="m-4">
        <div class="row align-items-start mt-5">
            <div class="col">
                <strong>Competency: </strong>{{ $lesson->competency }}
            </div>
        </div>
        <div class="row align-items-start mt-3">
            <div class="col">
                <strong>Learning Outcome: </strong>{{ $lesson->learning_outcomes }}
            </div>
        </div>
        <div class="row align-items-start mt-3">
            <div class="col">
                <strong>Generic Skills: </strong>{{ $lesson->generic_skills }}
            </div>
        </div>
        <div class="row align-items-start mt-3">
            <div class="col">
                <strong>Values: </strong>{{ $lesson->values }}
            </div>
        </div>
        <div class="row align-items-start mt-3">
            <div class="col">
                <strong>Cross-cutting Issues: </strong>{{ $lesson->cross_cutting_issues }}
            </div>
        </div>
        <div class="row align-items-start mt-3">
            <div class="col">
                <strong>Key learning outcomes: </strong>{{ $lesson->key_learning_outcomes }}
            </div>
        </div>
        <div class="row align-items-start mt-3">
            <div class="col">
                <strong>Pre-Requisiste Knowledge: </strong>{{ $lesson->pre_requisite_knowledge }}
            </div>
        </div>
        <div class="row align-items-start mt-3">
            <div class="col">
                <strong>Learning Materials: </strong>{{ $lesson->learning_materials }}
            </div>
        </div>
        <div class="row align-items-start mt-3">
            <div class="col">
                <strong>Learning Methods: </strong>{{ $lesson->learning_methods }}
            </div>
        </div>
        <div class="row align-items-start mt-3 ">
            <div class="col">
                <strong>References: </strong>{{ $lesson->references }}
            </div>
        </div>
    </div>

    {{-- START OF STEPS --}}
    <div class="m-4 page-break">
        <table class="mt-4" style="border-collapse: collapse; border: none;margin-left:20pt" cellspacing="0" cellpadding="0">
            <tr style="border: none;height: 33pt">
                <td class="column" style="border: none;width:300pt;">
                    <img class="logo" src="{{ asset('assets') }}/img/logos/EDPLAN.png" width="250" height="75"
                    alt="EDFLIX">
                </td>
                <td class="column" style="border: none;width: 300pt;">
                    <div class="row align-items-start">
                        <div class="col">
                            <strong>School: </strong>{{ $school->name }}
                        </div>
                    </div>
                    <div class="row align-items-start">
                        <div class="col">
                            <strong>Class: </strong>{{ $lesson->class }}
                        </div>
                    </div>
                    <div class="row align-items-start">
                        <div class="col">
                            <strong>Theme: </strong>{{ $lesson->theme }}
                        </div>
                    </div>
                    <div class="row align-items-start">
                        <div class="col">
                            <strong>Number of learners: </strong>{{ $lesson->learners_no }}
                        </div>
                    </div>
                </td>
                <td class="column" style="border: none;width: 300pt;">
                    <div class="row align-items-start">
                        <div class="col">
                            <strong>Teacher: </strong>{{ $owner->name }}
                        </div>
                    </div>
                    <div class="row align-items-start">
                        <div class="col">
                            <strong>Subject: </strong>{{ $subject->name }}
                        </div>
                    </div>
                    <div class="row align-items-start">
                        <div class="col">
                            <strong>Topic: </strong>{{ $lesson->topic }}
                        </div>
                    </div>
                    <div class="row align-items-start">
                        <div class="col">
                            <strong>Duration:
                            </strong>{{ Carbon\CarbonInterval::minutes($duration)->cascade()->forHumans() ?? '' }}
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <div class="row align-items-start m-4">
            <div class="col">
                <strong>Activity Aim:</strong> {{ $lesson->activity_aim }}
            </div>
        </div>

        <h2 class="lp-heading mt-3" style="font-family: Arial, Helvetica, sans-serif;">Steps</h2>

        <table class="mt-4" style="border-collapse: collapse; margin-left:20pt" cellspacing="0">
            <tr style="height: 33pt">
                <td class="column" style="width:75pt;">
                    <p class="s2 column-head">Duration of activity</p>
                </td>
                <td class="column" style="width: 150pt;">
                    <p class="s2 column-head">Teacher’s activity</p>
                </td>
                <td class="column" style="width: 113pt;">
                    <p class="s2 column-head">Students’ activity</p>
                </td>
                <td class="column" style="width: 111pt;">
                    <p class="s2 column-head">Knowledge, value and skills</p>
                </td>
                <td class="column" style="width: 149pt;">
                    <p class="s2 column-head">Output:</p>
                </td>
                <td class="column" style="width: 149pt;">
                    <p class="s2 column-head">Assessment criteria</p>
                </td>
            </tr>
            @foreach ($steps as $step)
            <tr style="height: 33pt">
                <td class="column" style="width:75pt;">
                    <p class="s2 column-head">Step
                        {{ $step->step }}<br>{{ Carbon\CarbonInterval::minutes($step->duration)->cascade()->forHumans() ?? '' }}
                    </p>
                </td>
                <td class="column" style="width: 150pt;">
                    <p class="s2 column-head">{{ $step->teacher_activity }}</p>
                </td>
                <td class="column" style="width: 113pt;">
                    <p class="s2 column-head">{{ $step->student_activity }}</p>
                </td>
                <td class="column" style="width: 111pt;">
                    <p class="s2 column-head">
                        <strong>Knowledge: </strong>{{ $step->knowledge }}<br>
                        <strong>Values: </strong>{{ $step->values }}<br>
                        <strong>Skills: </strong>{{ $step->skills }}
                    </p>
                </td>
                <td class="column" style="width: 149pt;">
                    <p class="s2 column-head">{{ $step->output }}</p>
                </td>
                <td class="column" style="width: 149pt;">
                    <p class="s2 column-head">{{ $step->assessment_criteria }}</p>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</body>

</html>

@extends('components.template.annex', [
    'annexes' => $annexes,
    'lesson' => $lesson,
    'subject' => $subject,
    'school' => $school,
    'owner' => $owner,
    'duration' => $duration,
])

{{-- @extends('components.template.step', [
    'steps' => $steps,
    'lesson' => $lesson,
    'subject' => $subject,
    'school' => $school,
    'owner' => $owner,
    'duration' => $duration,
    'activity' => $lesson->activity_aim
]) --}}
