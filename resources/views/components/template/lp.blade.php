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
            .col {
                font-size: 14px;
            }
        </style>
    </head>
    <body>
        <img class="logo" src="{{ asset('assets/img/logos/edflix-logo.png') }}" width="250" height="75" alt="EDFLIX">

        <h1 class="lp-heading">Lesson Plan Details</h1>

        <div class="container">
            <div class="row align-items-start mt-4">
                <div class="col col-md-4">
                    <strong>School: </strong>{{ $school->name }}
                </div>
                <div class="col col-md-4">
                    <strong>Teacher: </strong>{{ $owner->name }}
                </div>
            </div>
            <div class="row align-items-start mt-3">
                <div class="col col-md-4">
                    <strong>Class: </strong>{{ $lesson->class }}
                </div>
                <div class="col col-md-4">
                    <strong>Subject: </strong>{{ $subject->name }}
                </div>
            </div>
            <div class="row align-items-start mt-3">
                <div class="col col-md-4">
                    <strong>Theme: </strong>{{ $lesson->theme }}
                </div>
                <div class="col col-md-4">
                    <strong>Topic: </strong>{{ $lesson->topic }}
                </div>
            </div>
            <div class="row align-items-start mt-3">
                <div class="col col-md-4">
                    <strong>Number of learners: </strong>{{ $lesson->learners_no }}
                </div>
                <div class="col col-md-4">
                    <strong>Duration: </strong>{{ Carbon\CarbonInterval::minutes($duration)->cascade()->forHumans()  ?? '' }}
                </div>
            </div>
        </div>
        <div class="m-4">
            <div class="row align-items-start mt-5">
                <div class="col">
                    <strong>Learning Outcome: </strong>{{ $lesson->learning_outcomes }}
                </div>
            </div>
            <div class="row align-items-start mt-3">
                <div class="col">
                    <strong>Skills: </strong>{{ $lesson->generic_skills }}
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
            <div class="row align-items-start mt-3">
                <div class="col">
                    <strong>References: </strong>{{ $lesson->references }}
                </div>
            </div>
        </div>
    </body>
</html>
@extends('components.template.step', [
    'steps' => $steps,
    'lesson' =>$lesson,
    'subject' =>$subject,
    'school' =>$school,
    'owner' =>$owner,
    'duration' => $duration
])
