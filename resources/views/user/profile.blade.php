<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <x-navbars.sidebar activePage="profile"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100 pb-5">
        <!-- Navbar -->
        <x-navbars.topbar titlePage='Profile'></x-navbars.topbar>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4 mt-5">
            <div class="card card-body mx-3 mx-md-4 ">
                <div class="row gx-4 mb-2">
                    <div class="col-auto">
                        <div class="avatar avatar-xl position-relative">
                            <img src="{{ asset('assets') }}/img/user/avatar.png" alt="profile_image" class="w-100 border-radius-lg">
                        </div>
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                {{ auth()->user()->name }}
                            </h5>
                            <p class="mb-0 font-weight-normal text-sm">
                                @if (auth()->user()->type == 'admin')
                                    @if(auth()->user()->role == 'Facilitator')
                                    {{ 'Facilitator' }}
                                    @else
                                    {{ 'System Administrator' }}
                                    @endif
                                @else
                                    {{ 'Teacher' }}
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                        <div class="nav-wrapper position-relative end-0">
                            <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#bio-form"
                                        role="tab" aria-selected="true">
                                        <i class="material-icons text-lg position-relative">person</i>
                                        <span class="ms-1">Bio</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#lesson-plans"
                                        role="tab" aria-selected="false">
                                        <i class="material-icons text-lg position-relative">list</i>
                                        <span class="ms-1">Lesson Plans</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#password-change"
                                        role="tab" aria-selected="false">
                                        <i class="material-icons text-lg position-relative">settings</i>
                                        <span class="ms-1">Change Password</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card card-plain h-100">
                    <div class="card-body p-3">
                        @if (session('status'))
                        <div class="row">
                            <div class="alert alert-success alert-dismissible text-white" role="alert">
                                <span class="text-sm">{{ Session::get('status') }}</span>
                                <button type="button" class="btn-close text-lg py-3 opacity-10"
                                    data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        @endif
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="bio-form">
                                <div class="card-header pb-0 p-3">
                                    <div class="row">
                                        <div class="col-md-8 d-flex align-items-center">
                                            <h6 class="mb-3">Bio Information</h6>
                                        </div>
                                    </div>
                                </div>
                                <form method='POST' action='{{ route('profile') }}'>
                                    @csrf
                                    <div class="row">

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Email address</label>
                                            <input type="email" name="email" class="form-control border border-2 p-2" value='{{ old('email', auth()->user()->email) }}'>
                                            @error('email')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name" class="form-control border border-2 p-2" value='{{ old('name', auth()->user()->name) }}'>
                                            @error('name')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Phone</label>
                                            <input type="number" name="phone" class="form-control border border-2 p-2" value='{{ old('phone', auth()->user()->phone) }}'>
                                            @error('phone')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Location</label>
                                            <input type="text" name="location" class="form-control border border-2 p-2" value='{{ old('location', auth()->user()->location) }}'>
                                            @error('location')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror
                                        </div>
                                    </div>
                                    <button type="submit" class="btn bg-gradient-dark">Submit</button>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="lesson-plans">
                                <div class="card-header pb-0 p-3">
                                    <div class="row">
                                        <div class="col-md-8 d-flex align-items-center">
                                            <h6 class="mb-3">Lesson Plans</h6>
                                        </div>
                                    </div>
                                </div>
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
                                                        <p class="text-m text-dark font-weight-bold mb-0">{{ ucfirst(trans($lessonPlan->status ))}}</p>
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
                                                <td class="align-middle">
                                                    <a rel="tooltip" class="" id="view-lp" data-value="{{ $lessonPlan->id }}" style="cursor:pointer;">
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
                                <div id="no-lesson-plans m-3">
                                    <div class="col-md-12 text-center m-4">
                                        <span>You Have No Lesson Plans Yet</span>
                                    </div>
                                    <div class="col-md-12 text-center m-4">
                                        <a href="{{ route('get.create.lesson.plan') }}" class="btn bg-gradient-dark center">Create Lesson Plan</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="{{ route('get.upload.lesson.plan') }}" class="btn bg-gradient-dark center">Upload Lesson Plan</a>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="tab-pane fade" id="password-change">
                                <div class="card-header pb-0 p-3">
                                    <div class="row">
                                        <div class="col-md-8 d-flex align-items-center">
                                            <h6 class="mb-3">Password Reset</h6>
                                        </div>
                                    </div>
                                </div>
                                <form method='POST' action="{{ route('update.password') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">New Password</label>
                                            <input type="password" name="password" class="form-control border border-2 p-2">
                                            @error('password')
                                            <p class='text-danger font-weight-bold inputerror'>{{ $message }} </p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Confirm Password</label>
                                            <input type="password" name="password_confirmation" class="form-control border border-2 p-2">
                                            @error('password_confirmation')
                                            <p class='text-danger font-weight-bold inputerror'>{{ $message }} </p>
                                            @enderror
                                        </div>
                                    </div>
                                    <button type="submit" class="btn bg-gradient-dark">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>

<script>
    $( document ).ready(function() {

        var whichTab = window.location.href.slice(window.location.href.indexOf('?') + 1).split('=');

        console.log(whichTab[1]);

        switch(whichTab[1]){
            case '1':
                $("#bio-form").addClass('active show');
                $('#lesson-plans').removeClass('active show');
                $('#password-change').removeClass('active show');
                // $('[href="#bio-form"]').tab('show');
                break;
            case '2':
                $("#bio-form").removeClass('active show');
                $('#lesson-plans').addClass('active show');
                $('#password-change').removeClass('active show');
                // $('[href="#lesson-plans"]').tab('show');
                break;
            case '3':
                $("#bio-form").removeClass('active show');
                $('#lesson-plans').removeClass('active show');
                $('#password-change').addClass('active show');
                break;
        }
    });

    $(document).on('click','#view-lp',function(){
        var lesson_plan_id = $(this).data("value");
        var url = '{{route("get.lesson.plan",":id")}}';
        url = url.replace(':id', lesson_plan_id);
        window.location.assign(url);
    });
</script>
