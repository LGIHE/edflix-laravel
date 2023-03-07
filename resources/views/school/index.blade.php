<x-layout bodyClass="g-sidenav-show  bg-gray-200">

    <x-navbars.sidebar activePage="schools"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.topbar titlePage="Schools"></x-navbars.topbar>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class=" me-3 my-3 text-end">
                            <a class="btn bg-gradient-dark mb-0 end" data-bs-toggle="modal" data-bs-target="#newSchoolModal">
                                <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add New School
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
                            @if (count($schools) > 0)
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0" id="table">
                                        <thead>
                                            <tr>
                                                <th class="text-secondary text-xxl font-weight-bolder px-4">Name</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">Address</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">City</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">District</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">Email</th>
                                                <th class="text-secondary"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($schools as $school)
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center px-2">
                                                        <h6 class="mb-0 text-m">{{ $school->name }}</h6>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <p class="text-m text-dark font-weight-bold mb-0">{{ $school->address }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <p class="text-m text-dark font-weight-bold mb-0">{{ $school->city }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <span class="text-dark text-m font-weight-bold">{{ $school->district }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <span class="text-dark text-m font-weight-bold">{{ $school->email }}</span>
                                                    </div>
                                                </td>
                                                <td class="align-middle not-export-col">
                                                    <a rel="tooltip" class="btn btn-success btn-link" id="open-update" data-value="{{ $school->id }}">
                                                        <i class="material-icons">edit</i>
                                                        <div class="ripple-container"></div>
                                                    </a>

                                                    <a class="btn btn-danger btn-link" data-bs-toggle="modal" data-bs-target="#deleteModal-{{$school->id}}" title="Delete Project">
                                                        <i class="material-icons ">delete</i>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- School Update Modal -->
                                            <!--  -->
                                            <!-- Confirm School Delete modal -->
                                            <div class="modal fade" id="deleteModal-{{ $school->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
                                                            <button type="button" class="btn btn-success" id="del-btn" data-value="{{ route('delete.school', $school->id) }}">Confirm</button>
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
                                <div class="container text-center m-2 p-5">
                                    <span class="display-6 font-weight-bold">No Schools Added Yet.</span>
                                </div>
                            @endif
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
        window.location.assign(href);
    });

    $(document).on('click','#open-update',function(){
        var school_id = $(this).data("value");
        var url = '{{route("get.school",":id")}}';
        url = url.replace(':id', school_id);
        window.location.assign(url);
    });


</script>

@include('school.create')
