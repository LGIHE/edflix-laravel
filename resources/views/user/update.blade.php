<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <x-navbars.sidebar activePage="users"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100 pb-5">
        <!-- Navbar -->
        <x-navbars.topbar titlePage='Update User'></x-navbars.topbar>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4 mt-5">
            <div class="card card-body mx-3 mx-md-4 ">

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
                                            <h6 class="mb-3">User Information</h6>
                                        </div>
                                    </div>
                                </div>
                                <form method='POST' action="{{ route('update.user', $user->id) }}">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name" class="form-control border border-2 p-2" value='{{ $user->name }}'>
                                            @error('name')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">email</label>
                                            <input type="email" name="email" class="form-control border border-2 p-2" value='{{ $user->email }}'>
                                            @error('email')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Phone</label>
                                            <input type="text" name="phone" class="form-control border border-2 p-2" value='{{ $user->phone }}'>
                                            @error('phone')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Location</label>
                                            <input type="text" name="location" class="form-control border border-2 p-2" value='{{ $user->location }}'>
                                            @error('location')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Role</label>
                                            <select class="form-select border border-2 p-2" name="role" aria-label="">
                                                <option vlaue="Select Level" {{ $user->role == "" ? "selected" : '' }}>Select Level</option>
                                                <option value="Administrator" {{ $user->role == "Administrator" ? "selected" : '' }}>Administrator</option>
                                                <option value="Facilitator" {{ $user->role == "Facilitator" ? "selected" : '' }}>Facilitator</option>
                                                <option value="Teacher" {{ $user->role == "Teacher" ? "selected" : '' }}>Teacher</option>
                                            </select>
                                            @error('role')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Password</label><br>
                                            <button type="button" class="btn bg-gradient-info">Change Password</button>
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">School</label>
                                            <select class="form-select border border-2 p-2" name="school" aria-label="">
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
                                                <option value="{!! $subject->id !!}" @if($subject->id == $user->subject_1) {{'selected'}} @endif>{!! $subject->name !!}</option>
                                                @endforeach
                                            </select>
                                            <p class='text-danger font-weight-bold inputerror' id="subject_1Error"></p>
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label subject-2">Subject 2</label>
                                            <select class="form-select border-2 p-2" name="subject_2" aria-label="">
                                                <option value="" selected>Select Subject</option>
                                                @foreach($subjects as $subject)
                                                <option value="{!! $subject->id !!}" @if($subject->id == $user->subject_2) {{'selected'}} @endif>{!! $subject->name !!}</option>
                                                @endforeach
                                            </select>
                                            <p class='text-danger font-weight-bold inputerror' id="subject_2Error"></p>
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label subject-3">Subject 3</label>
                                            <select class="form-select" name="subject_3" aria-label="">
                                                <option value="" selected>Select Subject</option>
                                                @foreach($subjects as $subject)
                                                <option value="{!! $subject->id !!}" @if($subject->id == $user->subject_3) {{'selected'}} @endif>{!! $subject->name !!}</option>
                                                @endforeach
                                            </select>
                                            <p class='text-danger font-weight-bold inputerror' id="subject_3Error"></p>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn bg-gradient-dark">Update User</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>

