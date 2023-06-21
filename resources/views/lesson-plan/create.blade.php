<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <x-navbars.sidebar activePage="lesson-plans"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100 pb-5">
        <!-- Navbar -->
        <x-navbars.topbar titlePage='Lesson Plan'></x-navbars.topbar>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4 mt-2">
            <div class="card card-body mx-3 mx-md-4 ">

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
                        @endif
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="bio-form">
                                <div class="card-header pb-0 p-3">
                                    <div class="row">
                                        <div class="col-md-8 d-flex align-items-center">
                                            <h6 class="mb-3">Preliminary Information</h6>
                                        </div>
                                    </div>
                                </div>
                                <form method='POST' action="#" id="addLessonPlan">
                                    @csrf
                                    <input type="text" name="created_by" value="{{ auth()->user()->id }}" hidden>
                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Choose Owners</label>
                                            <select id="teacher-records" class="form-select border border-2 p-2" name="owner">
                                                <option>Select</option>
                                                @foreach($teachers as $teacher)
                                                    @if (auth()->user()->isTeacher())
                                                        @if (auth()->user()->id == $teacher->id)
                                                            <option value="{{ $teacher->id }}">{!! $teacher->name !!}</option>
                                                        @endif
                                                    @else
                                                        <option value="{{ $teacher->id }}">{!! $teacher->name !!}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <p class='text-danger font-weight-bold inputerror' id="ownerError"></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-3">
                                            @if(@auth()->user()->isAdmin())
                                            <label class="form-label">Status</label>
                                            <select class="form-select border-2 p-2" name="status" aria-label="">
                                                <option value="" selected>Select Status</option>
                                                <option value="edit">Edit</option>
                                                <option value="submitted">Submitted</option>
                                                <option value="reviewed">Reviewed</option>
                                                <option value="approved">Approved</option>
                                                <option value="saved">Saved</option>
                                            </select>
                                            <p class='text-danger font-weight-bold inputerror' id="statusError"></p>
                                            @endif
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            @if (auth()->user()->isAdmin())
                                            <label class="form-label">Public</label>
                                            <select class="form-select border-2 p-2" name="visibility" aria-label="">
                                                <option value="" selected>Select</option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                            <p class='text-danger font-weight-bold inputerror' id="visibilityError"></p>
                                            @endif
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Subject</label>
                                            <select class="form-select border-2 p-2" name="subject" aria-label="">
                                                <option value="" selected>Select Subject</option>
                                                @foreach($subjects as $subject)
                                                <option value="{!! $subject->id !!}">{!! $subject->name !!}</option>
                                                @endforeach
                                            </select>
                                            <p class='text-danger font-weight-bold inputerror' id="subjectError"></p>
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Class</label>
                                            <select class="form-select border-2 p-2" name="class" aria-label="">
                                                <option value="" selected>Select Class</option>
                                                <option value="S1">Senior One</option>
                                                <option value="S2">Senior Two</option>
                                                <option value="S3">Senior Three</option>
                                                <option value="S4">Senior Four</option>
                                                <option value="S5">Senior Five</option>
                                                <option value="S6">Senior Six</option>
                                            </select>
                                            <p class='text-danger font-weight-bold inputerror' id="classError"></p>
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">No. of Learners</label>
                                            <input type="number" name="learners_no" class="form-control border border-2 p-2">
                                            <p class='text-danger font-weight-bold inputerror' id="learners_noError"></p>
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">No. of Female Learners</label>
                                            <input type="number" name="learners_no" class="form-control border border-2 p-2">
                                            <p class='text-danger font-weight-bold inputerror' id="learners_noError"></p>
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">No. of Male Learners</label>
                                            <input type="number" name="learners_no" class="form-control border border-2 p-2">
                                            <p class='text-danger font-weight-bold inputerror' id="learners_noError"></p>
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">School Term</label>
                                            <input type="text" name="term" class="form-control border border-2 p-2">
                                            <p class='text-danger font-weight-bold inputerror' id="termError"></p>
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Theme</label>
                                            <input type="text" name="theme" class="form-control border border-2 p-2">
                                            <p class='text-danger font-weight-bold inputerror' id="themeError"></p>
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Topic</label>
                                            <input type="text" name="topic" class="form-control border border-2 p-2">
                                            <p class='text-danger font-weight-bold inputerror' id="topicError"></p>
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Competency</label>
                                            <input type="text" name="competency" class="form-control border border-2 p-2">
                                            <p class='text-danger font-weight-bold inputerror' id="competencyError"></p>
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Learning outcomes</label>
                                            <textarea name="learning_outcomes" class="form-control border border-2 p-2"></textarea>
                                            <p class='text-danger font-weight-bold inputerror' id="learning_outcomesError"></p>
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Generic Skills</label>
                                            <textarea name="generic_skills" class="form-control border border-2 p-2"></textarea>
                                            <p class='text-danger font-weight-bold inputerror' id="generic_skillsError"></p>
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Values</label>
                                            <textarea name="values" class="form-control border border-2 p-2"></textarea>
                                            <p class='text-danger font-weight-bold inputerror' id="valuesError"></p>
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Cross-cutting Issues</label>
                                            <textarea name="cross_cutting_issues" class="form-control border border-2 p-2"></textarea>
                                            <p class='text-danger font-weight-bold inputerror' id="cross_cutting_issuesError"></p>
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Key learning outcomes</label>
                                            <textarea name="key_learning_outcomes" class="form-control border border-2 p-2"></textarea>
                                            <p class='text-danger font-weight-bold inputerror' id="key_learning_outcomesError"></p>
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Pre-requisite Knowledge</label>
                                            <textarea name="pre_requisite_knowledge" class="form-control border border-2 p-2"></textarea>
                                            <p class='text-danger font-weight-bold inputerror' id="pre_requisite_knowledgeError"></p>
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Learning materials</label>
                                            <textarea name="learning_materials" class="form-control border border-2 p-2"></textarea>
                                            <p class='text-danger font-weight-bold inputerror' id="learning_materialsError"></p>
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Learning methods</label>
                                            <textarea name="learning_methods" class="form-control border border-2 p-2"></textarea>
                                            <p class='text-danger font-weight-bold inputerror' id="learning_methodsError"></p>
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">References</label>
                                            <textarea name="references" class="form-control border border-2 p-2"></textarea>
                                            <p class='text-danger font-weight-bold inputerror' id="referencesError"></p>
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Activity Aim</label>
                                            <textarea name="activity_aim" class="form-control border border-2 p-2"></textarea>
                                            <p class='text-danger font-weight-bold inputerror' id="activity_aimError"></p>
                                        </div>

                                    </div>
                                    <button type="submit" class="btn bg-gradient-dark btn-submit">Start Lesson Plan <span id="loader"></span></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>

<script>
$(document).ready(function() {
    $('#teacher-records').select2();
});

$(function () {

    $('.btn-submit').on('click', function (e) {
        e.preventDefault();

        let formData = $('#addLessonPlan').serializeArray();
        $(".inputerror").text("");
        $("#addLessonPlan input").removeClass("is-invalid");
        $("#addLessonPlan select").removeClass("is-invalid");
        $("#addLessonPlan textarea").removeClass("is-invalid");

        $("#loader").prepend('<i class="fa fa-spinner fa-spin"></i>');
        $(".btn-submit").attr("disabled", 'disabled');

        $.ajax({
            method: "POST",
            headers: {
                Accept: "application/json"
            },
            url: "{{ route('create.lesson.plan') }}",
            data: formData,
            success: (response) => {
                $(".fa-spinner").remove();
                $(".btn-submit").prop("disabled", false);
                let url = '{{route("create.lesson.plan.success",":id")}}';
                url = url.replace(':id', response.id);
                window.location.assign(url);
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
})
</script>
