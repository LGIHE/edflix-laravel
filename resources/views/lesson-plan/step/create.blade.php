<style>
    .btn-close{
        color: #000;
        background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
    }

    #newUserModalLabel {
        font-family: var(--bs-body-font-family)!important;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="addStepModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addStepModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addStepModalLabel">Add New Step</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method='POST' action='#' id="addStepForm">
                    @csrf
                    <input type="hidden" name="lesson_plan" value="{{ $lesson->id }}">
                    <input type="hidden" name="created_by" value="{{ auth()->user()->id }}">
                    <div class="row">

                        <div class="mb-3 col-md-6">
                            <label class="form-label">step</label>
                            <input type="number" name="step" class="form-control border border-2 p-2">
                            <p class='text-danger font-weight-bold inputerror' id="stepError"></p>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Duration (in minutes)</label>
                            <input type="number" name="duration" class="form-control border border-2 p-2">
                            <p class='text-danger font-weight-bold inputerror' id="durationError"></p>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Teacher Activity</label>
                            <textarea name="teacher_activity" class="form-control border border-2 p-2"></textarea>
                            <p class='text-danger font-weight-bold inputerror' id="teacher_activityError"></p>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Student Activity</label>
                            <textarea name="student_activity" class="form-control border border-2 p-2"></textarea>
                            <p class='text-danger font-weight-bold inputerror' id="student_activityError"></p>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Knowlegde</label>
                            <textarea name="knowledge" class="form-control border border-2 p-2"></textarea>
                            <p class='text-danger font-weight-bold inputerror' id="knowledgeError"></p>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Skills</label>
                            <textarea name="skills" class="form-control border border-2 p-2"></textarea>
                            <p class='text-danger font-weight-bold inputerror' id="skillsError"></p>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Values</label>
                            <textarea name="values" class="form-control border border-2 p-2"></textarea>
                            <p class='text-danger font-weight-bold inputerror' id="valuesError"></p>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Output</label>
                            <textarea name="output" class="form-control border border-2 p-2"></textarea>
                            <p class='text-danger font-weight-bold inputerror' id="outputError"></p>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Assessment Criteria</label>
                            <textarea name="assessment_criteria" class="form-control border border-2 p-2"></textarea>
                            <p class='text-danger font-weight-bold inputerror' id="assessment_criteriaError"></p>
                        </div>

                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success btn-submit">Add Step <span id="loader"></span></button>
            </div>
        </div>
    </div>
</div>

<script>

$(function () {

    $('.btn-submit').on('click', function (e) {
        e.preventDefault();

        let formData = $('#addStepForm').serializeArray();
        $(".inputerror").text("");
        $("#addStepForm input").removeClass("is-invalid");

        $("#loader").prepend('<i class="fa fa-spinner fa-spin"></i>');
        $(".btn-submit").attr("disabled", 'disabled');

        $.ajax({
            method: "POST",
            headers: {
                Accept: "application/json"
            },
            url: "{{ route('add.step') }}",
            data: formData,
            success: (response) => {
                $(".fa-spinner").remove();
                $(".btn-submit").prop("disabled", false);
                let goTo = '{{route("add.step.success",":id")}}';
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
})
</script>
