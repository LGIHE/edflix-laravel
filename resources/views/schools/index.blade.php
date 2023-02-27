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
                        <div class="card-body px-0 pb-2">
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
                                        <tr>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center px-3 py-1">
                                                    <h6 class="mb-0 text-m">Luigi Giussani High School</h6>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center px-3 py-1">
                                                    <p class="text-m text-dark font-weight-bold mb-0">Kireka</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center px-3 py-1">
                                                    <p class="text-m text-dark font-weight-bold mb-0">Kireka</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center px-3 py-1">
                                                    <span class="text-dark text-m font-weight-bold">Kampala</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center px-3 py-1">
                                                    <span class="text-dark text-m font-weight-bold">school@mail.com</span>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <a rel="tooltip" class="btn btn-success btn-link" data-bs-toggle="modal" data-bs-target="#updateSchoolModal">
                                                    <i class="material-icons">edit</i>
                                                    <div class="ripple-container"></div>
                                                </a>

                                                <button type="button" class="btn btn-danger btn-link" data-original-title="" title="">
                                                    <i class="material-icons">delete</i>
                                                    <div class="ripple-container"></div>
                                                </button>
                                            </td>
                                        </tr>
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

@include('schools.create')
@include('schools.update')
