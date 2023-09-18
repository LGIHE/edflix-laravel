<style>
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
                                <form method="GET" action="{{ route('filter.lesson.plans') }}" class="form-inline" id="filter-form">
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
                                            <select name="class" id="class" class="form-select px-3">
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
                                        <div class="col-md-1">
                                            <label for="" style="color: transparent;">Search</label>
                                            <button type="submit" class="btn btn-primary filter-submit-btn">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            @if (count($lessonPlans) > 0)
                                @if ($yourLPs > 0)
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0" id="lp-table">
                                        <thead>
                                            <tr>
                                                <th class="text-secondary text-xxl font-weight-bolder">Subject</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">Class</th>
                                                <th class="text-secondary text-xxl font-weight-bolder px-4">Theme</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">Topic</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">Learners</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">Duration</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">Status</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">Public</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">Owner</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">School</th>
                                                <th class="text-secondary">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="lp-table-body">
                                        @foreach ($lessonPlans as $lessonPlan)
                                            <tr>
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
                                                        {{ \App\Models\LessonStep::where(['lesson_plan' => $lessonPlan->id])->sum('duration') }}`
                                                        </p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <p class="text-m text-dark font-weight-bold mb-0">{{ ucfirst(trans($lessonPlan->status)) }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <span class="text-dark text-m font-weight-bold">@if($lessonPlan->visibility == 1) {{ 'Yes' }} @else {{ 'No' }} @endif</span>
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
                                                </td>
                                            </tr>

                                            <!-- School Update Modal -->
                                            <!--  -->
                                            <!-- Confirm School Delete modal -->
                                            <div class="modal fade" id="deleteModal-{{ $lessonPlan->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-sm" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirm</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body" id="smallBody">
                                                            <div class="text-center">
                                                                <span class="">Are you sure you want to Delete this School?</span>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer align-items-center">
                                                            <button type="button" class="btn btn-success" id="del-btn" data-value="{{ route('delete.lesson.plan', $lessonPlan->id) }}">Confirm</button>
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="spinner-border text-dark" role="status" id="loading-spinner" style="display: none;">
                                    {{-- <span class="sr-only">Loading...</span> --}}
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

    $(document).on('click','#view-lp',function(){
        var lesson_plan_id = $(this).data("value");
        var url = '{{route("get.lesson.plan",":id")}}';
        url = url.replace(':id', lesson_plan_id);
        window.location.assign(url);
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
            $('#loading-spinner').show(); // Show the loading spinner

            // Serialize the form data
            var formData = $(this).serialize();

            $.ajax({
                type: 'GET',
                url: "{{ route('filter.lesson.plans') }}",
                data: formData,
                dataType: 'json', // Assume the response is in JSON format
                success: function (data) {
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

                        $('#lp-table-body').html(html); // Update the table body with new data
                    }
                    $('#loading-spinner').hide(); // Hide the loading spinner
                },
                error: function (xhr, status, error) {
                    console.error(error);
                    // Handle errors if needed
                }
            });
        });
    });

</script>

<script id="lesson-plan-template" type="text/x-handlebars-template">
    @include('lesson-plan/row')
</script>
