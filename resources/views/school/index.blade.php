<x-layout bodyClass="g-sidenav-show  bg-gray-200">

    <x-navbars.sidebar activePage="schools"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.topbar titlePage="Users"></x-navbars.topbar>
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
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-secondary text-xxl font-weight-bolder">Name</th>
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
                                                    <div class="d-flex flex-column justify-content-center px-3 py-1">
                                                        <h6 class="mb-0 text-m">{{ $school->name }}</h6>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center px-3 py-1">
                                                        <p class="text-m text-dark font-weight-bold mb-0">{{ $school->address }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center px-3 py-1">
                                                        <p class="text-m text-dark font-weight-bold mb-0">{{ $school->city }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center px-3 py-1">
                                                        <span class="text-dark text-m font-weight-bold">{{ $school->district }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center px-3 py-1">
                                                        <span class="text-dark text-m font-weight-bold">{{ $school->email }}</span>
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <a rel="tooltip" class="btn btn-success btn-link open_modal" data-value="{{ $school->id }}">
                                                    <!-- <a rel="tooltip" class="btn btn-success btn-link" data-bs-toggle="modal" data-bs-target="#updateSchoolModal"> -->
                                                        <i class="material-icons">edit</i>
                                                        <div class="ripple-container"></div>
                                                    </a>

                                                    <button type="button" class="btn btn-danger btn-link" data-original-title="" title="">
                                                        <i class="material-icons">delete</i>
                                                        <div class="ripple-container"></div>
                                                    </button>
                                                </td>
                                            </tr>
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
    $(document).on('click','.open_modal',function(){
        var school_id = $('.open_modal').data("value");
        var url = '{{route("get.school",":id")}}';
        url = url.replace(':id', school_id);

        console.log(school_id);

        $.get(url, function (data) {
            //success data
            console.log(data);
            $('[name=id]').val(data.id);
            $('[name=name]').val(data.name);
            $('[name=email]').val(data.email);
            $('[name=address]').val(data.address);
            $('[name=city]').val(data.city);
            $('[name=district]').val(data.district);
            $('#updateSchoolModal').modal('show');
        })
    });
</script>

@include('school.create')
@include('school.update')
