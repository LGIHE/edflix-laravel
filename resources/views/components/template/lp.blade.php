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

@extends('components.template.step', [
    'steps' => $steps,
    'lesson' => $lesson,
    'subject' => $subject,
    'school' => $school,
    'owner' => $owner,
    'duration' => $duration,
    'activity' => $lesson->activity_aim
])
