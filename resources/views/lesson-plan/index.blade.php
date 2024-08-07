<style>
    .filter-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(221, 218, 218, 0.7); /* Background color with 0.7 opacity */
        z-index: 1; /* Ensure it's above the table content */
        display: none;
    }

    /* Style for the table container */
    .table-container {
        position: relative;
        width: 100%;
        /* Add any other styling for the container as needed */
    }

    /* Style for the loading spinner */
    .loading-spinner {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border: 4px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top: 4px solid #3498db; /* Change to your desired spinner color */
        width: 40px;
        height: 40px;
        animation: spin 2s linear infinite; /* Animation for spinning */
    }

    /* Keyframes animation for spinning */
    @keyframes spin {
        0% { transform: translate(-50%, -50%) rotate(0deg); }
        100% { transform: translate(-50%, -50%) rotate(360deg); }
    }

    @media only screen and (max-width: 600px)
    {
        .filter-submit-btn {
            width: 100%;
        }
    }
</style>

<x-layout bodyClass="g-sidenav-show  bg-gray-200">

    <x-navbars.sidebar activePage="lesson-plans"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.topbar titlePage="Lesson Plans"></x-navbars.topbar>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class=" me-3 my-3 text-end">
                            <a class="btn bg-gradient-success mb-0" onclick="window.location.href='{{ route('get.create.lesson.plan') }}';" style="margin-right: 15px;">
                                <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Create LP
                            </a>
                            <a class="btn bg-gradient-dark mb-0 end" onclick="window.location.href='{{ route('get.upload.lesson.plan') }}';">
                                <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Upload LP
                            </a>
                        </div>
                        @if (session('status'))
                        <div class="row">
                            <div class="col-md-9">
                                <div class="alert alert-success alert-dismissible text-white fade show" role="alert"style="margin-left:20px;width:90%;">
                                    <span class="text-sm">{{ Session::get('status') }}</span>
                                    <button type="button" class="btn-close text-lg py-3 opacity-10"
                                        data-bs-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @elseif (session('error'))
                        <div class="row">
                            <div class="col-md-9">
                                <div class="alert alert-danger alert-dismissible text-white fade show" role="alert"style="margin-left:20px;width:90%;">
                                    <span class="text-sm">{{ Session::get('error') }}</span>
                                    <button type="button" class="btn-close text-lg py-3 opacity-10"
                                        data-bs-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="card-body pb-2">
                            <div class="filters">
                                <div class="ml-4 mb-3 text-dark text-bold">
                                    <span >Filter the Lesson Plans</span>
                                </div>
                                <form method="GET" class="form-inline" id="filter-form">
                                    @csrf
                                    <div class="row ml-4 mb-3">
                                        <div class="col-md-2">
                                            <label for="subject">Subject</label>
                                            <select name="subject" id="subject" class="form-select px-3">
                                                <option value="">Select Subject</option>
                                                @foreach($subjects as $subject)
                                                <option value="{!! $subject->id !!}">{!! $subject->name !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="class">Class</label>
                                            <select name="class" id="class" class="form-select px-1">
                                                <option value="">Select Class</option>
                                                <option value="S1">Senior One</option>
                                                <option value="S2">Senior Two</option>
                                                <option value="S3">Senior Three</option>
                                                <option value="S4">Senior Four</option>
                                                <option value="S5">Senior Five</option>
                                                <option value="S6">Senior Six</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="term">Term</label>
                                            <select name="term" id="term" class="form-select px-1">
                                                <option value="">Select Term</option>
                                                <option value="1">Term One</option>
                                                <option value="2">Term Two</option>
                                                <option value="3">Term Three</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="theme">Theme</label>
                                            <select name="theme" id="theme" class="form-select px-3">
                                                <option value="">Select Theme</option>
                                                <!-- Populate theme options dynamically if needed -->
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="topic">Topic</label>
                                            <select name="topic" id="topic" class="form-select px-3">
                                                <option value="">Select Topic</option>
                                                <!-- Populate topic options dynamically if needed -->
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="learning_outcomes">Key Learning Outcomes</label>
                                            <select name="learning_outcomes" id="learning_outcomes" class="form-select px-2">
                                                <option value="">Select Learning Outcome</option>
                                                <!-- Populate key learning outcomes options dynamically if needed -->
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row ml-4 mb-3">
                                        @if (auth()->user()->isAdmin())
                                        <div class="col-md-2">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="form-select px-3">
                                                <option value="">Select Status</option>
                                                <option value="edit">Edit</option>
                                                <option value="submitted">Submitted</option>
                                                <option value="reviewed">Reviewed</option>
                                                <option value="approved">Approved</option>
                                            </select>
                                        </div>
                                        @endif

                                        <div class="col-md-1">
                                            <label for="" style="color: transparent;">Search</label>
                                            <button type="submit" class="btn btn-primary filter-submit-btn">Search <span id="loader"></span></button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            @if (count($lessonPlans) > 0)
                                @if ($yourLPs > 0)
                                <div class="table-responsive p-0 table-container">
                                    <table class="table align-items-center mb-0" id="lp-table">
                                        <thead>
                                            <tr>
                                                <th class="text-secondary text-xxl font-weight-bolder">Subject</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">Class</th>
                                                <th class="text-secondary text-xxl font-weight-bolder px-4">Theme</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">Topic</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">Learners</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">Duration (min)</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">Status</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">Public</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">Owner</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">School</th>
                                                <th class="text-secondary">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="lp-table-body">
                                        @foreach ($lessonPlans as $lessonPlan)
                                            <tr onclick="redirectToLessonPlan('{{ route('get.lesson.plan', $lessonPlan->id) }}')" style="cursor: pointer;">
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <p class="text-m text-dark font-weight-bold mb-0">{{ $lessonPlan->subjectName }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <span class="text-dark text-m font-weight-bold">{{ $lessonPlan->class }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center px-2">
                                                        <h6 class="mb-0 text-m">{{ $lessonPlan->theme }}</h6>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <p class="text-m text-dark font-weight-bold mb-0">{{ $lessonPlan->topic }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <span class="text-dark text-m font-weight-bold">{{ $lessonPlan->learners_no }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <p class="text-m text-dark font-weight-bold mb-0">
                                                        {{ \App\Models\LessonStep::where(['lesson_plan' => $lessonPlan->id])->sum('duration') }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        @if($lessonPlan->status == 'init' || $lessonPlan->status == 'edit')
                                                            <span id="editSpan" onmouseover="showPopover('editSpan')" onmouseout="hidePopover('editSpan')" data-toggle="popover" title="Edit" data-content="{{ 'Edit' }}" style="display: inline-block; width: 20px; height: 20px; border-radius: 50%; background-color: red; cursor: pointer;"></span>
                                                        @elseif($lessonPlan->status == 'submitted')
                                                            <span id="submittedSpan" onmouseover="showPopover('submittedSpan')" onmouseout="hidePopover('submittedSpan')" data-toggle="popover" title="Submitted" data-content="{{ 'Submitted' }}" style="display: inline-block; width: 20px; height: 20px; border-radius: 50%; background-color: #debd36; cursor: pointer;"></span>
                                                        @elseif($lessonPlan->status == 'reviewed')
                                                            <span id="reviewedSpan" onmouseover="showPopover('reviewedSpan')" onmouseout="hidePopover('reviewedSpan')" data-toggle="popover" title="Reviewed" data-content="{{ 'Reviewed' }}" style="display: inline-block; width: 20px; height: 20px; border-radius: 50%; background-color: #1564b8; cursor: pointer;"></span>
                                                        @else
                                                            <span id="statusSpan" onmouseover="showPopover('statusSpan')" onmouseout="hidePopover('statusSpan')" data-toggle="popover" title="{{ ucfirst(trans($lessonPlan->status)) }}" data-content="{{ ucfirst(trans($lessonPlan->status)) }}" style="display: inline-block; width: 20px; height: 20px; border-radius: 50%; background-color: #15b815; cursor: pointer;"></span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        @if($lessonPlan->visibility == 1)
                                                            <span id="yesSpan" onmouseover="showPopover('yesSpan')" onmouseout="hidePopover('yesSpan')" data-toggle="popover" title="Public" data-content="{{ 'Public' }}" style="display: inline-block; width: 20px; height: 20px; border-radius: 50%; background-color: #15b815; cursor: pointer;"></span>
                                                        @else
                                                            <span id="noSpan" onmouseover="showPopover('noSpan')" onmouseout="hidePopover('noSpan')" data-toggle="popover" title="Private" data-content="{{ 'Private' }}" style="display: inline-block; width: 20px; height: 20px; border-radius: 50%; background-color: red; cursor: pointer;"></span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <span class="text-dark text-m font-weight-bold">{{ $lessonPlan->ownerName }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <span class="text-dark text-m font-weight-bold">{{ $lessonPlan->schoolName }}</span>
                                                    </div>
                                                </td>
                                                <td class="align-middle not-export-col">
                                                    <a rel="tooltip" class="" id="view-lp" data-value="{{ $lessonPlan->id }}" style="cursor:pointer;">
                                                        <i class="material-icons" style="font-size:25px;margin-right:20px;">visibility</i>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                    @if(@auth()->user()->isRoleSuperAdmin())
                                                    <a data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $lessonPlan->id}}" title="Delete Lesson Plan" style="cursor:pointer;">
                                                        <i class="material-icons" style="font-size:25px;margin-right:20px;">delete</i>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                    @endif
                                                </td>

                                            </tr>

                                            <div class="modal fade" id="deleteModal-{{ $lessonPlan->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-sm" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirm</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body" id="smallBody">
                                                            <div class="text-center">
                                                                <span class="">Are you sure you want to Delete this Lesson Plan?</span>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer align-items-center">
                                                            <button type="button" class="btn btn-success" id="delete-lp" data-value="{{ route('delete.lesson.plan', $lessonPlan->id) }}">Confirm</button>
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="filter-overlay">
                                        <div class="loading-spinner"></div>
                                    </div>
                                </div>
                                @else
                                <div class="container text-center mt-2 pt-5">
                                    <h4 class="font-weight-bold">Add a lesson plan to view others.</h4>
                                </div>
                                @endif
                            @else
                                <div class="container text-center m-2 p-5">
                                    <span class="display-6 font-weight-bold">No Lesson Plans Added Yet.</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>



<script>

    $(document).on('click','.view-lp',function(){
        var lesson_plan_id = $(this).data("value");
        var url = '{{route("get.lesson.plan",":id")}}';
        url = url.replace(':id', lesson_plan_id);
        window.location.assign(url);
    });

    $(document).on('click', '#delete-lp', function(event) {
        event.preventDefault();
        $(this).prop("disabled", true);
        let href = $(this).data('value');
        window.location.assign(href);
    });

    $(document).ready(function() {
        $('#lp-table').DataTable({
            dom: 'Bflrtip',
            pageLength: 10,
            buttons: [],
            columnDefs: [{
                "defaultContent": "",
                "targets": "_all"
            }]
        });
        $('#lp-table td .d-flex').css('white-space','initial');
    });

    $(document).ready(function () {
        $('#filter-form').on('submit', function (e) {
            e.preventDefault(); // Prevent form submission
            $('.filter-overlay').show();
            $("#loader").prepend('<i class="fa fa-spinner fa-spin"></i>'); // Show the button loading spinner
            $(".btn-submit").attr("disabled", 'disabled'); // Disable button

            // Serialize the form data
            var formData = $(this).serialize();

            $.ajax({
                type: 'GET',
                url: "{{ route('filter.lesson.plans') }}",
                data: formData,
                dataType: 'json', // Assume the response is in JSON format
                success: function (data) {
                    $('.filter-overlay').hide();
                    $(".fa-spinner").remove();
                    $(".btn-submit").prop("disabled", false);
                    // Refresh the DataTable instance
                    var lpDataTable = $('#lp-table').DataTable();
                    lpDataTable.clear().draw();
                    lpDataTable.rows.add(data).draw();

                    if(data.length > 0){
                        // Get the Handlebars template
                        var template = Handlebars.compile($('#lesson-plan-template').html());

                        // Generate HTML for each row and append it to the table body
                        var html = '';
                        data.forEach(function (lessonPlan) {
                            html += template(lessonPlan);
                        });

                        $('#lp-table-body').html(html);
                    }
                },
                error: function (xhr, status, error) {
                    $('.filter-overlay').hide();
                    $(".fa-spinner").remove();
                    $(".btn-submit").prop("disabled", false);
                }
            });
        });
    });

</script>

<script>
    // Function to initialize Bootstrap popovers
    function initializePopovers() {
        // Initialize popovers for each span
        $('[data-toggle="popover"]').popover({
            trigger: 'hover', // Show on hover
            placement: 'bottom', // Adjust placement as needed
        });
    }

    // Function to show popover content on hover
    function showPopover(spanId) {
        $(`#${spanId}`).popover('show');
    }

    // Function to hide popover content when mouse leaves
    function hidePopover(spanId) {
        $(`#${spanId}`).popover('hide');
    }

    // Call initializePopovers when the document is ready
    $(document).ready(function () {
        initializePopovers();
    });

    function redirectToLessonPlan(url) {
        window.location.href = url;
    }

</script>

<script id="lesson-plan-template" type="text/x-handlebars-template">
    @include('lesson-plan/row')
</script>
