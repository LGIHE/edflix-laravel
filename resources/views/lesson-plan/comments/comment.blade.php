<style>
/* .comment {
    width: 80%;
} */

    #show-replies p {
        font-weight: 600;
        font-style: italic;
        color: green;
    }

    #show-replies, #hide-replies {
        cursor: pointer;
    }

    #hide-replies p {
        font-weight: 600;
        font-style: italic;
        color: red;
    }

    .card-header {
        font-size: 14px;
        font-weight: 800;
    }

    .commentor {
        font-size: 14px;
        font-weight: 800;
    }

    .comment,
    #show-replies p,
    #hide-replies p,
    #replies p,
    .reply-content p {
        font-size: 14px;
    }

    .card-header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header {
        margin-right: auto; /* Pushes the "X" to the right */
    }
</style>

<div>
    <form id="filter-form" style="padding-left: 10px;">
        <label class="form-label">Filter Review Comments</label>
        <select class="form-select border-2 p-1 w-30" name="filter" id="filter-select">
            <option  value="newest" {{ request('filter') === 'newest' ? 'selected' : '' }}>Newest</option>
            <option value="oldest" {{ request('filter') === 'oldest' ? 'selected' : '' }}>Oldest</option>
            <option value="complete" {{ request('filter') === 'complete' ? 'selected' : '' }}>Complete</option>
            <option value="incomplete" {{ request('filter') === 'incomplete' ? 'selected' : '' }}>Incomplete</option>
        </select>
    </form>
</div>

<div>
    @foreach ($comments as $comment)
        <div class="card mb-3 mx-2 w-95 comment">
            <div class="card-header-container">
                <span class="card-header pt-3 pb-0 px-3">
                    For:
                    @if ($comment->commentable_type == "pleriminary")
                        {{ ucfirst($comment->commentable_type) }} Information
                    @else
                        {{ ucfirst($comment->commentable_type) }}
                    @endif
                    -
                    @if ($comment->commentable_type == "step")
                        {{ $comment->commentable }} ({{ $comment->target_field }})
                    @else
                        {{ $comment->commentable }}
                    @endif
                </span>
                @if (auth()->user()->isAdmin() || $comment->user == auth()->user()->id)
                    <a href="{{ route('delete.comment', $comment->id) }}">
                        <span class="text-danger" style="margin-right: 12px;font-weight:bold;">
                            <strong><i class="material-icons text-l mt-2">cancel</i></strong>
                        </span>
                    </a>
                @endif
            </div>
            <div class="card-body" style="padding: 0 1rem;">
                @php
                    $user = App\Http\Controllers\UserController::findUser($comment->user);
                @endphp
                <p class="commentor"><strong>From: {{ $user->name }} ({{ $user->role }})</strong></p>

                <p class="comment">{{ $comment->comment }}</p>

                <div class="justify-content-md-end" id="edit-comment-form-{{ $comment->id }}" style="display:none;">
                    <form action="#" id="editCommentForm-{{ $comment->id }}">
                        <input type="hidden" name="_token" id="csrf-token-{{ $comment->id }}" value="{{ csrf_token() }}">
                        <input type="hidden" name="lesson_plan" value="{{ $comment->lesson_plan }}">
                        <input type="hidden" name="id" value="{{ $comment->id }}">
                        <input type="hidden" name="user" value="{{ $comment->user }}">

                        <div class="mb-3">
                            <label class="form-label">Edit Comment</label>
                            <textarea name="comment" id="comment-{{ $comment->id }}" cols="10" rows="3" class="form-control border border-2 p-2 w-100">{{ $comment->comment }}</textarea>
                            <p class='text-danger font-weight-bold inputerror' id="comment-{{ $comment->id }}-Error"></p>
                        </div>
                    </form>
                    <button type="submit" class="btn btn-success edit-comment-btn"  data-id="{{ $comment->id }}">Edit<span id="loader"></span></button>
                    <button type="button" class="btn btn-danger" id="edit-comment-close-{{ $comment->id }}" onclick="closeEditComment({{ $comment->id }})">Cancel</button>
                </div>

                <div class="justify-content-md-end" id="reply-form" style="display:none;">
                    <form action="#" id="addReplyForm">
                        @csrf
                        <input type="hidden" name="user" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="lesson_plan" value="{{ $lesson->id }}">
                        <input type="hidden" name="comment" value="{{ $comment->id }}">

                        <div class="mb-3">
                            <label class="form-label">Reply</label>
                            <textarea name="reply" id="reply" cols="10" rows="3" class="form-control border border-2 p-2 w-100"></textarea>
                            <p class='text-danger font-weight-bold inputerror' id="replyError"></p>
                        </div>
                    </form>
                    <button type="submit" class="btn btn-success reply-btn" data-value="">Reply<span id="loader"></span></button>
                    <button type="button" class="btn btn-danger" id="reply-close">Cancel</button>
                </div>
                @if (count($replies) > 0)
                <a id="show-replies"><p>View Replies</p></a>
                <a id="hide-replies" style="display:none;"><p>Hide Replies</p></a>
                <hr>
                    <div id="replies" style="display: none;">
                        <p><strong><em>Replies:</em></strong></p>

                        @foreach ($replies as $reply)
                            @php
                                $replier = App\Http\Controllers\UserController::findUser($reply->user);
                            @endphp
                            <div class="reply-content">
                                <p style="margin-bottom: 0;"><strong><em>{{ $replier->name }} ({{ $replier->role }})</em></strong></p>
                                <p >{{ $reply->reply }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="d-grid gap-1 d-md-flex justify-content-md-end">
                    @if ($comment->user == auth()->user()->id)
                        <button class="btn btn-outline-danger btn-sm me-md-2" id="edit-show" type="button" onclick="showEditComment('{{ $comment->id }}')">Edit</button>
                    @endif
                    <button class="btn btn-outline-info btn-sm me-md-2" id="reply-show" type="button">Reply</button>
                    @if($comment->is_done == 0)
                        <button class="btn btn-outline-success btn-sm me-md-2" type="button" id="done-btn" data-value="{{ route('mark.done', $comment->id) }}">Mark as Done</button>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>

<script>
    $(document).on('click', '#done-btn', function(event) {
        event.preventDefault();
        let href = $(this).data('value');
        window.location.assign(href);
    });

    $(document).ready(function() {
        $('#show-replies').click(function() {
            $('#replies').show();
            $('#hide-replies').show();
            $('#show-replies').hide();
        });

        $('#hide-replies').click(function() {
            $('#replies').hide();
            $('#hide-replies').hide();
            $('#show-replies').show();
        });

        $('#reply-show').click(function() {
            $('#reply-form').show();
        });

        $('#reply-close').click(function() {
            $('#reply-form').hide();
            $('#reply').val('');
            $(".inputerror").text("");
            $("#reply").removeClass("is-invalid");
        });
    });

    function showEditComment(id) {
        $(`#edit-comment-form-${id}`).show();
    }

    function closeEditComment(id) {
        $(`#edit-comment-form-${id}`).hide();
        $(`.inputerror-${id}`).text("");
        $(`#comment-${id}`).removeClass("is-invalid");
    }

    $('.edit-comment-btn').on('click', function (e) {
        e.preventDefault();
        let id = $(this).data('id');

        let formData = $(`#editCommentForm-${id}`).serializeArray();
        $(`.inputerror-${id}`).text("");
        $(`#editCommentForm-${id} input`).removeClass("is-invalid");

        $("#loader").prepend('<i class="fa fa-spinner fa-spin"></i>');
        $(`.edit-comment-btn-${id}`).attr("disabled", 'disabled');

        $.ajax({
            method: "POST",
            headers: {
                Accept: "application/json"
            },
            url: "{{ route('update.comment') }}",
            data: formData,
            // headers: {
            //     'X-CSRF-TOKEN': $('#csrf-token-'+id).attr('content')
            // },
            success: (response) => {
                $(".fa-spinner").remove();
                $(`.reply-btn`).prop("disabled", false);
                let goTo = '{{route("update.comment.success",":id")}}';
                goTo = goTo.replace(':id', response.id);
                window.location.assign(goTo);
            },
            error: (response) => {
                $(".fa-spinner").remove();
                $(`.edit-comment-btn-${id}`).prop("disabled", false);

                if(response.status === 422) {
                    let errors = response.responseJSON.errors;
                    Object.keys(errors).forEach(function (key) {
                        $(`#${key}-${id}`).addClass("is-invalid");
                        $(`#${key}-${id}-Error`).text(errors[key][0]);
                    });
                } else {
                    window.location.reload();
                }
            }
        })
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
