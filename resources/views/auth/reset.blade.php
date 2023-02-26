<x-layout bodyClass="bg-gray-200">
    <main class="main-content mt-0">
        <div class="page-header align-items-start min-vh-100">
            <span class="mask bg-gradient-dark opacity-1"></span>
            <div class="container mt-5">
                <center><img src="{{ asset('assets') }}/img/logos/edflix-logo.png" alt="Edflix" class="m-3 mb-5" width="200"></center>
                <div class="row">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            <div class="card-body">
                                <h4 class="text-center">Reset Password</h4>
                                <form role="form" method="POST" action="{{ route('password.update', ['token' => $token]) }}" class="text-start">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <div class="input-group input-group-outline mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email">
                                    </div>
                                    @error('email')
                                    <p class='text-danger font-weight-bold inputerror'>{{ $message }} </p>
                                    @enderror
                                    <div class="input-group input-group-outline my-3">
                                        <label class="form-label">New password</label>
                                        <input type="password" class="form-control" name="password">
                                    </div>
                                    @error('password')
                                    <p class='text-danger font-weight-bold inputerror'>{{ $message }} </p>
                                    @enderror
                                    <div class="input-group input-group-outline my-3">
                                        <label class="form-label">Confirm New Password</label>
                                        <input type="password" class="form-control" name="password_confirmation">
                                    </div>
                                    @error('password_confirmation')
                                    <p class='text-danger font-weight-bold inputerror'>{{ $message }} </p>
                                    @enderror
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-info w-100 my-4 mb-2">Change
                                            password</button>
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

</x-layout>
