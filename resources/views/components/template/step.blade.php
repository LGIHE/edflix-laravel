
    <div class="row align-items-start">
        <div class="col col-md-4">
            <img class="logo" src="{{ asset('assets') }}/img/logos/EDPLAN.png" width="250" height="75"
                alt="EDFLIX">
        </div>
        <div class="col col-md-4">
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
        </div>
        <div class="col col-md-4">
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
        </div>
    </div>
    <div class="container">
        <div class="row align-items-start mt-4">
            <div class="col">
                <strong>Activity Aim:</strong> {{ $activity }}
            </div>
        </div>
    </div>
    {{-- @if ($step->step == 1) --}}
        <h2 class="lp-heading mt-3">Steps</h2>
    {{-- @endif --}}

    <table class="mt-4 page-break" style="border-collapse: collapse; margin-left:20pt" cellspacing="0">
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
<br>

