<x-layout bodyClass="bg-gray-200">
    <main class="main-content mt-0">
        <div class="page-header align-items-start min-vh-100">
            <span class="mask bg-gradient-dark opacity-1"></span>
            <div class="container mt-5">
                <center><img src="{{ asset('assets') }}/img/logos/actnow-logo.png" alt="ACT NOW" class="m-3 mb-5" width="200"></center>
                <div class="row">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            <div class="card-body">
                                <h4 class="text-center">Sign Up</h4>
                                <form role="form" method="POST" action="{{ route('signup') }}" class="text-start">
                                    @csrf
                                    @if (Session::has('status'))
                                    <div class="alert alert-success alert-dismissible text-white" role="alert">
                                        <span class="text-sm">{{ Session::get('status') }}</span>
                                        <button type="button" class="btn-close text-lg py-3 opacity-10"
                                            data-bs-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif
                                    <div class="input-group input-group-outline mt-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name">
                                    </div>
                                    @error('name')
                                    <p class='text-danger font-weight-bold inputerror'>{{ $message }} </p>
                                    @enderror

                                    <div class="input-group input-group-outline mt-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email">
                                    </div>
                                    @error('email')
                                    <p class='text-danger font-weight-bold inputerror'>{{ $message }} </p>
                                    @enderror

                                    <div class="input-group input-group-outline mt-3">
                                        <label class="form-label">Phone (e.g. 0771234567)</label>
                                        <input type="text" class="form-control" name="phone">
                                    </div>
                                    @error('phone')
                                    <p class='text-danger font-weight-bold inputerror'>{{ $message }} </p>
                                    @enderror

                                    <div class="input-group input-group-outline mt-3">
                                        <label class="form-label">Location</label>
                                        <input type="text" class="form-control" name="location">
                                    </div>
                                    @error('location')
                                    <p class='text-danger font-weight-bold inputerror'>{{ $message }} </p>
                                    @enderror

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">School</label>
                                        <select id="school-records" class="form-select p-2" name="school" aria-label="">
                                            <option value="" selected>Select School</option>
                                            @foreach($schools as $school)
                                            <option value="{!! $school->id !!}">{!! $school->name !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('school')
                                    <p class='text-danger font-weight-bold inputerror'>{{ $message }} </p>
                                    @enderror

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Subject</label>
                                        <select id="subject-records" class="form-select p-2" name="subject_1" aria-label="">
                                            <option value="" selected>Select Subject</option>
                                            @foreach($subjects as $subject)
                                            <option value="{!! $subject->id !!}">{!! $subject->name !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('subject_1')
                                    <p class='text-danger font-weight-bold inputerror'>{{ $message }} </p>
                                    @enderror

                                    <div class="input-group input-group-outline mt-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password">
                                    </div>
                                    @error('password')
                                    <p class='text-danger font-weight-bold inputerror'>{{ $message }} </p>
                                    @enderror

                                    <input type="hidden" name="role" value="Teacher">

                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-info w-100 my-4 mb-2">Sign Up</button>
                                    </div>

                                    <div class="text-center">
                                        <p class="text-sm text-center">
                                            - OR -
                                        </p>
                                        <a href="{{ route('login') }}" class="btn bg-gradient-success w-100" >Sign In</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-footer></x-footer>
        </div>
    </main>
    @push('js')
<script src="{{ asset('assets') }}/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#school-records').select2();
    $('#subject-records').select2();
});

$(function() {

    var text_val = $(".input-group input").val();
    if (text_val === "") {
    $(".input-group").removeClass('is-filled');
    } else {
    $(".input-group").addClass('is-filled');
    }
});
</script>
@endpush
</x-layout>
