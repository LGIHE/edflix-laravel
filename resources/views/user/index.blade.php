<x-layout bodyClass="g-sidenav-show  bg-gray-200">

    <x-navbars.sidebar activePage="users"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.topbar titlePage="Users"></x-navbars.topbar>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class=" me-3 my-3 text-end">
                            <a class="btn bg-gradient-dark mb-0 end" data-bs-toggle="modal" data-bs-target="#newUserModal">
                                <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add New User
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
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-secondary text-xxl font-weight-bolder">Name</th>
                                            <th class="text-secondary text-xxl font-weight-bolder">Email</th>
                                            <th class="text-secondary text-xxl font-weight-bolder">Username</th>
                                            <th class="text-secondary text-xxl font-weight-bolder">School</th>
                                            <th class="text-secondary text-xxl font-weight-bolder">Role</th>
                                            <th class="text-secondary"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $users as $user )

                                        <tr>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center px-3 py-1">
                                                    <h6 class="mb-0 text-m">{{ $user->name }}</h6>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center px-3 py-1">
                                                    <p class="text-m text-dark font-weight-bold mb-0">{{ $user->email }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center px-3 py-1">
                                                    <p class="text-m text-dark font-weight-bold mb-0">{{ $user->email }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center px-3 py-1">
                                                    <span class="text-dark text-m font-weight-bold">Luigi Giussani High School</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center px-3 py-1">
                                                    <span class="text-dark text-m font-weight-bold">{{ $user->role }}</span>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <a rel="tooltip" class="btn btn-success btn-link" id="open-update" data-value="{{ $user->id }}">
                                                    <i class="material-icons">edit</i>
                                                    <div class="ripple-container"></div>
                                                </a>

                                                <button type="button" class="btn btn-danger btn-link" data-bs-toggle="modal" data-bs-target="#deleteModal-{{$user->id}}" title="Delete User">
                                                    <i class="material-icons">delete</i>
                                                    <div class="ripple-container"></div>
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Confirm School Delete modal -->
                                        <div class="modal fade" id="deleteModal-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-sm" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirm</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body" id="smallBody">
                                                            <div class="text-center">
                                                                <span class="">Are you sure you want to Delete this User?</span>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer align-items-center">
                                                            <button type="button" class="btn btn-success" id="del-btn" data-value="{{ route('delete.user', $user->id) }}">Confirm</button>
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>

<script>
    $(document).on('click', '#del-btn', function(event) {
        event.preventDefault();
        let href = $(this).data('value');
        // console.log(href);
        window.location.assign(href);
    });

    $(document).on('click','#open-update',function(){
        var user_id = $(this).data("value");
        var url = '{{route("get.user",":id")}}';
        url = url.replace(':id', user_id);
        window.location.assign(url);
    });
</script>

@include('user.create')
