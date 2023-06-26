<style>
/* .comment {
    width: 80%;
} */

@media (max-width: 767px) {
  .comment {
    width: 100%;
  }
}
</style>
@foreach ($comments as $comment)
<div class="card mb-5 comment">
    <h6 class="card-header" style="padding-bottom: 0!important;">For:
        @if ($comment->commentable_type == "pleriminary")
            {{ ucfirst($comment->commentable_type) }} Information
        @else
            {{ ucfirst($comment->commentable_type) }}
        @endif - {{ $comment->commentable }}</h6>
    <div class="card-body" style="padding: 0 1.5rem;">
        @php
            $user = App\Http\Controllers\UserController::findUser($comment->user);
        @endphp
        <p><strong>From: {{ $user->name }} ({{ $user->role }})</strong></p>

        <p>{{ $comment->comment }}</p>

        <div class="justify-content-md-end" id="reply-form" style="display:none;">
            <form action="#" id="addCommentForm">
                @csrf
                <input type="hidden" name="user" value="{{ auth()->user()->id }}">
                <input type="hidden" name="lesson_plan" value="{{ $lesson->id }}">
                <input type="hidden" name="comment" value="{{ $comment->id }}">

                <div class="mb-3 col-md-9">
                    <label class="form-label">Reply</label>
                    <textarea name="reply" id="reply" cols="10" rows="3" class="form-control border border-2 p-2 w-50"></textarea>
                    <p class='text-danger font-weight-bold inputerror' id="replyError"></p>
                </div>
            </form>
            <button type="submit" class="btn btn-success reply-btn" data-value="">Reply<span id="loader"></span></button>
            <button type="button" class="btn btn-danger" id="reply-close">Cancel</button>
        </div>
        @if (count($replies) > 0)
        <hr>
            <div id="replies">
                <p><strong><em>Replies:</em></strong></p>

                @foreach ($replies as $reply)
                    <div class="reply-content">
                        <p><strong><em>Abigaba Abel (Teacher)</em></strong></p>
                        <p>Overall, an excellent lesson plan that promotes student engagement and achievement.</p>
                    </div>
                @endforeach
            </div>
        @endif
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button class="btn btn-outline-info btn-sm me-md-2" id="reply-show" type="button">Reply</button>
            <button class="btn btn-outline-success btn-sm me-md-2" type="button">Mark as Done</button>
        </div>
    </div>
</div>
@endforeach

<script>
    $(document).ready(function() {
        $('#reply-show').click(function() {
            $('#reply-form').show();
        });

        $('#reply-close').click(function() {
            $('#reply-form').hide();
            $('#reply').val('');
        });
    });

    $(function () {

$('.reply-btn').on('click', function (e) {
    e.preventDefault();

    let formData = $('#addReplyForm').serializeArray();
    $(".inputerror").text("");
    $("#addReplyForm input").removeClass("is-invalid");

    $("#loader").prepend('<i class="fa fa-spinner fa-spin"></i>');
    $(".reply-btn").attr("disabled", 'disabled');

    $.ajax({
        method: "POST",
        headers: {
            Accept: "application/json"
        },
        url: "{{ route('add.reply') }}",
        data: formData,
        success: (response) => {
            $(".fa-spinner").remove();
            $(".reply-btn").prop("disabled", false);
            let goTo = '{{route("add.reply.success",":id")}}';
            goTo = goTo.replace(':id', response.id);
            window.location.assign(goTo);
        },
        error: (response) => {
            $(".fa-spinner").remove();
            $(".reply-btn").prop("disabled", false);

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
