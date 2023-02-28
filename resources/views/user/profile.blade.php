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
                                    {{ 'System Administrator' }}
                                @elseif(auth()->user()->type == 'facil')
                                    {{ 'Facilitator' }}
                                @elseif(auth()->user()->type == 'teacher')
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
                                <div id="no-lesson-plans m-3">
                                    <div class="col-md-12 text-center m-4">
                                        <span>You Have No Lesson Plans Yet</span>
                                    </div>
                                    <div class="col-md-12 text-center m-4">
                                        <a href="" class="btn bg-gradient-dark center">Create Lesson Plan</a>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="password-change">
                                <div class="card-header pb-0 p-3">
                                    <div class="row">
                                        <div class="col-md-8 d-flex align-items-center">
                                            <h6 class="mb-3">Password Reset</h6>
                                        </div>
                                    </div>
                                </div>
                                <form method='POST' action="{{ route('update-password') }}">
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

@section('scripts')
<script>
    $( document ).ready(function() {

        var whichTab = window.location.href.slice(window.location.href.indexOf('?') + 1).split('=');

        // console.log(whichTab[1]);

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
</script>
@endsection
