<x-layout bodyClass="bg-gray-200">
        <main class="main-content mt-0">
            <div class="page-header align-items-start min-vh-100">
                <span class="mask bg-gradient-dark opacity-1"></span>
                <div class="container mt-5">
                    <center><img src="{{ asset('assets') }}/img/logos/EDPLAN.png" alt="Edflix" class="m-3 mb-5" width="200"></center>
                    <div class="row">
                        <div class="col-lg-4 col-md-8 col-12 mx-auto">
                            <div class="card z-index-0 fadeIn3 fadeInBottom">
                                <div class="card-body">
                                    <h4 class="text-center">Sign In</h4>
                                    <form role="form" method="POST" action="{{ route('login') }}" class="text-start">
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
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email">
                                        </div>
                                        @error('email')
                                        <p class='text-danger font-weight-bold inputerror'>{{ $message }} </p>
                                        @enderror
                                        <div class="input-group input-group-outline mt-3">
                                            <label class="form-label">Password</label>
                                            <input type="password" class="form-control" name="password">
                                        </div>
                                        @error('password')
                                        <p class='text-danger font-weight-bold inputerror'>{{ $message }} </p>
                                        @enderror
                                        <div class="form-check form-switch d-flex align-items-center my-3">
                                            <input class="form-check-input" type="checkbox" id="rememberMe">
                                            <label class="form-check-label mb-0 ms-2" for="rememberMe">Remember
                                                me</label>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-info w-100 my-4 mb-2">Sign
                                                in</button>
                                        </div>
                                        <p class="text-sm text-center">
                                            Forgot your password?
                                            <a href="{{ route('verify') }}"
                                                class="text-info text-gradient font-weight-bold">Reset Password</a>
                                        </p>
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
<script>
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
