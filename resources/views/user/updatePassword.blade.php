@section('styles')
<style>
    .btn-close{
        color: #000;
        background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
    }
    .toggle-password {
        cursor: pointer;
        padding: 0px 10px;
        border-left: none;
        font-size: 18px;
        z-index: 1000;
    }
</style>
@endsection
<!-- Modal -->
<div class="modal fade" id="updatePassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="updatePasswordLabel" style="font-family: var(--bs-body-font-family)!important;">Update User Password</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method='POST' id="updatePasswordForm">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user_id }}">
                    <div class="row">

                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control border border-2 p-2" id="password">
                                <span class="input-group-text">
                                    <i class="toggle-password fa fa-eye" style="padding-right: 15px; font-size: 20px; z-index: 1000;"></i>
                                </span>
                            </div>
                            <p class='text-danger font-weight-bold inputerror' id="passwordError"></p>
                        </div>

                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success btn-submit">Update Password <span id="loader"></span></button>
            </div>
        </div>
    </div>
</div>

<script>

$(function () {

    $('.btn-submit').on('click', function (e) {
        e.preventDefault();

        let formData = $('#updatePasswordForm').serializeArray();
        $(".inputerror").text("");
        $("#updatePasswordForm input").removeClass("is-invalid");

        $("#loader").prepend('<i class="fa fa-spinner fa-spin"></i>');
        $(".btn-submit").attr("disabled", 'disabled');

        $.ajax({
            method: "POST",
            headers: {
                Accept: "application/json"
            },
            url: "{{ route('update.user.password') }}",
            data: formData,
            success: (response) => {
                $(".fa-spinner").remove();
                $(".btn-submit").prop("disabled", false);
                let url = '{{route("update.user.password.success",":id")}}';
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


    $(".toggle-password").click(function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var passwordField = $("#password");
        var passwordFieldType = passwordField.attr("type");
        if (passwordFieldType === "password") {
            passwordField.attr("type", "text");
        } else {
            passwordField.attr("type", "password");
        }
    });
</script>
