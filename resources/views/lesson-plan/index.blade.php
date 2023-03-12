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
                        @endif
                        <div class="card-body px-0 pb-2">
                            @if (count($lessonPlans) > 0)
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0" id="table">
                                        <thead>
                                            <tr>
                                                <th class="text-secondary text-xxl font-weight-bolder px-4">Theme</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">Subject</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">Topic</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">Class</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">Learners</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">Duration</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">Status</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">Public</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">Owner</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">School</th>
                                                <th class="text-secondary"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($lessonPlans as $lessonPlan)
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center px-2">
                                                        <h6 class="mb-0 text-m">{{ $lessonPlan->theme }}</h6>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <p class="text-m text-dark font-weight-bold mb-0">{{ $lessonPlan->subjectName }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <p class="text-m text-dark font-weight-bold mb-0">{{ $lessonPlan->topic }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <span class="text-dark text-m font-weight-bold">{{ $lessonPlan->class }}</span>
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
                                                    <a rel="tooltip" class="" id="open-update" data-value="{{ $lessonPlan->id }}" style="cursor:pointer;">
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

    $(document).on('click','#open-update',function(){
        var lesson_plan_id = $(this).data("value");
        var url = '{{route("get.lesson.plan",":id")}}';
        url = url.replace(':id', lesson_plan_id);
        window.location.assign(url);
    });


</script>

