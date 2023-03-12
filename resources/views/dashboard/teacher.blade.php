<style>
    .dash-block {
        cursor: pointer;
    }
</style>
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='dashboard'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.topbar titlePage=""></x-navbars.topbar>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4 dash-block" onclick="window.location.href='{{ route("lesson.plans") }}'">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-secondary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10" style="top:10%;font-size:48px;">piano</i>
                            </div>
                            <div class="text-end pt-1">
                                <h5 class="mb-0">All Lesson Plans</h5>
                                <h4 class="mb-0">{{ count($lessonPlans) }}</h4>
                            </div>
                        </div>
                        <div class="card-footer p-2"></div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4 dash-block" onclick="window.location.href='{{ route("profile") }}?tab=2'">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-secondary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10" style="top:10%;font-size:48px;">school</i>
                            </div>
                            <div class="text-end pt-1">
                                <h5 class="mb-0">Your Lesson Plans</h5>
                                <h4 class="mb-0">{{ count($yourLPs) }}</h4>
                            </div>
                        </div>
                        <div class="card-footer p-2"></div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4 dash-block">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-secondary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10" style="top:10%;font-size:48px;">people</i>
                            </div>
                            <div class="text-end pt-1">
                                <h5 class="mb-0">Your Approved LPs</h5>
                                <h4 class="mb-0">{{ count($yourApprovedLPs) }}</h4>
                            </div>
                        </div>
                        <div class="card-footer p-2"></div>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                @if (count($lessonPlans) > 0)
                <div class="table-responsive p-2 pt-5">
                    <table class="table align-items-center mb-0" id="table">
                        <thead>
                            <tr>
                                <th class="text-secondary text-xxl font-weight-bolder px-4">Theme</th>
                                <th class="text-secondary text-xxl font-weight-bolder">Subject</th>
                                <th class="text-secondary text-xxl font-weight-bolder">Topic</th>
                                <th class="text-secondary text-xxl font-weight-bolder">Class</th>
                                <th class="text-secondary text-xxl font-weight-bolder">Learners</th>
                                <th class="text-secondary text-xxl font-weight-bolder">Duration</th>
                                <!-- <th class="text-secondary text-xxl font-weight-bolder">Status</th>
                                <th class="text-secondary text-xxl font-weight-bolder">Public</th> -->
                                <th class="text-secondary text-xxl font-weight-bolder">Owner</th>
                                <!-- <th class="text-secondary text-xxl font-weight-bolder">School</th> -->
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
                                        <p class="text-m text-dark font-weight-bold mb-0">@foreach($subjects as $subject) @if($lessonPlan->subject == $subject->id) {{$subject->name}} @endif @endforeach</p>
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
                                        {{ \App\Models\LessonStep::where(['lesson_plan' => $lessonPlan->id])->sum('duration') }}
                                        </p>
                                    </div>
                                </td>
                                <!-- <td>
                                    <div class="d-flex flex-column justify-content-center">
                                        <p class="text-m text-dark font-weight-bold mb-0">{{ ucfirst(trans($lessonPlan->status ))}}</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column justify-content-center">
                                        <span class="text-dark text-m font-weight-bold">@if($lessonPlan->visibility == 1) {{ 'Yes' }} @else {{ 'No' }} @endif</span>
                                    </div>
                                </td> -->
                                <td>
                                    <div class="d-flex flex-column justify-content-center">
                                        <span class="text-dark text-m font-weight-bold">@foreach($teachers as $teacher) @if($lessonPlan->owner == $teacher->id) {{$teacher->name}} @endif @endforeach</span>
                                    </div>
                                </td>
                                <!-- <td>
                                    <div class="d-flex flex-column justify-content-center">
                                        <span class="text-dark text-m font-weight-bold">@foreach($schools as $school) @if($lessonPlan->school == $school->id) {{$school->name}} @endif @endforeach</span>
                                    </div>
                                </td> -->
                                <td class="align-middle">
                                    <a rel="tooltip" class="" id="open-update" data-value="{{ $lessonPlan->id }}" style="cursor:pointer;">
                                        <i class="material-icons" style="font-size:25px;margin-right:20px;">visibility</i>
                                        <div class="ripple-container"></div>
                                    </a>
                                </td>
                                </tr>
                                    <!-- Confirm Lesson Plan Delete modal -->
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
