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
                            <a class="btn bg-gradient-dark mb-0 end" onclick="window.location.href='{{ route('get.create.lesson.plan') }}';">
                                <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Create A Lesson Plan
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
                                                        <h6 class="mb-0 text-m">{{ lessonPlans->theme }}</h6>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <p class="text-m text-dark font-weight-bold mb-0">{{ $school->subject }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <p class="text-m text-dark font-weight-bold mb-0">{{ $school->topic }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <span class="text-dark text-m font-weight-bold">{{ $school->class }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center px-3 py-1">
                                                        <span class="text-dark text-m font-weight-bold">{{ $school->learners_no }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center px-3 py-1">
                                                        <p class="text-m text-dark font-weight-bold mb-0">0</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center px-3 py-1">
                                                        <p class="text-m text-dark font-weight-bold mb-0">{{ $school->status }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center px-3 py-1">
                                                        <span class="text-dark text-m font-weight-bold">{{ $school->visibility }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center px-3 py-1">
                                                        <span class="text-dark text-m font-weight-bold">{{ $school->owner }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center px-3 py-1">
                                                        <span class="text-dark text-m font-weight-bold">{{ $school->school }}</span>
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <a rel="tooltip" class="btn btn-success btn-link" id="open-update" data-value="{{ $school->id }}">
                                                        <i class="material-icons">edit</i>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- School Update Modal -->
                                            <!--  -->
                                            <!-- Confirm School Delete modal -->
                                            <div class="modal fade" id="deleteModal-{{ $school->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
                                                            <button type="button" class="btn btn-success" id="del-btn" data-value="{{ route('delete.school', $school->id) }}">Confirm</button>
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
        var school_id = $(this).data("value");
        var url = '{{route("get.school",":id")}}';
        url = url.replace(':id', school_id);
        window.location.assign(url);
    });


</script>

