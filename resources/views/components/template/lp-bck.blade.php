<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"> --}}
    <title>ACT NOW-LP</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }

        img.logo {
            padding: 10px 20px;
        }

        .lp-heading {
            margin-left: 150pt;
            text-indent: 0pt;
            text-align: left;
        }

        .col {
            font-size: 14px;
        }

        .page-break {
            page-break-after: always !important;
        }

        .m-4 {
            margin: 4rem !important;
        }

        .mt-3 {
            margin-top: 3rem !important;
        }

        .mt-4 {
            margin-top: 4rem !important;
        }

    </style>
</head>

<body>
    <img class="logo" src="assets/img/logos/actnow-logo.png" width="150" height="30" alt="ACT NOW">

    <h2 class="lp-heading">Lesson Plan Details</h2>

    <table style="border-collapse: collapse; border: none;" cellspacing="0" cellpadding="0">
        <tr style="border: none; height: 50pt; font-size:20px;">
            <td class="column" style="border: none; width:300pt;">
                <p class="s2 column-head"><strong>School: </strong>{{ $school->name }}</p>
            </td>
            <td class="column" style="border: none; width: 300pt;">
                <p class="s2 column-head"><strong>Teacher: </strong>{{ $owner->name }}</p>
            </td>
        </tr>
        <tr style="border: none; height: 50pt">
            <td class="column" style="border: none; width: 300pt;">
                <p class="s2 column-head"><strong>Class: </strong>{{ $lesson->clas }}</p>
            </td>
            <td class="column" style="border: none; width: 300pt;">
                <p class="s2 column-head"><strong>Subject: </strong>{{ $subject->name }}</p>
            </td>
        </tr>
        <tr style="border: none; height: 50pt">
            <td class="column" style="border: none; width: 300pt;">
                <p class="s2 column-head"><strong>Theme: </strong>{{ $lesson->theme }}</p>
            </td>
            <td class="column" style="border: none; width: 300pt;">
                <p class="s2 column-head"><strong>Topic: </strong>{{ $lesson->topic }}</p>
            </td>
        </tr>
        <tr style="border: none;height: 50pt">
            <td class="column" style="border: none; width: 300pt;">
                <p class="s2 column-head">
                    <strong>Number of learners: </strong>
                {{ $lesson->learners_no }}
                (<strong>Female: </strong>{{ $lesson->female_learners }} <strong>Male: </strong>{{ $lesson->male_learners }})
                </p>
            </td>
            <td class="column" style="border: none; width: 300pt;">
                <p class="s2 column-head">
                    <strong>Duration:
                    </strong>{{ Carbon\CarbonInterval::minutes($duration)->cascade()->forHumans() ?? '' }}
                </p>
            </td>
        </tr>
        <tr style="border: none;height: 50pt">
            <td class="column" style="border: none; width: 300pt;">
                <p class="s2 column-head">
                    <strong>Term: </strong>{{ $lesson->term }}
                </p>
            </td>
        </tr>
    </table>
    <div class="m-4">
        <div class="row align-items-start mt-5" style="margin-right: 100pt;">
            <div class="col">
                <strong>Competency: </strong>{{ $lesson->competency }}
            </div>
        </div>
        <div class="row align-items-start mt-3" style="margin-right: 100pt;">
            <div class="col">
                <strong>Learning Outcome: </strong>{{ $lesson->learning_outcomes }}
            </div>
        </div>
        <div class="row align-items-start mt-3" style="margin-right: 100pt;">
            <div class="col">
                <strong>Generic Skills: </strong>{{ $lesson->generic_skills }}
            </div>
        </div>
        <div class="row align-items-start mt-3" style="margin-right: 100pt;">
            <div class="col">
                <strong>Values: </strong>{{ $lesson->values }}
            </div>
        </div>
        <div class="row align-items-start mt-3" style="margin-right: 100pt;">
            <div class="col">
                <strong>Cross-cutting Issues: </strong>{{ $lesson->cross_cutting_issues }}
            </div>
        </div>
        <div class="row align-items-start mt-3" style="margin-right: 100pt;">
            <div class="col">
                <strong>Key learning outcomes: </strong>{{ $lesson->key_learning_outcomes }}
            </div>
        </div>
        <div class="row align-items-start mt-3" style="margin-right: 100pt;">
            <div class="col">
                <strong>Pre-Requisiste Knowledge: </strong>{{ $lesson->pre_requisite_knowledge }}
            </div>
        </div>
        <div class="row align-items-start mt-3" style="margin-right: 100pt;">
            <div class="col">
                <strong>Learning Materials: </strong>{{ $lesson->learning_materials }}
            </div>
        </div>
        <div class="row align-items-start mt-3" style="margin-right: 100pt;">
            <div class="col">
                <strong>Learning Methods: </strong>{{ $lesson->learning_methods }}
            </div>
        </div>
        <div class="row align-items-start mt-3" style="margin-right: 100pt;">
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
                    <img class="logo" src="assets/img/logos/actnow-logo.png" width="150" height="30" alt="ACT NOW">
                </td>
                <td class="column" style="border: none;width: 250pt;">
                    <div class="row align-items-start">
                        <div class="col">
                            <strong>School: </strong>{{ $school->name }}
                        </div>
                    </div>
                    <div class="row align-items-start">
                        <div class="col">
                            <strong>Class: </strong>{{ $lesson->clas }}
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
        <div class="row align-items-start m-4" style="margin-right: 180pt;">
            <div class="col">
                <strong>Activity Aim:</strong> {{ $lesson->activity_aim }}
            </div>
        </div>

        <h2 style="margin-left:20pt"><strong>Steps</strong></h2>

        <table class="" style=" margin-left:20pt" cellspacing="0">
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
            <tr style="height: 33pt page-break">
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

    {{-- START ANNEX --}}
    <div class="m-4">
        <h2 style="margin-left:20pt"><strong>Annexes</strong></h2>
        @foreach ($annexes as $annex)
            @if (Str::endsWith($annex->annex_file, ['.jpg', '.jpeg', '.png']))
                <table class="mt-4" style="border-collapse: collapse; margin-left:20pt" cellspacing="0">

                    <tr style="height: 33pt">
                        <td class="column" style="width: 150pt;">
                            <p class="s2 column-head" style="font-size:20px;"><span style="font-weight:bold;">Annex:</span>
                                {{ $annex->title }}</p>
                        </td>
                    </tr>
                    <tr style="height: 33pt">
                        <td class="column" style="width: 150pt;">
                            {{-- <img src="{{ url('/annex/' . $annex->annex_file) }}" alt="{{ $annex->title }}" width="1000" height="600"> --}}
                            <img src="annex/{{$annex->annex_file}}" alt="{{ $annex->title }}" width="1000" height="600">
                        </td>
                    </tr>

                </table>
                <br>
            @endif
        @endforeach
    </div>

</body>

</html>
