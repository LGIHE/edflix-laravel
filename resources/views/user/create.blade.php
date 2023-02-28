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
<div class="modal fade" id="newUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="newUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="newUserModalLabel">Add New User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method='POST' action='#' id="addUserForm">
                    @csrf
                    <div class="row">

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control border border-2 p-2">
                            <p class='text-danger font-weight-bold inputerror' id="nameError"></p>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control border border-2 p-2">
                            <p class='text-danger font-weight-bold inputerror' id="emailError"></p>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control border border-2 p-2">
                            <p class='text-danger font-weight-bold inputerror' id="phoneError"></p>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-control border border-2 p-2">
                            <p class='text-danger font-weight-bold inputerror' id="locationError"></p>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Role</label>
                            <select class="form-select" name="role" aria-label="">
                                <option selected>Select User Role</option>
                                <option value="Administrator">System Admin</option>
                                <option value="Facilitator">Facilitator</option>
                                <option value="Teacher">Teacher</option>
                            </select>
                            <p class='text-danger font-weight-bold inputerror' id="roleError"></p>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control border border-2 p-2">
                            <p class='text-danger font-weight-bold inputerror' id="passwordError"></p>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">School</label>
                            <select class="form-select border border-2 p-2" name="school" aria-label="">
                                <option value="" selected>Select School</option>
                                @foreach($schools as $school)
                                <option value="{!! $school->id !!}">{!! $school->name !!}</option>
                                @endforeach
                            </select>
                            <p class='text-danger font-weight-bold inputerror' id="schoolError"></p>
                        </div>

                        <div class="mb-3 col-md-3"></div>

                        <div class="mb-3 col-md-4">
                            <label class="form-label subject-1">Subject 1</label>
                            <select class="form-select border-2 p-2" name="subject_1" aria-label="">
                                <option value="" selected>Select Subject</option>
                                @foreach($subjects as $subject)
                                <option value="{!! $subject->id !!}">{!! $subject->name !!}</option>
                                @endforeach
                            </select>
                            <p class='text-danger font-weight-bold inputerror' id="subject_1Error"></p>
                        </div>

                        <div class="mb-3 col-md-4">
                            <label class="form-label subject-2">Subject 2</label>
                            <select class="form-select border-2 p-2" name="subject_2" aria-label="">
                                <option value="" selected>Select Subject</option>
                                @foreach($subjects as $subject)
                                <option value="{!! $subject->id !!}">{!! $subject->name !!}</option>
                                @endforeach
                            </select>
                            <p class='text-danger font-weight-bold inputerror' id="subject_2Error"></p>
                        </div>

                        <div class="mb-3 col-md-4">
                            <label class="form-label subject-3">Subject 3</label>
                            <select class="form-select" name="subject_3" aria-label="">
                                <option value="" selected>Select Subject</option>
                                @foreach($subjects as $subject)
                                <option value="{!! $subject->id !!}">{!! $subject->name !!}</option>
                                @endforeach
                            </select>
                            <p class='text-danger font-weight-bold inputerror' id="subject_3Error"></p>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success btn-submit">Add User</button>
            </div>
        </div>
    </div>
</div>

<script>

$(function () {

    $('.btn-submit').on('click', function (e) {
        e.preventDefault();

        let formData = $('#addUserForm').serializeArray();
        $(".inputerror").text("");
        $("#addUserForm input").removeClass("is-invalid");

        $("#loader").prepend('<i class="fa fa-spinner fa-spin"></i>');
        $(".btn-submit").attr("disabled", 'disabled');

        $.ajax({
            method: "POST",
            headers: {
                Accept: "application/json"
            },
            url: "{{ route('create-user') }}",
            data: formData,
            success: () => {
                $(".fa-spinner").remove();
                $(".btn-submit").prop("disabled", false);
                window.location.assign("{{ route('user.create.success') }}");
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
