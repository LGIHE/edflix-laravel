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
<div class="modal fade" id="addCommentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addCommentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addCommentModalLabel">Add Comment</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method='POST' action='#' id="addCommentForm">
                    @csrf
                    <input type="hidden" name="lesson_plan" value="{{ $lesson->id }}">
                    <input type="hidden" name="user" value="{{ auth()->user()->id }}">
                    <div class="row">

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Target</label>
                            <select class="form-select border-2 p-2" name="target" id="target">
                                <option value="" selected>Select Target</option>
                                <option value="pleriminary">Pleriminary Information</option>
                                <option value="step">Step</option>
                                <option value="annex">Annex</option>
                            </select>
                            <p class='text-danger font-weight-bold inputerror' id="targetError"></p>
                        </div>

                        <div class="mb-3 col-md-6" style="display:none;" id="steps">
                            <label class="form-label">Choose Step</label>
                            <select class="form-select border-2 p-2" name="step">
                                <option value="" selected>Select Step</option>
                                @foreach($steps as $step)
                                    <option value="{!! $step->id !!}">Step {!! $step->step !!}</option>
                                @endforeach
                            </select>
                            <p class='text-danger font-weight-bold inputerror' id="stepError"></p>
                        </div>

                        <div class="mb-3 col-md-6" style="display:none;" id="annexes">
                            <label class="form-label">Choose Annex</label>
                            <select class="form-select border-2 p-2" name="annex">
                                <option value="" selected>Select Annex</option>
                                @foreach($annexes as $annex)
                                    <option value="{!! $annex->id !!}">{!! $annex->title !!}</option>
                                @endforeach
                            </select>
                            <p class='text-danger font-weight-bold inputerror' id="annexError"></p>
                        </div>

                        <div class="mb-3 col-md-6" style="display:none;" id="ple-info">
                            <label class="form-label">Choose Field</label>
                            <select class="form-select border-2 p-2" name="pleriminary">
                                <option value="" selected>Select Field</option>
                                <option value="Theme">Theme</option>
                                <option value="Topic">Topic</option>
                                <option value="Competency">Competency</option>
                                <option value="Learning outcomes">Learning outcomes</option>
                                <option value="Generic Skills">Generic Skills</option>
                                <option value="Values">Values</option>
                                <option value="Cross-cutting Issues">Cross-cutting Issues</option>
                                <option value="Key Learning Outcomes">Key Learning Outcomes</option>
                                <option value="Pre-requisite Knowledge">Pre-requisite Knowledge</option>
                                <option value="Learning Materials">Learning Materials</option>
                                <option value="Learning Methods">Learning Methods</option>
                                <option value="References">References</option>
                                <option value="Activity Aim">Activity Aim</option>
                            </select>
                            <p class='text-danger font-weight-bold inputerror' id="pleriminaryError"></p>
                        </div>

                        <div class="mb-3 col-md-9">
                            <label class="form-label">Comment</label>
                            <textarea name="comment" class="form-control border border-2 p-2"></textarea>
                            <p class='text-danger font-weight-bold inputerror' id="commentError"></p>
                        </div>

                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success comment-btn">Add Comment <span id="loader"></span></button>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function() {
        $('#target').change(function() {
            if($(this).val() === "pleriminary"){
                $('#ple-info').show();
                $('#steps').hide();
                $('#annexes').hide();
            }
            else if($(this).val() === "step"){
                $('#steps').show();
                $('#ple-info').hide();
                $('#annexes').hide();
            }
            else if($(this).val() === "annex"){
                $('#annexes').show();
                $('#steps').hide();
                $('#ple-info').hide();
            }
            else{
                $('#ple-info').hide();
                $('#steps').hide();
                $('#annexes').hide();
            }

        });
    });

$(function () {

    $('.comment-btn').on('click', function (e) {
        e.preventDefault();

        let formData = $('#addCommentForm').serializeArray();
        $(".inputerror").text("");
        $("#addCommentForm input").removeClass("is-invalid");

        $("#loader").prepend('<i class="fa fa-spinner fa-spin"></i>');
        $(".comment-btn").attr("disabled", 'disabled');

        $.ajax({
            method: "POST",
            headers: {
                Accept: "application/json"
            },
            url: "{{ route('add.comment') }}",
            data: formData,
            success: (response) => {
                $(".fa-spinner").remove();
                $(".comment-btn").prop("disabled", false);
                let goTo = '{{route("add.comment.success",":id")}}';
                goTo = goTo.replace(':id', response.id);
                window.location.assign(goTo);
            },
            error: (response) => {
                $(".fa-spinner").remove();
                $(".comment-btn").prop("disabled", false);

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
