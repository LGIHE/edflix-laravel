<style>
    body {
        background-color: #f8f9fa !important
    }

    .alert-warning {
        background-image: none!important;
    }

    h2 {
        font-weight: 800 !important;
    }


</style>
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <div class="container mt-5 pt-5">
        <div class="alert alert-warning text-center">
            <h2 class="display-3">404</h2>
            <h4 class="display-6">Oops!</h4>
            <h4 class="display-6">Looks like you are offline.</h4><br>
            <center><a type="button" class="btn btn-warning" href="{{ route('dashboard') }}">RETRY</a></center>
        </div>
    </div>
</x-layout>
