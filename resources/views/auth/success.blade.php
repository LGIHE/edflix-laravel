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
                                <h5 class="text-center text-success">Your signup was successful</h5>
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
                                    <div class="text-center">
                                        <p class="text-sm text-center text-bold">Please check your email for the Login credentials.</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-sm text-center">- OR -</p>
                                        <p class="text-sm text-center text-bold">Go ahead and Sign In with the email and password you provided.</p>
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
</x-layout>
