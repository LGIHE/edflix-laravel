<style>
    * {
        font-family: "Roboto", Helvetica, Arial, sans-serif;
    }
    a.nav-link, a.nav-link:hover {
        color: black;
    }

    .btn-close{
        color: #000;
        background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
    }

    #addAnnexModalLabel {
        font-family: var(--bs-body-font-family)!important;
    }

    #addBtn {
        position: fixed;
        bottom: 10px;
        right: 30px;
        z-index: 99;
        font-size: 20px;
        border: none;
        outline: none;
        background-color: red;
        color: white;
        cursor: pointer;
        padding: 15px;
		border-radius: 60px;
    }

    #addBtn:hover {
        background-color: #555;
    }

    .custom-popover {
        position: absolute;
        display: none;
        width: 300px;
        background-color: #f9f9f9;
        border: 1px solid #ccc;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        padding: 0 0 10px 0;
    }

    .custom-popover::before {
        content: "";
        position: absolute;
        left: -10px;
        top: 12px;
        transform: translateY(-50%);
        border: 5px solid transparent;
        border-right-color: #ccc;
        z-index: 1001;
    }

    .custom-popover-header {
        background-color: #f5f5f5;
        padding: 1px 14px;
        margin: 0;
        border-bottom: 1px solid #ccc;
        font-size: 16px;
    }

    .custom-popover-body {
        padding: 14px;
    }

    .info-popover {
        display: none;
        padding-top: 3px!important;
        color: #1a73e8d1!important;
    }

    .popover-container:hover .info-popover,
    .info-popover.show {
        display: inline-block!important;
    }

    .popover {
        display: none!important;
    }

    .comments-title {
        font-size: 15px;
        font-weight: 800;
    }

    .field-comment {
        font-size: 14px;
    }

    @keyframes blink {
        0% { opacity: 0; }
        50% { opacity: 1; }
        100% { opacity: 0; }
    }

    .blink {
        animation: blink 2s infinite;
    }

    /* @media (min-width: 1024px) {
        #lesson-plan-tab-1 {
            max-width: 70%;
        }
    } */

    #lesson-plan-tab {
        /* display: flex; */
        justify-content: space-between; /* Create space between columns */
    }

    #lesson-plan-tab > div:nth-child(1) {
        flex: 3; /* Set the width for the first div */
    }

    #lesson-plan-tab > div:nth-child(2) {
        flex: 1; /* Set the width for the second div */
    }

    #lesson-plan-tab-2 {
        background: #80808012;
    }

    #lesson-plan-tab-2 h5 {
        margin-top: 10px;
    }

</style>

<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <x-navbars.sidebar activePage="lesson-plans"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100 pb-5">
        <!-- Navbar -->
        <x-navbars.topbar titlePage='Lesson Plan'></x-navbars.topbar>
        <!-- End Navbar -->
        <div class="container-fluid px-2 mt-2">
            <div class="card card-body">

                <div class="card card-plain h-100">
                    <div class="card-body p-3">
                        @if (session('status'))
                        <div class="row">
                            <div class="alert alert-success alert-dismissible text-white" role="alert">
                                <span class="text-sm">{{ Session::get('status') }}</span>
                                <button type="button" class="btn-close text-lg py-3 opacity-10"
                                    data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        @elseif (session('error'))
                        <div class="row">
                            <div class="alert alert-danger alert-dismissible text-white" role="alert">
                                <span class="text-sm">{{ Session::get('error') }}</span>
                                <button type="button" class="btn-close text-lg py-3 opacity-10"
                                    data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        @endif
                        <div class="card-header pb-0 p-2 pt-0">
                            <div class="row">
                                <div class="me-3 my-3 text-end">
                                    @if ($lesson->owner == auth()->user()->id || auth()->user()->isAdmin())
                                        @if ($lesson->status != 'submitted')
                                            <a class="btn bg-gradient-success mb-0 end" id="submit-for-review" data-value="{{ $lesson->id }}">
                                                <i class="material-icons text-sm">check</i>&nbsp;&nbsp;Submit for Review
                                            </a>
                                        @else
                                            <a class="btn bg-gradient-secondary mb-0 end disabled">
                                                <i class="material-icons text-sm">check</i>&nbsp;&nbsp;Submitted for Review
                                            </a>
                                        @endif
                                    @endif
                                    @if ($lesson->status == 'reviewed')
                                        <a class="btn bg-gradient-info mb-0 end" href="{{ route('download.lp', $lesson->id) }}" target="_blank">
                                            <i class="material-icons text-sm">download</i>&nbsp;&nbsp;Download
                                        </a>
                                    @else
                                        @if ($lesson->owner == auth()->user()->id || auth()->user()->isAdmin())
                                            <a class="btn bg-gradient-info mb-0 end" href="{{ route('download.lp', $lesson->id) }}" target="_blank">
                                                <i class="material-icons text-sm">download</i>&nbsp;&nbsp;Download
                                            </a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div>
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#lesson-plan-tab">Lesson Plan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#timeline-tab">Review Timeline</a>
                                </li>
                            </ul>
                        </div>
                        <div id="lesson" data-id='{{$lesson->id}}'></div>
                        <div class="tab-content">
                            <div id="lesson-plan-tab" class="d-md-flex tab-pane fade show active" role="tabpanel" aria-labelledby="lesson-plan-tab">
                                <div id="lesson-plan-tab-1">
                                    <div class="card-body px-0 pb-2">
                                        <div class="m-4 mb-2">
                                            <div class="row">
                                                <div class="col-md-6 d-flex popover-container">
                                                    <p class="text-dark font-weight-bold">School:</p>&nbsp;
                                                    <p class="text-dark">{{ $school->name }}</p>
                                                </div>
                                                <div class="col-md-6 d-flex popover-container">
                                                    <p class="text-dark font-weight-bold">Teacher:</p>&nbsp;
                                                    <p class="text-dark">{{ $owner->name }}</p>&nbsp;
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 d-flex popover-container">
                                                    <p class="text-dark font-weight-bold">Class:</p>&nbsp;
                                                    <p class="text-dark">{{ $lesson->class }}</p>
                                                </div>
                                                <div class="col-md-6 d-flex popover-container">
                                                    <p class="text-dark font-weight-bold">Subject:</p>&nbsp;
                                                    <p class="text-dark">{{ $subject->name }}</p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 d-flex popover-container">
                                                    <p class="text-dark font-weight-bold">Topic:</p>&nbsp;
                                                    <p class="text-dark">{{ $lesson->topic }}</p>&nbsp;
                                                    <a href="#" class="info-popover" data-toggle="popover" data-title="Topic" data-content="{{ $lesson->topic }}" data-comment-lp="{{ $lesson->id }}" data-comment-type="pleriminary"  data-comment-field="Topic" data-field-type="text">
                                                        <i class="fa fa-info-circle" id="topic-info"></i>
                                                    </a>
                                                </div>
                                                <div class="col-md-6 d-flex popover-container">
                                                    <p class="text-dark font-weight-bold">Theme:</p>&nbsp;
                                                    <p class="text-dark">{{ $lesson->theme }}</p>&nbsp;
                                                    <a href="#" class="info-popover" data-toggle="popover" data-title="Theme" data-content="{{ $lesson->theme }}" data-comment-lp="{{ $lesson->id }}" data-comment-type="pleriminary" data-comment-field="Theme" data-field-type="text">
                                                        <i class="fa fa-info-circle" id="theme-info"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 d-flex popover-container">
                                                    <p class="text-dark font-weight-bold">Number of learners:</p>&nbsp;
                                                    <p class="text-dark">
                                                        {{ $lesson->female_learners + $lesson->male_learners }}
                                                        (<strong>F: </strong>{{ $lesson->female_learners }}
                                                        <a href="#" class="info-popover" data-toggle="popover" data-title="Female Learners" data-comment-lp="{{ $lesson->id }}" data-content="{{ $lesson->female_learners }}" data-comment-type="pleriminary" data-comment-field="Female Learners" data-field-type="number">
                                                            <i class="fa fa-info-circle" id="female_learners-info"></i>
                                                        </a>
                                                        <strong>M: </strong>{{ $lesson->male_learners }}
                                                        <a href="#" class="info-popover" data-toggle="popover" data-title="Male Learners" data-comment-lp="{{ $lesson->id }}" data-content="{{ $lesson->male_learners }}" data-comment-type="pleriminary" data-comment-field="Male Learners" data-field-type="number">
                                                            <i class="fa fa-info-circle" id="male_learners-info"></i>
                                                        </a>
                                                        )
                                                    </p>&nbsp;
                                                </div>
                                                <div class="col-md-6 d-flex popover-container">
                                                    <p class="text-dark font-weight-bold">Duration:</p>&nbsp;
                                                    <p class="text-dark">{{ Carbon\CarbonInterval::minutes($duration)->cascade()->forHumans() ?? '' }}</p>&nbsp;
                                                    {{-- <a href="#" class="info-popover" data-toggle="popover" data-title="Duration" data-comment-lp="{{ $lesson->id }}" data-comment-type="pleriminary" data-comment-field="Duration">
                                                        <i class="fa fa-info-circle" id="duration-info"></i>
                                                    </a> --}}
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 d-flex popover-container ">
                                                    <p class="text-dark font-weight-bold">Term:</p>&nbsp;
                                                    <p class="text-dark">{{ $lesson->term }}</p>&nbsp;
                                                    <a href="#" class="info-popover" data-toggle="popover" data-title="Term" data-content="{{ $lesson->term }}" data-comment-lp="{{ $lesson->id }}" data-comment-type="pleriminary" data-comment-field="Term" data-field-type="number">
                                                        <i class="fa fa-info-circle" id="term-info"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="m-4 mt-2 text-dark">
                                            <div class="row align-items-start mt-5 popover-container">
                                                <div class="col">
                                                    <strong>Competency: </strong>{{ $lesson->competency }}
                                                    <a href="#" class="info-popover" data-toggle="popover" data-title="Competency" data-content="{{ $lesson->competency }}" data-comment-lp="{{ $lesson->id }}" data-comment-type="pleriminary" data-comment-field="Competency" data-field-type="textarea">
                                                        <i class="fa fa-info-circle" id="competency-info"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row align-items-start mt-3 popover-container">
                                                <div class="col">
                                                    <strong>Learning Outcomes: </strong>{{ $lesson->learning_outcomes }}
                                                    <a href="#" class="info-popover" data-toggle="popover" data-title="Learning Outcomes" data-content="{{ $lesson->learning_outcomes }}" data-comment-lp="{{ $lesson->id }}" data-comment-type="pleriminary" data-comment-field="Learning Outcomes" data-field-type="textarea">
                                                        <i class="fa fa-info-circle" id="learning_outcomes-info"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row align-items-start mt-3 popover-container">
                                                <div class="col">
                                                    <strong>Generic Skills: </strong>{{ $lesson->generic_skills }}
                                                    <a href="#" class="info-popover" data-toggle="popover" data-title="Generic Skills" data-content="{{ $lesson->generic_skills }}" data-comment-lp="{{ $lesson->id }}" data-comment-type="pleriminary" data-comment-field="Generic Skills" data-field-type="textarea">
                                                        <i class="fa fa-info-circle" id="generic_skills-info"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row align-items-start mt-3 popover-container">
                                                <div class="col">
                                                    <strong>Values: </strong>{{ $lesson->values }}
                                                    <a href="#" class="info-popover" data-toggle="popover" data-title="Values" data-content="{{ $lesson->values }}" data-comment-lp="{{ $lesson->id }}" data-comment-type="pleriminary" data-comment-field="Values">
                                                        <i class="fa fa-info-circle" id="values-info"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row align-items-start mt-3 popover-container">
                                                <div class="col">
                                                    <strong>Cross-cutting Issues: </strong>{{ $lesson->cross_cutting_issues }}
                                                    <a href="#" class="info-popover" data-toggle="popover" data-title="Cross-cutting Issues" data-content="{{ $lesson->cross_cutting_issues }}" data-comment-lp="{{ $lesson->id }}" data-comment-type="pleriminary" data-comment-field="Cross-cutting Issues" data-field-type="textarea">
                                                        <i class="fa fa-info-circle" id="cross_cutting_issues-info"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row align-items-start mt-3 popover-container">
                                                <div class="col">
                                                    <strong>Key learning outcomes: </strong>{{ $lesson->key_learning_outcomes }}
                                                    <a href="#" class="info-popover" data-toggle="popover" data-title="Key Learning Outcomes" data-content="{{ $lesson->key_learning_outcomes }}" data-comment-lp="{{ $lesson->id }}" data-comment-type="pleriminary" data-comment-field="Key Learning Outcomes" data-field-type="textarea">
                                                        <i class="fa fa-info-circle" id="key_learning_outcomes"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row align-items-start mt-3 popover-container">
                                                <div class="col">
                                                    <strong>Pre-Requisiste Knowledge: </strong>{{ $lesson->pre_requisite_knowledge }}
                                                    <a href="#" class="info-popover" data-toggle="popover" data-title="Pre-Requisite Knowledge" data-content="{{ $lesson->pre_requisite_knowledge }}" data-comment-lp="{{ $lesson->id }}" data-comment-type="pleriminary" data-comment-field="Pre-Requisite Knowledge" data-field-type="textarea">
                                                        <i class="fa fa-info-circle" id="pre_requisite_knowledge"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row align-items-start mt-3 popover-container">
                                                <div class="col">
                                                    <strong>Learning Materials: </strong>{{ $lesson->learning_materials }}
                                                    <a href="#" class="info-popover" data-toggle="popover" data-title="Learning Materials" data-content="{{ $lesson->learning_materials }}" data-comment-lp="{{ $lesson->id }}" data-comment-type="pleriminary" data-comment-field="Learning Materials" data-field-type="textarea">
                                                        <i class="fa fa-info-circle" id="learning_materials-info"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row align-items-start mt-3 popover-container">
                                                <div class="col">
                                                    <strong>Learning Methods: </strong>{{ $lesson->learning_methods }}
                                                    <a href="#" class="info-popover" data-toggle="popover" data-title="Learning Methods" data-content="{{ $lesson->learning_methods }}" data-comment-lp="{{ $lesson->id }}" data-comment-type="pleriminary" data-comment-field="Learning Methods" data-field-type="textarea">
                                                        <i class="fa fa-info-circle" id="learning_methods-info"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row align-items-start mt-3 popover-container">
                                                <div class="col">
                                                    <strong>References: </strong>{{ $lesson->references }}
                                                    <a href="#" class="info-popover" data-toggle="popover" data-title="References" data-content="{{ $lesson->references }}" data-comment-lp="{{ $lesson->id }}" data-comment-type="pleriminary" data-comment-field="References" data-field-type="textarea">
                                                        <i class="fa fa-info-circle" id="references-info"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row align-items-start mt-3 popover-container">
                                                <div class="col">
                                                    <strong>Activity Aim: </strong>{{ $lesson->activity_aim}}
                                                    <a href="#" class="info-popover" data-toggle="popover" data-title="Activity Aim" data-content="{{ $lesson->activity_aim }}" data-comment-lp="{{ $lesson->id }}" data-comment-type="pleriminary" data-comment-field="Activity Aim" data-field-type="textarea">
                                                        <i class="fa fa-info-circle" id="activity_aim-info"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body px-0 pb-2">
                                        @if(count($steps) > 0)
                                            <div class="d-flex">
                                                <div>
                                                    @if(count($steps) > 1)
                                                        <h2 style="margin-left: 20px;"><strong>Steps</strong></h2>
                                                    @else
                                                        <h2 style="margin-left: 20px;"><strong>Step</strong></h2>
                                                    @endif
                                                </div>
                                                <a class="btn bg-gradient-dark ms-auto" data-bs-toggle="modal" data-bs-target="#addStepModal">
                                                    <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add a Step
                                                </a>
                                            </div>

                                            <div class="table-responsive p-0 mt-3">
                                                <table class="text-dark" style="border-collapse: collapse; margin-left:15pt; border: 2px solid black;" cellspacing="0">
                                                    <tr style="height: 33pt">
                                                        <td class="column" style="width:110pt; border: 1px solid black;">
                                                            <p class="s2 column-head"><strong>Duration of activity</strong></p>
                                                        </td>
                                                        <td class="column" style="width: 180pt; border: 1px solid black;">
                                                            <p class="s2 column-head"><strong>Teacher’s activity</strong></p>
                                                        </td>
                                                        <td class="column" style="width: 113pt; border: 1px solid black;">
                                                            <p class="s2 column-head"><strong>Students’ activity</strong></p>
                                                        </td>
                                                        <td class="column" style="width: 180pt;border: 1px solid black;">
                                                            <p class="s2 column-head"><strong>Knowledge, value and skills</strong></p>
                                                        </td>
                                                        <td class="column" style="width: 149pt; border: 1px solid black;">
                                                            <p class="s2 column-head"><strong>Output</strong></p>
                                                        </td>
                                                        <td class="column" style="width: 149pt; border: 1px solid black;">
                                                            <p class="s2 column-head"><strong>Assessment criteria</strong></p>
                                                        </td>
                                                    </tr>
                                                    @foreach ($steps as $step)
                                                    <tr class="steps" style="height: 33pt">
                                                        <td class="column popover-container" style="width:75pt; border: 1px solid black;">
                                                            <p class="s2 column-head" style="margin-left: 10px;">Step
                                                                {{ $step->step }}<br>@if($step->duration < 2) - @else{{ Carbon\CarbonInterval::minutes($step->duration)->cascade()->forHumans() ?? '' }}@endif
                                                                <a href="#" class="info-popover" data-toggle="popover" data-title="Duration" data-content="{{ $step->duration }}" data-comment-lp="{{ $lesson->id }}" data-comment-type="step" data-step="{{ $step->id }}" data-step-no="{{ $step->step }}" data-comment-field="Duration" data-field-type="number">
                                                                    <i class="fa fa-info-circle" id="duration-info-{{$step->id}}"></i>
                                                                </a>
                                                            </p>
                                                        </td>
                                                        <td class="column popover-container" style="width: 150pt; border: 1px solid black;">
                                                            <p class="s2 column-head" style="margin-left: 10px;">{{ $step->teacher_activity }}
                                                                <a href="#" class="info-popover" data-toggle="popover" data-title="Teacher Activity" data-content="{{ $step->teacher_activity }}" data-comment-lp="{{ $lesson->id }}" data-comment-type="step" data-step="{{ $step->id }}" data-step-no="{{ $step->step }}" data-comment-field="Teacher Activity" data-field-type="textarea">
                                                                    <i class="fa fa-info-circle" id="teacher_activity-info-{{$step->id}}"></i>
                                                                </a>
                                                            </p>
                                                        </td>
                                                        <td class="column popover-container" style="width: 113pt; border: 1px solid black;">
                                                            <p class="s2 column-head" style="margin-left: 10px;">{{ $step->student_activity }}
                                                                <a href="#" class="info-popover" data-toggle="popover" data-title="Student Activity" data-content="{{ $step->student_activity }}" data-comment-lp="{{ $lesson->id }}" data-comment-type="step" data-step="{{ $step->id }}" data-step-no="{{ $step->step }}" data-comment-field="Student Activity" data-field-type="textarea">
                                                                    <i class="fa fa-info-circle" id="student_activity-info-{{$step->id}}"></i>
                                                                </a>
                                                            </p>
                                                        </td>
                                                        <td class="column" style="width: 111pt; border: 1px solid black;">
                                                            <p class="s2 column-head popover-container" style="margin-left: 10px;">
                                                                <strong>Knowledge: </strong>{{ $step->knowledge }}
                                                                <a href="#" class="info-popover" data-toggle="popover" data-title="Knowledge" data-content="{{ $step->knowledge }}" data-comment-lp="{{ $lesson->id }}" data-comment-type="step" data-step="{{ $step->id }}" data-step-no="{{ $step->step }}" data-comment-field="Knowledge" data-field-type="textarea">
                                                                    <i class="fa fa-info-circle" id="knowledge-info-{{$step->id}}"></i>
                                                                </a><br>
                                                                <strong>Values: </strong>{{ $step->values }}
                                                                <a href="#" class="info-popover" data-toggle="popover" data-title="Values" data-content="{{ $step->values }}" data-comment-lp="{{ $lesson->id }}" data-comment-type="step" data-step="{{ $step->id }}" data-step-no="{{ $step->step }}" data-comment-field="Values" data-field-type="textarea">
                                                                    <i class="fa fa-info-circle" id="values-info-{{$step->id}}"></i>
                                                                </a><br>
                                                                <strong>Skills: </strong>{{ $step->skills }}
                                                                <a href="#" class="info-popover" data-toggle="popover" data-title="Skills" data-content="{{ $step->skills }}" data-comment-lp="{{ $lesson->id }}" data-comment-type="step" data-step="{{ $step->id }}" data-step-no="{{ $step->step }}" data-comment-field="Skills" data-field-type="textarea">
                                                                    <i class="fa fa-info-circle" id="skills-info-{{$step->id}}"></i>
                                                                </a>
                                                            </p>
                                                        </td>
                                                        <td class="column popover-container" style="width: 149pt; border: 1px solid black;">
                                                            <p class="s2 column-head" style="margin-left: 10px;">{{ $step->output }}
                                                                <a href="#" class="info-popover" data-toggle="popover" data-title="Output" data-content="{{ $step->output }}" data-comment-lp="{{ $lesson->id }}" data-comment-type="step" data-step="{{ $step->id }}" data-step-no="{{ $step->step }}" data-comment-field="Output" data-field-type="textarea">
                                                                    <i class="fa fa-info-circle" id="output-info-{{$step->id}}"></i>
                                                                </a>
                                                            </p>
                                                        </td>
                                                        <td class="column popover-container" style="width: 149pt; border: 1px solid black;margin-left: 10px;">
                                                            <p class="s2 column-head">{{ $step->assessment_criteria }}
                                                                <a href="#" class="info-popover" data-toggle="popover" data-title="Assessment Criteria" data-content="{{ $step->assessment_criteria }}" data-comment-lp="{{ $lesson->id }}" data-comment-type="step" data-step="{{ $step->id }}" data-step-no="{{ $step->step }}" data-comment-field="Assessment Criteria" data-field-type="textarea">
                                                                    <i class="fa fa-info-circle" id="assessment_criteria-info-{{$step->id}}"></i>
                                                                </a>
                                                            </p>
                                                        </td>
                                                        <td style="text-align: right;border: 1px solid black;">
                                                            <a class="" data-bs-toggle="modal" data-bs-target="#deleteModal-{{$step->id}}" title="Delete Step" style="cursor:pointer;">
                                                                <i class="fa fa-times" style="font-size: 24px; color: red;"></i>
                                                            </a>
                                                        </td>
                                                    </tr>

                                                    {{-- Confirm Step Deletion --}}
                                                    <div class="modal fade" id="deleteModal-{{ $step->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-sm" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Confirm</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body" id="smallBody">
                                                                    <div class="text-center">
                                                                        <span class="">Are you sure you want to Delete this Step?</span>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer align-items-center">
                                                                    <button type="button" class="btn btn-success" id="del-btn" data-value="{{ route('delete.step', $step->id) }}">Confirm</button>
                                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </table>
                                            </div>

                                        @else
                                            <div class="container text-center m-2 p-4">
                                                <p class="font-weight-bold">No Steps Added Yet.</p>

                                                <a class="btn bg-gradient-dark" data-bs-toggle="modal" data-bs-target="#addStepModal">
                                                    <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add a Step
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="card-body px-0 pb-2">
                                        @if(count($annexes) > 0)
                                            {{-- <div> --}}
                                                <div class="d-flex">
                                                    <div>
                                                        @if(count($annexes) > 1)
                                                            <h2 style="margin-left: 20px;"><strong>Annexes</strong></h2>
                                                        @else
                                                            <h2 style="margin-left: 20px;"><strong>Annex</strong></h2>
                                                        @endif
                                                    </div>
                                                    <a class="btn bg-gradient-dark ms-auto" data-bs-toggle="modal" data-bs-target="#addAnnexModal">
                                                        <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add an Annex
                                                    </a>
                                                </div>

                                                @foreach ($annexes as $annex)
                                                    @if (Str::endsWith($annex->annex_file, ['.jpg', '.jpeg', '.png']))
                                                        <table class="mt-4 annex" style="border-collapse: collapse; margin-left:20pt; border: 2px black solid" cellspacing="0">

                                                            <tr style="height: 20pt; border: 1px black solid">
                                                                <td class="column text-dark d-flex popover-container">
                                                                    <p class="s2 column-head mt-2" style="font-size:20px;">{{ $annex->title }}
                                                                        <a href="#" class="info-popover" data-toggle="popover" data-title="Annex Title" data-content="{{ $annex->title }}" data-comment-lp="{{ $lesson->id }}" data-annex="{{ $annex->id }}" data-comment-type="annex"  data-comment-field="Title" data-field-type="text" style="font-size:17px;">
                                                                            <i class="fa fa-info-circle" id="annex_title-info-{{$annex->id}}"></i>
                                                                        </a>
                                                                    </p>
                                                                    <a class="ms-auto mt-2" data-bs-toggle="modal" data-bs-target="#deleteModal-{{$annex->id}}" title="Delete Annex" style="cursor:pointer;">
                                                                        <i class="material-icons" style="font-size:25px;margin-right:20px;color:red">close</i>
                                                                        <div class="ripple-container"></div>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr style="height: 33pt">
                                                                <td class="column popover-container">
                                                                    <a href="#" class="info-popover" data-toggle="popover" data-title="Annex File" data-content="{{ $annex->annex_file }}" data-comment-lp="{{ $lesson->id }}" data-annex="{{ $annex->id }}" data-annex-title="{{ $annex->title }}" data-comment-type="annex"  data-comment-field="Annex File" data-field-type="file">
                                                                        <i class="fa fa-info-circle" id="annex_file-info-{{$annex->id}}"></i>
                                                                    </a>
                                                                    <img src="{{ url('/annex/' . $annex->annex_file) }}" alt="{{ $annex->title }}" width="600" height="400">
                                                                </td>
                                                            </tr>

                                                        </table>
                                                        <br>
                                                    @endif
                                                    <!-- Confirm Annex Delete modal -->
                                                    <div class="modal fade" id="deleteModal-{{ $annex->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-sm" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Confirm</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body" id="smallBody">
                                                                    <div class="text-center">
                                                                        <span class="">Are you sure you want to Delete this Annex?</span>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer align-items-center">
                                                                    <button type="button" class="btn btn-success" id="del-btn" data-value="{{ route('delete.annex', $annex->id) }}">Confirm</button>
                                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            {{-- </div> --}}
                                        @else
                                            <div class="container text-center m-2 p-4">
                                                <p class="font-weight-bold">No Annexes Added Yet.</p>

                                                <a class="btn bg-gradient-dark" data-bs-toggle="modal" data-bs-target="#addAnnexModal">
                                                    <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add an Annex
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                                <div class="d-none d-md-inline-block" id="lesson-plan-tab-2">
                                    <center><h5>Comments</h5></center>
                                    <div class="card-body px-0 pb-2">
                                        @if (count($comments) > 0)
                                            @include('lesson-plan.comments.comment')
                                            <a class="btn bg-gradient-info btn-floating" id="addBtn" data-bs-toggle="modal" data-bs-target="#addCommentModal">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        @else
                                            <div class="container text-center m-2 p-4">
                                                <p class="font-weight-bold">No Review Comments Added Yet.</p>
                                                {{-- <a class="btn bg-gradient-dark" data-bs-toggle="modal" data-bs-target="#addCommentModal">
                                                    <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add a Review Comment
                                                </a> --}}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="timeline-tab" role="tabpanel" aria-labelledby="timeline-tab">
                                <div class="card-body px-0 pb-2">
                                    <div class="container text-center m-2">
                                        @include('lesson-plan.timeline.view')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="custom-popover" id="custom-popover">
        <div class="custom-popover-header d-flex justify-content-between align-items-center">
            <h5 class="popover-header"></h5>
            <a href="#" class="close-popover">X</a>
        </div>
        <div class="custom-popover-body">
            <div class="popover-content"></div>
            <div class="comment-form" style="display:none;">
                <form method='POST' id="addCommentForm">
                    @csrf
                    <input type="hidden" name="lesson_plan" value="{{ $lesson->id }}">
                    <input type="hidden" name="user" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="target" value="" class="comment-target">
                    <input type="hidden" name="pleriminary" value="" class="comment-content">
                    <input type="hidden" name="step_field" value="" class="step-field">
                    <input type="hidden" name="step_no" value="" class="step-no">
                    <input type="hidden" name="annex_field" value="" class="annex-field">
                    <div class="">
                        <label class="form-label comment-label"></label>
                        <textarea name="comment" class="form-control border border-2 p-2 comment-input" cols="30" rows="3"></textarea>
                        <p class='text-danger font-weight-bold inputerror' id="commentError"></p>
                    </div>
                    <button class="btn btn-success submit-comment">Comment <span id="loader"></span></button>
                    <button class="btn btn-danger cancel-btn">Cancel</button>
                </form>
            </div>
            <div class="edit-form" style="display:none;">
                <form method='POST' id="editForm">
                    @csrf
                    <input type="hidden" name="id" value="{{ $lesson->id }}">
                    <input type="hidden" name="target" value="" class="comment-target">
                    <input type="hidden" name="field" value="" class="comment-field">
                    <input type="hidden" name="step" value="" class="step-field-edit">
                    <input type="hidden" name="annex" value="" class="annex-field-edit">
                    <input type="hidden" class="annex-title">
                    <div class="">
                        <label class="form-label edit-label"></label>
                        <div class="input-field"></div>
                        <p class='text-danger font-weight-bold inputerror' id="editError"></p>
                    </div>
                    <button class="btn btn-success submit-edit">Edit <span id="loader"></span></button>
                    <button class="btn btn-danger cancel-btn">Cancel</button>
                </form>
            </div>
        </div>

        <div class="custom-popover-btn">
            <button class="btn btn-info mb-0 comment-btn" style="margin-left: 15px;">Comment</button>
            <button class=" btn btn-success mb-0 edit-btn">Edit</button>
        </div>

    </div>

</x-layout>

<!-- Add Annex Modal -->
<div class="modal fade" id="addAnnexModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addAnnexModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAnnexModalLabel">Add an Annex</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="addAnnexForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="lesson_plan" value="{{ $lesson->id }}">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control border border-2 p-2">
                        <p class='text-danger font-weight-bold inputerror' id="titleError"></p>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Annex File</label>
                        <input type="file" name="annex_file" class="form-control border border-2 p-2">
                        <p class='text-danger font-weight-bold inputerror' id="annex_fileError"></p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success btn-submit" data-value="{{ $lesson->id }}">Add Annex <span id="loader"></span></button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '#del-btn', function(event) {
        event.preventDefault();
        $(this).prop("disabled", true);
        let href = $(this).data('value');
        window.location.assign(href);
    });

    $(document).ready(function () {

        // When the "Lesson Plan" tab is clicked
        $("a[href='#lesson-plan-tab']").on("click", function () {
            $("#lesson-plan-tab").removeAttr("style");
        });

        // When the "Review Timeline" tab is clicked
        $("a[href='#timeline-tab']").on("click", function () {
            $("#lesson-plan-tab").attr("style", "display: none!important");
        });
    });

    $(document).ready(function() {
        var lesson_id = $('#lesson').attr('data-id');
        var steps = $('.steps');
        var annexes = $('.annex');

        // Define an array of fields and their corresponding icon selectors
        var fields = [
            { target: 'pleriminary', commentable: 'Competency', iconSelector: '#competency-info' },
            { target: 'pleriminary', commentable: 'Topic', iconSelector: '#topic-info' },
            { target: 'pleriminary', commentable: 'Theme', iconSelector: '#theme-info' },
            { target: 'pleriminary', commentable: 'Female Learners', iconSelector: '#female_learners-info' },
            { target: 'pleriminary', commentable: 'Male Learners', iconSelector: '#male_learners-info' },
            { target: 'pleriminary', commentable: 'Term', iconSelector: '#term-info' },
            { target: 'pleriminary', commentable: 'Learning Outcomes', iconSelector: '#learning_outcomes-info' },
            { target: 'pleriminary', commentable: 'Generic Skills', iconSelector: '#generic_skills-info' },
            { target: 'pleriminary', commentable: 'Values', iconSelector: '#values-info' },
            { target: 'pleriminary', commentable: 'Cross-cutting Issues', iconSelector: '#cross_cutting_issues-info' },
            { target: 'pleriminary', commentable: 'Key Learning Outcomes', iconSelector: '#key_learning_outcomes' },
            { target: 'pleriminary', commentable: 'Pre-Requisite Knowledge', iconSelector: '#pre_requisite_knowledge' },
            { target: 'pleriminary', commentable: 'Learning Materials', iconSelector: '#learning_materials-info' },
            { target: 'pleriminary', commentable: 'Learning Methods', iconSelector: '#learning_methods-info' },
            { target: 'pleriminary', commentable: 'References', iconSelector: '#references-info' },
            { target: 'pleriminary', commentable: 'Activity Aim', iconSelector: '#activity_aim-info' }

        ];

        steps.each(function(){
            var tds = $(this).find('td');
            tds.each(function(){
                var $icon = $(this).find('i.fa-info-circle');
                var iconId = $icon.attr('id');

                var $step = $(this).find('a.info-popover');
                var theStep = $step.data('step');
                var stepCommentField = $step.data('comment-field');

                var stepField = {
                    target: 'step',
                    commentable: theStep,
                    comment_field: stepCommentField,
                    iconSelector: '#'+iconId
                }

                // Append the new field object to the existing array
                fields.push(stepField);
            })
        })

        annexes.each(function(){
            var trs = $(this).find('tr');
            trs.each(function(){
                var $icon = $(this).find('i.fa-info-circle');
                var iconId = $icon.attr('id');

                var $annex = $(this).find('a.info-popover');
                var theAnnex= $annex.data('annex');
                var annexCommentField = $annex.data('comment-field');

                var annexField = {
                    target: 'annex',
                    commentable: theAnnex,
                    comment_field: annexCommentField,
                    iconSelector: '#'+iconId
                }

                // Append the new field object to the existing array
                fields.push(annexField);
            })
        })

        // Loop through the fields and check for comments for each field
        fields.forEach(function (field) {
            // Your existing AJAX code to check for comments
            $.ajax({
                url: "{{route('get.field.comments')}}",
                // url: '/get-field-comments',
                type: 'GET',
                data: { lesson: lesson_id, target: field.target, commentable: field.commentable, field: field.comment_field },
                success: function (comments) {
                    // Check if comments exist for the current field
                    var commentsExist = comments.length > 0;
                    toggleIconBlink(commentsExist, field.iconSelector);
                },
                error: function () {
                    // Call the toggleIconBlink function with false in case of an error
                    toggleIconBlink(false);
                }
            });
        })

        // Function to toggle the icon-blink class based on comments
        function toggleIconBlink(commentsExist, iconSelector) {
            // Check if commentsExist is true, then add the 'blink' class, otherwise, remove it
            if (commentsExist) {
                $(iconSelector).addClass('blink');
                $(iconSelector).parent().css('display', 'inline-block');
            } else {
                $(iconSelector).removeClass('blink');
                $(iconSelector).parent().css('display', 'none');
            }
        }

        // Show popover
        $('.fa-info-circle').click(function(e) {
            e.preventDefault();
            var position = $(this).offset();
            var title = $(this).parent().attr('data-title');
            var content = $(this).parent().attr('data-content');
            var target = $(this).parent().attr('data-comment-type');
            var lesson = $(this).parent().attr('data-comment-lp');
            var comment_field = $(this).parent().attr('data-comment-field');
            var input_name = comment_field.replace(/[\s-]/g, '_').toLowerCase();
            var input_type = $(this).parent().attr('data-field-type');
            var theStep = $(this).parent().attr('data-step');
            var theStepNo = $(this).parent().attr('data-step-no');
            var theAnnex = $(this).parent().attr('data-annex');
            var theAnnexTitle = $(this).parent().attr('data-annex-title');

            if($('.custom-popover').css('display') !== 'none'){
                $('.custom-popover').hide();
                $('.comment-form').hide();
                $('.edit-form').hide();
                $('.popover-content').show();
                $('.comment-btn, .edit-btn').show();
                $('.comment-input').val('');
                $(".inputerror").text("");
                $("#addCommentForm input").removeClass("is-invalid");
                $('.input-field').html('');
            }

            // Set popover header
            $('.custom-popover .popover-header').text(title);

            $('.edit-btn').attr('data-field-type', input_type);

            // Update the Input Field Type
            editInputChange(input_type);

            // Set edit content
            if (target != 'annex'){
                $('.custom-popover .edit-input').val(content);
            }

            if (target == 'annex' && input_type == 'file'){
                $('.custom-popover .submit-edit').attr('data-file', 'true');
            }else{

                $('.custom-popover .submit-edit').attr('data-file', 'false');
            }

            $('.custom-popover .comment-field').val(input_name);

            // Set the comment and edit labels
            $('.custom-popover .comment-label').text('Comment on ' + title);
            $('.custom-popover .edit-label').text('Edit ' + title);

            // Set the comment target and content
            $('.custom-popover .comment-target').val(target);
            $('.custom-popover .comment-content').val(comment_field);

            if(target == 'step'){
                $('.custom-popover .comment-content').attr('name', target);
                $('.custom-popover .comment-content').val(theStep);
                $('.custom-popover .step-field').val(comment_field);

                $('.custom-popover .edit-input').attr('name', input_name);
                $('.custom-popover .step-field-edit').val(theStep);
                $('.custom-popover .step-no').val(theStepNo);
            }

            if(target == 'annex'){
                $('.custom-popover .comment-content').attr('name', target);
                $('.custom-popover .comment-content').val(theAnnex);
                $('.custom-popover .annex-field').val(comment_field);

                if(input_name == 'title'){
                    $('.custom-popover .edit-input').val(content);
                }
                    $('.custom-popover .annex-title').attr('name', 'title');
                    $('.custom-popover .annex-title').val(theAnnexTitle);
                    $('.custom-popover .edit-input').attr('name', input_name);
                    $('.custom-popover .annex-field-edit').val(theAnnex);

            }

            $('.custom-popover').css({ top: position.top, left: position.left + 20 }).show();

            // Call the function whenever the window is resized
            $(window).resize(adjustPopoverPosition);

            // Call the function whenever the popover is shown
            $('.custom-popover').show(adjustPopoverPosition);

            // Add loading effect
            $('.popover-content').html('<div class="loading">Loading...</div>');

            // Fetch the comments via AJAX
            $.ajax({
                url: "{{route('get.comments')}}",
                // url: '/get-comments',
                type: 'GET',
                data: { lesson: lesson, target: target, content: theStep ? theStep : theAnnex ? theAnnex : comment_field, target_field: comment_field},
                success: function(comments) {
                    if (comments.length === 0) {
                        $('.popover-content').html('<div class="no-comment">No Review Comments</div>');
                    } else {
                        var commentHtml = '<span class="comments-title">Comments</span><ul class="field-comments">';
                        comments.forEach(function(comment) {
                            commentHtml += '<li class="field-comment">' + comment.comment + ' (<em style="font-size: 12px;font-weight:bold;">'+ comment.username +'</em>)</li>';
                        });
                        commentHtml += '</ul>';
                        $('.popover-content').html(commentHtml);
                    }
                },
                error: function() {
                    $('.popover-content').html('<div class="error">Error loading comments</div>');
                }
            });
        });

        // Close popover on comment and open comment form
        $('.comment-btn').click(function() {
            $('.popover-content').hide();
            $('.comment-form').show();
            $('.comment-btn, .edit-btn').hide();
        });

        // Close popover on edit and open edit form
        $('.edit-btn').click(function() {
            $('.popover-content').hide();
            $('.edit-form').show();
            $('.comment-btn, .edit-btn').hide();

            if($('.edit-form .edit-input').css('display') == 'none'){
                editInputChange($(this).attr('data-field-type'));
            }

        });

        // Cancel and show popover content
        $('.cancel-btn').click(function(e) {
            e.preventDefault();
            $('.comment-form').hide();
            $('.edit-form').hide();
            $('.popover-content').show();
            $('.comment-btn, .edit-btn').show();
            $(".inputerror").text("");
            $("#addCommentForm input").removeClass("is-invalid");
            $('.input-field').html('');
        });

        // Close popover when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.custom-popover').length && !$(e.target).closest('.fa-info-circle').length) {
                $('.custom-popover').hide();
                $('.comment-form').hide();
                $('.edit-form').hide();
                $('.popover-content').show();
                $('.comment-btn, .edit-btn').show();
                $('.comment-input').val('');
                $(".inputerror").text("");
                $("#addCommentForm input").removeClass("is-invalid");
                $('.input-field').html('');
            }
        });

        // Close popover using close button
        $('.close-popover').click(function(e) {
            e.preventDefault()
            $('.custom-popover').hide();
            $('.comment-form').hide();
            $('.edit-form').hide();
            $('.popover-content').show();
            $('.comment-btn, .edit-btn').show();
            $('.comment-input').val('');
            $(".inputerror").text("");
            $("#addCommentForm input").removeClass("is-invalid");
            $('.input-field').html('');
        });

        $('.submit-comment').on('click', function (e) {
            e.preventDefault();

            let formData = $('#addCommentForm').serializeArray();
            $(".inputerror").text("");
            $("#addCommentForm input").removeClass("is-invalid");

            $("#loader").prepend('<i class="fa fa-spinner fa-spin"></i>');
            $(".submit-comment").attr("disabled", 'disabled');

            $.ajax({
                method: "POST",
                headers: {
                    Accept: "application/json"
                },
                url: "{{ route('add.comment') }}",
                data: formData,
                success: (response) => {
                    $(".fa-spinner").remove();
                    $(".submit-comment").prop("disabled", false);
                    let goTo = '{{route("add.comment.success",":id")}}';
                    goTo = goTo.replace(':id', response.id);
                    window.location.assign(goTo);
                },
                error: (response) => {
                    $(".fa-spinner").remove();
                    $(".submit-comment").prop("disabled", false);

                    if(response.status === 422) {
                        let errors = response.responseJSON.errors;
                        Object.keys(errors).forEach(function (key) {
                            $("[name='" + key + "']").addClass("is-invalid");
                            $("#" + key + "Error").text(errors[key][0]);
                        });
                    } else {
                        window.location.reload();
                    }
                }
            })
        });

        $('.submit-edit').on('click', function (e) {
            e.preventDefault();

            let formData;
            let content_type;
            let process_data;

            if($(this).attr('data-file') == 'true'){
                formData = new FormData(document.getElementById('editForm'));
                content_type = false;
                process_data = false;
            }else{
                formData = $('#editForm').serializeArray();
                process_data = true;
            }
            console.log(formData)

            $(".inputerror").text("");
            $("#editForm input").removeClass("is-invalid");

            $("#loader").prepend('<i class="fa fa-spinner fa-spin"></i>');
            $(".submit-edit").attr("disabled", 'disabled');

            $.ajax({
                method: "POST",
                url: "{{ route('update.lesson.plan.field') }}",
                data: formData,
                contentType: content_type,
                processData: process_data,
                success: (response) => {
                    $(".fa-spinner").remove();
                    $(".submit-edit").prop("disabled", false);
                    let goTo = '{{ route("update.lesson.plan.field.success", ["id" => ":id", "target" => ":target"]) }}';
                    goTo = goTo.replace(':id', response.id);
                    goTo = goTo.replace(':target', response.target);
                    window.location.assign(goTo);
                },
                error: (response) => {
                    $(".fa-spinner").remove();
                    $(".submit-edit").prop("disabled", false);

                    if(response.status === 422) {
                        let errors = response.responseJSON.errors;
                        Object.keys(errors).forEach(function (key) {
                            $("[name='" + key + "']").addClass("is-invalid");
                            $("#" + key + "Error").text(errors[key][0]);
                        });
                    }
                    else if (response.status === 403)
                    {
                        $('#editError').text(response.responseJSON.error)
                    }
                    else {
                        window.location.reload();
                    }
                }
            })

        });

        function adjustPopoverPosition() {
            var $popover = $('.custom-popover');
            var popoverWidth = $popover.outerWidth();
            var popoverHeight = $popover.outerHeight(); // Get popover height
            var windowWidth = $(window).width();
            var windowHeight = $(window).height(); // Get window height
            var leftPos = $popover.offset().left;
            var topPos = $popover.offset().top; // Get popover top position

            // Check if the popover is going out of the right boundary of the viewport
            if (leftPos + popoverWidth > windowWidth) {
                $popover.css('left', windowWidth - popoverWidth - 10); // Adjust the left position
            }

            // Check if the popover is going out of the left boundary of the viewport
            if (leftPos < 0) {
                $popover.css('left', 10); // Adjust the left position
            }

        }

        // Change the input according to field type
        function editInputChange(input_type){
            if (input_type == 'textarea')
            {
                $('.input-field').append(`<textarea name="value" class="form-control border border-2 p-2 edit-input" cols="30" rows="3"></textarea>`)
            }
            else if (input_type == 'text'){
                $('.input-field').append(`<input type="text" name="value" class="form-control border border-2 p-2 edit-input">`)
            }
            else if (input_type == 'file'){
                $('.input-field').append(`<input type="file" name="value" class="form-control border border-2 p-2 edit-input">`)
            }
            else if (input_type == 'number'){
                $('.input-field').append(`<input type="number" name="value" class="form-control border border-2 p-2 edit-input">`)
            }
        }

        $('#submit-for-review').on('click', function(){
            var lesson_id = $(this).data("value");
            var url = '{{route("update.status",":id")}}';
            url = url.replace(':id', lesson_id);
            window.location.assign(url);
        })

        //Add Annex
        $('.btn-submit').on('click', function (e) {
            e.preventDefault();

            let formData = new FormData(document.getElementById('addAnnexForm'));

            let lesson_plan_id = $(this).data("value");
            let url = '{{route("add.annex",":id")}}';
            url = url.replace(':id', lesson_plan_id);

            $(".inputerror").text("");
            $("#addAnnexForm input").removeClass("is-invalid");

            $("#loader").prepend('<i class="fa fa-spinner fa-spin"></i>');
            $(".btn-submit").attr("disabled", 'disabled');

            $.ajax({
                type:'POST',
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    $(".fa-spinner").remove();
                    $(".btn-submit").prop("disabled", false);
                    let goTo = '{{route("add.annex.success",":id")}}';
                    goTo = goTo.replace(':id', response.id);
                    window.location.assign(goTo);
                },
                error: (response) => {
                    $(".fa-spinner").remove();
                    $(".btn-submit").prop("disabled", false);

                    if(response.status === 422) {
                        let errors = response.responseJSON.errors;
                        Object.keys(errors).forEach(function (key) {
                            $("[name='" + key + "']").addClass("is-invalid");
                            $("#" + key + "Error").text(errors[key][0]);
                        });
                    } else {
                        window.location.reload();
                    }
                }
            })
        });

    });
</script>

@include('lesson-plan.step.create')
