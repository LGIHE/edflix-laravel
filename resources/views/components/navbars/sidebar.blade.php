<style>
    .navbar-vertical.navbar-expand-xs .navbar-collapse {
        overflow: visible!important;
    }

    /* #logo-text {
        font-weight: 800;
        font-size:
    } */
</style>

@props(['activePage'])

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-transparent" id="sidenav-main">
    <div class="sidenav-header">
        <img src="{{ asset('assets') }}/img/logos/EDPLAN.png" class="cursor-pointer h-80 w-80" id="iconSidenav" alt="">
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item mt-3">
                <a class="nav-link text-dark {{ $activePage == 'dashboard' ? ' active bg-gradient-info' : '' }} "
                    href="{{ route('dashboard') }}">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text text-m text-bold ms-1" style="font-size:1rem;">Dashboard</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <a class="nav-link text-dark {{ $activePage == 'lesson-plans' ? ' active bg-gradient-info' : '' }} "
                    href="{{ route('lesson.plans') }}">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">list</i>
                    </div>
                    <span class="nav-link-text text-m text-bold ms-1" style="font-size:1rem;">Lesson Plans</span>
                </a>
            </li>
            @if(auth()->user()->isAdmin())
            <li class="nav-item mt-3">
                <a class="nav-link text-dark {{ $activePage == 'users' ? ' active bg-gradient-info' : '' }} "
                    href="{{ route('users') }}">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">people</i>
                    </div>
                    <span class="nav-link-text text-m text-bold ms-1" style="font-size:1rem;">User Management</span>
                </a>
            </li>
            @endif
            @if(auth()->user()->isAdmin())
            <li class="nav-item mt-3">
                <a class="nav-link text-dark {{ $activePage == 'schools' ? ' active bg-gradient-info' : '' }} "
                    href="{{ route('schools') }}">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">home</i>
                    </div>
                    <span class="nav-link-text text-m text-bold ms-1" style="font-size:1rem;">Schools</span>
                </a>
            </li>
            @endif
            @if(auth()->user()->isAdmin())
            <li class="nav-item mt-3">
                <a class="nav-link text-dark {{ $activePage == 'subjects' ? ' active bg-gradient-info' : '' }} "
                    href="{{ route('subjects') }}">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">book</i>
                    </div>
                    <span class="nav-link-text text-m text-bold ms-1" style="font-size:1rem;">Subjects</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <a class="nav-link text-dark {{ $activePage == 'reports' ? ' active bg-gradient-info' : '' }} "
                    href="#">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">folder</i>
                    </div>
                    <span class="nav-link-text text-m text-bold ms-1" style="font-size:1rem;">Reports</span>
                </a>
            </li>
            @endif
            <li class="nav-item mt-3">
                <a class="nav-link text-dark {{ $activePage == 'profile' ? 'active bg-gradient-info' : '' }} "
                    href="{{ route('profile') }}">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <span class="nav-link-text text-m text-bold ms-1" style="font-size:1rem;">My Profile</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
