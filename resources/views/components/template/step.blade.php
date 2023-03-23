<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ asset('assets') }}/css/style.css">
    </head>
    <body>
        @foreach ($steps as $step)
        <div class="row align-items-start">
            <div class="col col-md-4">
                <img class="logo" src="{{ asset('assets') }}/img/logos/edflix-logo.png" width="250" height="75" alt="EDFLIX">
            </div>
            <div class="col col-md-4">
                <div class="row align-items-start">
                    <div class="col">
                        <strong>School: </strong>{{$school->name}}
                    </div>
                </div>
                <div class="row align-items-start">
                    <div class="col">
                        <strong>Class: </strong>{{$lesson->class}}
                    </div>
                </div>
                <div class="row align-items-start">
                    <div class="col">
                        <strong>Theme: </strong>{{$lesson->theme}}
                    </div>
                </div>
                <div class="row align-items-start">
                    <div class="col">
                        <strong>Number of learners: </strong>{{$lesson->learners_no}}
                    </div>
                </div>
            </div>
            <div class="col col-md-4">
                <div class="row align-items-start">
                    <div class="col">
                        <strong>Teacher: </strong>{{$owner->name}}
                    </div>
                </div>
                <div class="row align-items-start">
                    <div class="col">
                        <strong>Subject: </strong>{{$subject->name}}
                    </div>
                </div>
                <div class="row align-items-start">
                    <div class="col">
                        <strong>Topic: </strong>{{$lesson->topic}}
                    </div>
                </div>
                <div class="row align-items-start">
                    <div class="col">
                        <strong>Duration: </strong>{{ Carbon\CarbonInterval::minutes($duration)->cascade()->forHumans()  ?? '' }}
                    </div>
                </div>
            </div>
        </div>
        @if ($step->step == 1)
        <h2 class="lp-heading mt-5">Steps</h2>
        @endif

        <table style="border-collapse: collapse; margin-left:20pt" cellspacing="0">
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

            <tr style="height: 33pt">
                <td class="column" style="width:75pt;">
                    <p class="s2 column-head">Step {{$step->step}}<br>{{ Carbon\CarbonInterval::minutes($step->duration)->cascade()->forHumans()  ?? '' }}</p>
                </td>
                <td class="column" style="width: 150pt;">
                    <p class="s2 column-head">{{$step->teacher_activity}}</p>
                </td>
                <td class="column" style="width: 113pt;">
                    <p class="s2 column-head">{{$step->student_activity}}</p>
                </td>
                <td class="column" style="width: 111pt;">
                    <p class="s2 column-head">
                        <strong>Knowledge: </strong>{{$step->knowledge}}<br>
                        <strong>Values: </strong>{{$step->values}}<br>
                        <strong>Skills: </strong>{{$step->skills}}
                    </p>
                </td>
                <td class="column" style="width: 149pt;">
                    <p class="s2 column-head">{{$step->output}}</p>
                </td>
                <td class="column" style="width: 149pt;">
                    <p class="s2 column-head">{{$step->assessment_criteria}}</p>
                </td>
            </tr>
        </table>
        <br>

        @endforeach
    </body>
</html>
