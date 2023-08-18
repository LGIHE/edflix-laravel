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
        padding: 10px 0;
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
        display: none!important;
        padding-top: 5px!important;
        color: #1a73e8d1!important;
    }

    .popover-container:hover .info-popover,
    .info-popover.show {
        display: inline-block!important;
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
                            <div class="col-auto text-end">
                                <a class="btn bg-gradient-info mb-0 end" href="{{ route('download.lp', $lesson->id) }}" target="_blank">
                                    <i class="material-icons text-sm">download</i>&nbsp;&nbsp;Download
                                </a>
                            </div>
                        </div>

                        <div>
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#pre-tab">Lesson Plan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#comments-tab">Review Comments</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#timeline-tab">Review Timeline</a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content mt-2">
                            <div class="tab-pane fade show active" id="pre-tab" role="tabpanel" aria-labelledby="steps-tab">
                                <div class="card-body px-0 pb-2">
                                    <div class="m-4">
                                        <div class="row">
                                            <div class="col-md-6 d-flex popover-container">
                                                <p class="text-dark font-weight-bold">School:</p>&nbsp;
                                                <p class="text-dark">{{ $school->name }}</p>&nbsp;
                                                <a href="#" data-toggle="popover" data-title="School Name" data-content="No review Comments">
                                                    <i class="fa fa-info-circle info-popover" id="school-info"></i>
                                                </a>
                                            </div>
                                            <div class="col-md-6 d-flex popover-container">
                                                <p class="text-dark font-weight-bold">Teacher:</p>&nbsp;
                                                <p class="text-dark">{{ $owner->name }}</p>&nbsp;
                                                <a href="#" data-toggle="popover" data-title="Teacher" data-content="No review comments.">
                                                    <i class="fa fa-info-circle info-popover" id="owner-info"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 d-flex">
                                                <p class="text-dark font-weight-bold">Class:</p>&nbsp;
                                                <p class="text-dark">{{ $lesson->class }}</p>
                                            </div>
                                            <div class="col-md-6 d-flex">
                                                <p class="text-dark font-weight-bold">Subject:</p>&nbsp;
                                                <p class="text-dark">{{ $subject->name }}</p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 d-flex">
                                                <p class="text-dark font-weight-bold">Topic:</p>&nbsp;
                                                <p class="text-dark">{{ $lesson->topic }}</p>
                                            </div>
                                            <div class="col-md-6 d-flex">
                                                <p class="text-dark font-weight-bold">Theme:</p>&nbsp;
                                                <p class="text-dark">{{ $lesson->theme }}</p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 d-flex">
                                                <p class="text-dark font-weight-bold">Number of learners:</p>&nbsp;
                                                <p class="text-dark">
                                                    {{ $lesson->learners_no }}
                                                    (<strong>Female: </strong>{{ $lesson->female_learners }} <strong>Male: </strong>{{ $lesson->male_learners }})
                                                </p>
                                            </div>
                                            <div class="col-md-6 d-flex">
                                                <p class="text-dark font-weight-bold">Duration:</p>&nbsp;
                                                <p class="text-dark">{{ Carbon\CarbonInterval::minutes($duration)->cascade()->forHumans() ?? '' }}</p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 d-flex">
                                                <p class="text-dark font-weight-bold">Term:</p>&nbsp;
                                                <p class="text-dark">{{ $lesson->term }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="m-4 text-dark">
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
                                </div>

                                <div class="card-body px-0 pb-2">
                                    @if(count($steps) > 0)
                                        @if(count($steps) > 1)
                                            <h2 style="margin-left: 20px;"><strong>Steps</strong></h2>
                                        @else
                                            <h2 style="margin-left: 20px;"><strong>Step</strong></h2>
                                        @endif

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
                                                <tr style="height: 33pt">
                                                    <td class="column" style="width:75pt; border: 1px solid black;">
                                                        <p class="s2 column-head" style="margin-left: 10px;">Step
                                                            {{ $step->step }}<br>@if($step->duration < 2) - @else{{ Carbon\CarbonInterval::minutes($step->duration)->cascade()->forHumans() ?? '' }}@endif
                                                        </p>
                                                    </td>
                                                    <td class="column" style="width: 150pt; border: 1px solid black;">
                                                        <p class="s2 column-head" style="margin-left: 10px;">{{ $step->teacher_activity }}</p>
                                                    </td>
                                                    <td class="column" style="width: 113pt; border: 1px solid black;">
                                                        <p class="s2 column-head" style="margin-left: 10px;">{{ $step->student_activity }}</p>
                                                    </td>
                                                    <td class="column" style="width: 111pt; border: 1px solid black;">
                                                        <p class="s2 column-head" style="margin-left: 10px;">
                                                            <strong>Knowledge: </strong>{{ $step->knowledge }}<br>
                                                            <strong>Values: </strong>{{ $step->values }}<br>
                                                            <strong>Skills: </strong>{{ $step->skills }}
                                                        </p>
                                                    </td>
                                                    <td class="column" style="width: 149pt; border: 1px solid black;">
                                                        <p class="s2 column-head" style="margin-left: 10px;">{{ $step->output }}</p>
                                                    </td>
                                                    <td class="column" style="width: 149pt; border: 1px solid black;margin-left: 10px;">
                                                        <p class="s2 column-head">{{ $step->assessment_criteria }}</p>
                                                    </td>
                                                </tr>
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
                                            @if(count($annexes) > 1)
                                                <h2 style="margin-left: 20px;"><strong>Annexes</strong></h2>
                                            @else
                                                <h2 style="margin-left: 20px;"><strong>Annex</strong></h2>
                                            @endif
                                            @foreach ($annexes as $annex)
                                                @if (Str::endsWith($annex->annex_file, ['.jpg', '.jpeg', '.png']))
                                                    <table class="mt-4" style="border-collapse: collapse; margin-left:20pt; border: 2px black solid" cellspacing="0">

                                                        <tr style="height: 33pt; border: 1px black solid">
                                                            <td class="column text-dark" style="width: 150pt;">
                                                                <p class="s2 column-head" style="font-size:20px;">{{ $annex->title }}</p>
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 33pt">
                                                            <td class="column" style="width: 150pt;">
                                                                <img src="{{ url('/annex/' . $annex->annex_file) }}" alt="{{ $annex->title }}" width="1000"
                                                                    height="600">
                                                            </td>
                                                        </tr>

                                                    </table>
                                                    <br>
                                                @endif
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

                            <div class="tab-pane fade" id="comments-tab" role="tabpanel" aria-labelledby="annexes-tab">
                                <div class="card-body px-0 pb-2">
                                    @if (count($comments) > 0)
                                        @include('lesson-plan.comments.capsule')
                                        <a class="btn bg-gradient-info btn-floating" id="addBtn" data-bs-toggle="modal" data-bs-target="#addCommentModal">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                    @else
                                        <div class="container text-center m-2 p-4">
                                            <p class="font-weight-bold">No Review Comments Added Yet.</p>
                                            <a class="btn bg-gradient-dark" data-bs-toggle="modal" data-bs-target="#addCommentModal">
                                                <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add a Review Comment
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="tab-pane fade" id="timeline-tab" role="tabpanel" aria-labelledby="annexes-tab">
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
        <h5 class="custom-popover-header">Popover Header</h5>
        <div class="custom-popover-body">Some content inside the popover</div>
        <div class="popover-btn">
            <button class="btn btn-info mb-0 comment-button" style="margin-left: 15px;">Comment</button>
            <button class=" btn btn-success mb-0 edit-button">Edit</button>
        </div>
    </div>

</x-layout>

<script>
    document.querySelectorAll('.info-popover').forEach(function (element) {
        element.addEventListener('click', function (e) {
            e.preventDefault();
            var popover = document.querySelector('.custom-popover');

            // Hide any open popover
            var popover = document.querySelector('.custom-popover');
            popover.style.display = 'none';

            // Get the title and content from data attributes
            var title = e.target.parentElement.getAttribute('data-title');
            var content = e.target.parentElement.getAttribute('data-content');

            // Update the popover content
            popover.querySelector('.custom-popover-header').innerText = title;
            // popover.querySelector('.custom-popover-body').innerText = content;
            popover.querySelector('.custom-popover-body').innerHTML = `
                <h4>Hello</h4>
            `;

            // Get the position of the icon
            var rect = e.target.getBoundingClientRect();

            // Position the popover
            popover.style.left = rect.right + 'px';
            popover.style.top = rect.top + 'px';

            // Toggle the display
            popover.style.display = (popover.style.display === 'block') ? 'none' : 'block';

            // Keep the icon visible
            e.target.classList.add('show');
        });
    });

    // Optional: Hide the popover when clicking outside
    window.addEventListener('click', function (e) {
        var popover = document.querySelector('.custom-popover');
        if (e.target.closest('.info-popover') === null && e.target.closest('.custom-popover') === null) {
            popover.style.display = 'none';
        }
    });

    document.querySelectorAll('.popover-container').forEach(function (element) {
        element.addEventListener('mouseenter', function (e) {
            e.preventDefault();
            var iconLink = e.target.querySelector('.info-popover');
            iconLink.classList.add('show');
        })

        element.addEventListener('mouseleave', function (e) {
            e.preventDefault();
            var iconLink = e.target.querySelector('.info-popover');
            var popover = document.querySelector('.custom-popover');

            if (popover.classList.contains('show')) { // Check if the popover has the 'show' class
                iconLink.classList.add('show');
            } else {
                iconLink.classList.remove('show');
            }
        })

    })

    document.querySelectorAll('.comment-button').forEach(function(element) {
        element.addEventListener('click', function(e){
            e.preventDefault();
            var popoverContainer = e.target.closest('.custom-popover');
            var header = popoverContainer.querySelector('.custom-popover-header');
            popoverContainer.querySelector('.popover-btn').style.display = 'none';
            popoverContainer.querySelector('.custom-popover-body').innerHTML = `
                <form>
                    <div class="">
                        <label class="form-label">Comment on `+header.innerText+`</label>
                        <input type="text" name="comment" class="form-control border border-2 p-2">
                        <p class='text-danger font-weight-bold inputerror' id="titleError"></p>
                    </div>
                    <button type="submit" class="btn btn-success btn-update-annex" data-value="{{ $step->id }}">Comment <span id="loader"></span></button>
                    <button type="button" class="btn btn-danger popover-cancel-comment-btn">Cancel</button>
                </form>
            `;
        })
    });

    document.querySelectorAll('.edit-button').forEach(function(element) {
        element.addEventListener('click', function(e){
            e.preventDefault();
            var popoverContainer = e.target.closest('.custom-popover');
            var text = popoverContainer.querySelector('.custom-popover-header');
            console.log('Edit Button for ' + text.innerText + ' clicked');
        })
    });

    document.querySelector('.popover-cancel-comment-btn').addEventListener('click', function(){
        var popoverContainer = e.target.closest('.custom-popover');
        popoverContainer.querySelector('.popover-btn').style.display = 'block';
    });

</script>
