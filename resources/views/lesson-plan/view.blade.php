<style>
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
                            <div class="row mb-5">
                                <div class="me-3 my-3 text-end">
                                    <a class="btn bg-gradient-success mb-0 end" id="edit-lesson-plan" data-value="{{ $lesson->id }}">
                                        <i class="material-icons text-sm">edit</i>&nbsp;&nbsp;Edit
                                    </a>
                                    <a class="btn bg-gradient-info mb-0 end" href="{{ route('download.lp', $lesson->id) }}" target="_blank">
                                        {{-- <i class="material-icons text-sm">download</i>&nbsp;&nbsp;Download --}}
                                        <i class="material-icons text-sm">print</i>&nbsp;&nbsp;Print
                                    </a>
                                </div>
                                <div class="col-md-8 d-flex align-items-center">
                                    <h6 class="mb-3">{{ $lesson->topic }}</h6>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 d-flex">
                                    <p class="text-dark font-weight-bold">Subject:</p>&nbsp;
                                    <p class="text-dark">{{ $subject->name }}</p>
                                </div>
                                <div class="col-md-4 d-flex">
                                    <p class="text-dark font-weight-bold">Class:</p>&nbsp;
                                    <p class="text-dark">{{ $lesson->class }}</p>
                                </div>
                                <div class="col-md-4 d-flex">
                                    <p class="text-dark font-weight-bold">No. of Learners:</p>&nbsp;
                                    <p class="text-dark">{{ $lesson->learners_no }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 d-flex">
                                    <p class="text-dark font-weight-bold">Theme:</p>&nbsp;
                                    <p class="text-dark">{{ $lesson->theme }}</p>
                                </div>
                                <div class="col-md-4 d-flex">
                                    <p class="text-dark font-weight-bold">Status:</p>&nbsp;
                                    <p class="text-dark">{{ ucfirst(trans($lesson->status)) }}</p>
                                </div>
                                <div class="col-md-4 d-flex">
                                    <p class="text-dark font-weight-bold">Public:</p>&nbsp;
                                    <p class="text-dark">@if ($lesson->visibility == 1) {{ 'Yes' }} @else {{ 'No' }} @endif</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 d-flex">
                                    <p class="text-dark font-weight-bold">Duration:</p>&nbsp;
                                    <p class="text-dark">{{ Carbon\CarbonInterval::minutes($duration)->cascade()->forHumans()  ?? '' }}</p>
                                </div>
                                <div class="col-md-4 d-flex">
                                    <p class="text-dark font-weight-bold">Owner:</p>&nbsp;
                                    <p class="text-dark">{{ $owner->name }} ({{ $school->name }})</p>
                                </div>
                                <div class="col-md-4 d-flex">
                                    <p class="text-dark font-weight-bold">School Term:</p>&nbsp;
                                    <p class="text-dark">{{ $lesson->term }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 d-flex">
                                    <p class="text-dark font-weight-bold">Competency:</p>&nbsp;
                                    <p class="text-dark">{{ $lesson->competency }}</p>
                                </div>
                                <div class="col-md-4 d-flex">
                                    <p class="text-dark font-weight-bold">Learning Outcomes:</p>&nbsp;
                                    <p class="text-dark">{{ $lesson->learning_outcomes }}</p>
                                </div>
                                <div class="col-md-4 d-flex">
                                    <p class="text-dark font-weight-bold">Generic Skills:</p>&nbsp;
                                    <p class="text-dark">{{ $lesson->generic_skills }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 d-flex">
                                    <p class="text-dark font-weight-bold">Cross-cutting Issues:</p>&nbsp;
                                    <p class="text-dark">{{ $lesson->cross_cutting_issues }}</p>
                                </div>
                                <div class="col-md-4 d-flex">
                                    <p class="text-dark font-weight-bold">Key Learning Outcomes:</p>&nbsp;
                                    <p class="text-dark">{{ $lesson->key_learning_outcomes }}</p>
                                </div>
                                <div class="col-md-4 d-flex">
                                    <p class="text-dark font-weight-bold">Pre-requisite Knowledge:</p>&nbsp;
                                    <p class="text-dark">{{ $lesson->pre_requisite_knowledge }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 d-flex">
                                    <p class="text-dark font-weight-bold">Learning Materials:</p>&nbsp;
                                    <p class="text-dark">{{ $lesson->learning_materials }}</p>
                                </div>
                                <div class="col-md-4 d-flex">
                                    <p class="text-dark font-weight-bold">Learning Methods:</p>&nbsp;
                                    <p class="text-dark">{{ $lesson->learning_methods }}</p>
                                </div>
                                <div class="col-md-4 d-flex">
                                    <p class="text-dark font-weight-bold">References:</p>&nbsp;
                                    <p class="text-dark">{{ $lesson->references }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-1 d-flex">
                                    <p class="text-dark font-weight-bold">Activity Aim:</p>
                                </div>
                                <div class="col-md-8 d-flex">
                                    <p class="text-dark">{{ $lesson->activity_aim }}</p>
                                </div>
                            </div>
                        </div>

                        <ul class="nav nav-tabs mt-5">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#steps-tab">Steps</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#annexes-tab">Annexes</a>
                            </li>
                        </ul>

                        <div class="tab-content mt-2">
                            <div class="tab-pane fade show active" id="steps-tab" role="tabpanel" aria-labelledby="steps-tab">
                                <div class="card-body px-0 pb-2">
                                    @if(count($steps) > 0)
                                        <div class="table-responsive p-0">
                                            <table class="table align-items-center mb-0" id="table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-secondary text-xxl font-weight-bolder px-4">Step</th>
                                                        <th class="text-secondary text-xxl font-weight-bolder">Duration</th>
                                                        <th class="text-secondary text-xxl font-weight-bolder">Teacher Activity</th>
                                                        <th class="text-secondary text-xxl font-weight-bolder">Student Activity</th>
                                                        <th class="text-secondary text-xxl font-weight-bolder">Knowledge/Skills/Values</th>
                                                        <th class="text-secondary text-xxl font-weight-bolder">Output</th>
                                                        <th class="text-secondary text-xxl font-weight-bolder">Assessment Criteria</th>
                                                        <th class="text-secondary text-xxl font-weight-bolder">Notes</th>
                                                        <th class="text-secondary"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($steps as $step)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex flex-column justify-content-center px-2">
                                                                <h6 class="mb-0 text-center text-m">{{ $step->step }}</h6>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <p class="text-m text-center text-dark font-weight-bold mb-0">{{ $step->duration }}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                @if ($step->teacher_activity == null)
                                                                    <i class="material-icons text-center" role="button" style="font-size:40px;opacity:0.4;">person</i>
                                                                @else
                                                                    <i class="material-icons text-center" role="button" title="Header" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="Content" style="font-size:40px;color:#1e4e9c;">person</i>
                                                                    <div class="ripple-container"></div>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                @if ($step->student_activity == null)
                                                                    <i class="material-icons text-center" role="button" style="font-size:40px;opacity:0.4;">group</i>
                                                                @else
                                                                    <i class="material-icons text-center" role="button" style="font-size:40px;color:#1e4e9c;">group</i>
                                                                    <div class="ripple-container"></div>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                @if ( $step->knowledge != null || $step->skills != null || $step->values != null )
                                                                    <i class="material-icons text-center" role="button" style="font-size:40px;color:#1e4e9c;">psychology</i>
                                                                    <div class="ripple-container"></div>
                                                                @else
                                                                    <i class="material-icons text-center" role="button" style="font-size:40px;opacity:0.4;">psychology</i>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                @if ($step->output == null)
                                                                    <i class="material-icons text-center" role="button" style="font-size:40px;opacity:0.4;">output</i>
                                                                @else
                                                                    <i class="material-icons text-center" role="button" style="font-size:40px;color:#1e4e9c;">output</i>
                                                                    <div class="ripple-container"></div>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                @if ($step->assessment_criteria == null)
                                                                    <i class="material-icons text-center" role="button" style="font-size:40px;opacity:0.4;">assignment</i>
                                                                @else
                                                                    <i class="material-icons text-center" role="button" style="font-size:40px;color:#1e4e9c;">assignment</i>
                                                                    <div class="ripple-container"></div>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                @if ($step->facilitator_note == null)
                                                                    <i class="material-icons text-center" role="button" style="font-size:40px;opacity:0.4;">comment</i>
                                                                @else
                                                                    <i class="material-icons text-center" role="button" style="font-size:40px;color:#1e4e9c;">comment</i>
                                                                    <div class="ripple-container"></div>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td class="align-middle not-export-col">
                                                            <a rel="tooltip" class="" data-bs-toggle="modal" data-bs-target="#updateStepModal-{{ $step->id }}" style="cursor:pointer;">
                                                                <i class="material-icons" style="font-size:25px;margin-right:20px;">visibility</i>
                                                                <div class="ripple-container"></div>
                                                            </a>
                                                            <a class="" data-bs-toggle="modal" data-bs-target="#deleteModal-{{$step->id}}" title="Delete Step" style="cursor:pointer;">
                                                                <i class="material-icons" style="font-size:25px;margin-right:20px;">deleteforever</i>
                                                                <div class="ripple-container"></div>
                                                            </a>
                                                        </td>

                                                        <!-- Update Step Modal -->
                                                        <div class="modal fade" id="updateStepModal-{{ $step->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateStepModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h1 class="modal-title fs-5" id="updateStepModalLabel">Update Step</h1>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <form method='POST' action='#' id="updateStepForm-{{ $step->id }}">
                                                                            @csrf
                                                                            <input type="hidden" name="lesson_plan" value="{{ $lesson->id }}">
                                                                            <input type="hidden" name="updated_by" value="{{ auth()->user()->id }}">
                                                                            <div class="row">

                                                                                <div class="mb-3 col-md-6">
                                                                                    <label class="form-label">step</label>
                                                                                    <input type="number" name="step" class="form-control border border-2 p-2" value="{{ $step->step }}">
                                                                                    <p class='text-danger font-weight-bold inputerror' id="stepError"></p>
                                                                                </div>

                                                                                <div class="mb-3 col-md-6">
                                                                                    <label class="form-label">Duration (in minutes)</label>
                                                                                    <input type="number" name="duration" class="form-control border border-2 p-2" value="{{ $step->duration }}">
                                                                                    <p class='text-danger font-weight-bold inputerror' id="durationError"></p>
                                                                                </div>

                                                                                <div class="mb-3 col-md-6">
                                                                                    <label class="form-label">Teacher Activity</label>
                                                                                    <textarea name="teacher_activity" class="form-control border border-2 p-2">{{ $step->teacher_activity }}</textarea>
                                                                                    <p class='text-danger font-weight-bold inputerror' id="teacher_activityError"></p>
                                                                                </div>

                                                                                <div class="mb-3 col-md-6">
                                                                                    <label class="form-label">Student Activity</label>
                                                                                    <textarea name="student_activity" class="form-control border border-2 p-2">{{ $step->student_activity }}</textarea>
                                                                                    <p class='text-danger font-weight-bold inputerror' id="student_activityError"></p>
                                                                                </div>

                                                                                <div class="mb-3 col-md-6">
                                                                                    <label class="form-label">Knowlegde</label>
                                                                                    <textarea name="knowledge" class="form-control border border-2 p-2">{{ $step->knowledge }}</textarea>
                                                                                    <p class='text-danger font-weight-bold inputerror' id="knowledgeError"></p>
                                                                                </div>

                                                                                <div class="mb-3 col-md-6">
                                                                                    <label class="form-label">Skills</label>
                                                                                    <textarea name="skills" class="form-control border border-2 p-2">{{ $step->skills }}</textarea>
                                                                                    <p class='text-danger font-weight-bold inputerror' id="skillsError"></p>
                                                                                </div>

                                                                                <div class="mb-3 col-md-6">
                                                                                    <label class="form-label">Values</label>
                                                                                    <textarea name="values" class="form-control border border-2 p-2">{{ $step->values }}</textarea>
                                                                                    <p class='text-danger font-weight-bold inputerror' id="valuesError"></p>
                                                                                </div>

                                                                                <div class="mb-3 col-md-6">
                                                                                    <label class="form-label">Output</label>
                                                                                    <textarea name="output" class="form-control border border-2 p-2">{{ $step->output }}</textarea>
                                                                                    <p class='text-danger font-weight-bold inputerror' id="outputError"></p>
                                                                                </div>

                                                                                <div class="mb-3 col-md-6">
                                                                                    <label class="form-label">Assessment Criteria</label>
                                                                                    <textarea name="assessment_criteria" class="form-control border border-2 p-2">{{ $step->assessment_criteria }}</textarea>
                                                                                    <p class='text-danger font-weight-bold inputerror' id="assessment_criteriaError"></p>
                                                                                </div>

                                                                                <div class="mb-3 col-md-6">
                                                                                    <label class="form-label">Facilitator Note</label>
                                                                                    <textarea name="facilitator_note" class="form-control border border-2 p-2">{{ $step->facilitator_note }}</textarea>
                                                                                    <p class='text-danger font-weight-bold inputerror' id="facilitator_noteError"></p>
                                                                                </div>

                                                                            </div>
                                                                        </form>
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                        <button type="submit" class="btn btn-success btn-update-step" data-value="{{ $step->id }}">Update Step <span id="loader"></span></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Confirm Step Delete modal -->
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
                                                    </tr>

                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <a class="btn bg-gradient-info btn-floating" id="addBtn" data-bs-toggle="modal" data-bs-target="#addStepModal">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                    @else
                                        <div class="container text-center m-2 p-4">
                                            <p class="font-weight-bold">No Steps Added Yet.</p>

                                            <a class="btn bg-gradient-dark" data-bs-toggle="modal" data-bs-target="#addStepModal">
                                                <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add a Step
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="tab-pane fade" id="annexes-tab" role="tabpanel" aria-labelledby="annexes-tab">
                                <div class="card-body px-0 pb-2">
                                    @if(count($annexes) > 0)
                                        <div class="table-responsive p-0">
                                            <table class="table align-items-center mb-0" id="table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-secondary text-xxl font-weight-bolder px-4">Title</th>
                                                        <th class="text-secondary text-xxl font-weight-bolder">Last Edit</th>
                                                        <th class="text-secondary"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($annexes as $annex)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex flex-column justify-content-center px-2">
                                                                <h6 class="mb-0 text-m">{{ $annex->title }}</h6>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <span class="text-dark text-m font-weight-bold">@if($annex->updated_at != '') {{ $annex->updated_at }} @else {{ $annex->created_at }} @endif</span>
                                                            </div>
                                                        </td>
                                                        <td class="align-middle d-flex not-export-col">
                                                            <a class="" data-bs-toggle="modal" data-bs-target="#updateAnnexModal-{{$annex->id}}" title="Update Annex" style="cursor:pointer;">
                                                                <i class="material-icons" style="font-size:25px;margin-right:20px;">edit</i>
                                                                <div class="ripple-container"></div>
                                                            </a>
                                                            <a href="{{ url('annex/'.$annex->annex_file) }}" style="cursor:pointer;">
                                                                <i class="material-icons" style="font-size:25px;margin-right:20px;">download</i>
                                                                <div class="ripple-container"></div>
                                                            </a>
                                                            <a class="" data-bs-toggle="modal" data-bs-target="#deleteModal-{{$annex->id}}" title="Delete Annex" style="cursor:pointer;">
                                                                <i class="material-icons" style="font-size:25px;margin-right:20px;">close</i>
                                                                <div class="ripple-container"></div>
                                                            </a>
                                                        </td>
                                                    </tr>

                                                    <!-- Confirm Annex Update modal -->
                                                    <div class="modal fade" id="updateAnnexModal-{{ $annex->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateAnnexModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="updateAnnexModalLabel">Update Annex</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="#" id="updateAnnexForm-{{ $annex->id }}" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div class="mb-3 col-md-6">
                                                                            <label class="form-label">Title</label>
                                                                            <input type="text" name="title" class="form-control border border-2 p-2" value="{{ $annex->title }}">
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
                                                                    <button type="submit" class="btn btn-success btn-update-annex" data-value="{{ $annex->id }}">Update Annex <span id="loader"></span></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

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
                                                </tbody>
                                            </table>
                                        </div>

                                        <a class="btn bg-gradient-info btn-floating" id="addBtn" data-bs-toggle="modal" data-bs-target="#addAnnexModal">
                                            <i class="fas fa-plus"></i>
                                        </a>
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
                        </div>
                    </div>
                </div>
            </div>
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

    $(document).on('click','#edit-lesson-plan',function(){
        var lesson_plan_id = $(this).data("value");
        var url = '{{route("get.lesson.plan.update",":id")}}';
        url = url.replace(':id', lesson_plan_id);
        window.location.assign(url);
    });

    $(document).on('click', '#del-btn', function(event) {
        event.preventDefault();
        let href = $(this).data('value');
        window.location.assign(href);
    });

    $(function () {

        $("a.pop-me-over").on("click", function (e) {
            e.preventDefault();
            return true;
        });
        $(".pop-me-over").popover();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

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

        //Update Annex
        $('.btn-update-annex').on('click', function (e) {
            e.preventDefault();

            let annex_id = $(this).data("value");
            let formData = new FormData(document.getElementById('updateAnnexForm-'+annex_id));

            let url = '{{route("update.annex",":id")}}';
            url = url.replace(':id', annex_id);

            $(".inputerror").text("");
            $("#updateAnnexForm-" +annex_id+ " input").removeClass("is-invalid");

            $("#loader").prepend('<i class="fa fa-spinner fa-spin"></i>');
            $(".btn-update-annex").attr("disabled", 'disabled');

            $.ajax({
                type:'POST',
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    $(".fa-spinner").remove();
                    $(".btn-update-annex").prop("disabled", false);
                    let goTo = '{{route("update.annex.success",":id")}}';
                    goTo = goTo.replace(':id', response.id);
                    window.location.assign(goTo);
                },
                error: (response) => {
                    $(".fa-spinner").remove();
                    $(".btn-update-annex").prop("disabled", false);

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

        //Update Step
        $('.btn-update-step').on('click', function (e) {
            e.preventDefault();

            let step_id = $(this).data("value");
            let url = '{{route("update.step",":id")}}';
            url = url.replace(':id', step_id);

            const formId = '#updateStepForm-'+step_id;

            let formData = $(formId).serialize();

            $(".inputerror").text("");
            $(formId+' input').removeClass("is-invalid");

            $("#loader").prepend('<i class="fa fa-spinner fa-spin"></i>');
            $(".btn-update-step").attr("disabled", 'disabled');

            $.ajax({
                type:'POST',
                url: url,
                data: formData,
                success: (response) => {
                    $(".fa-spinner").remove();
                    $(".btn-update-step").prop("disabled", false);
                    let goTo = '{{route("update.step.success",":id")}}';
                    goTo = goTo.replace(':id', response.id);
                    window.location.assign(goTo);
                },
                error: (response) => {
                    $(".fa-spinner").remove();
                    $(".btn-update-step").prop("disabled", false);

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
