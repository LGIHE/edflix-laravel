<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <x-navbars.sidebar activePage="users"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100 pb-5">
        <!-- Navbar -->
        <x-navbars.topbar titlePage='Users'></x-navbars.topbar>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4 mt-2">
            <div class="card card-body mx-3 mx-md-4 ">
                <div class="card card-plain h-100">
                    <div class="card-body p-3">
                        <div class=" me-3 my-3 text-end">
                            <a class="btn bg-gradient-info mb-0" href="{{ asset('assets') }}/download/edflix_lesson_plan.xlsx">
                                <i class="material-icons text-sm">download</i>&nbsp;&nbsp;Download Example LP
                            </a>
                        </div>
                        @if (count($errors) > 0)
                        <div class="row">
                            <div class="alert alert-danger alert-dismissible text-white col-md-8" role="alert">
                                <ul class="text-sm">
                                    @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close text-lg py-3 opacity-10"
                                    data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        @endif
                        <div class="tab-content">
                            <div class="tab-pane fade active show">
                                <div class="card-header pb-0 p-3">
                                    <div class="row">
                                        <div class="col-md-8 d-flex align-items-center">
                                            <h4 class="mb-3">Upload Teachers</h4>
                                        </div>
                                    </div>
                                    {{-- <div class="row">
                                        <div class="col-md-8 d-flex align-items-center">
                                            <h6 class="mb-3"><u>Instructions</u> <span class="text-primary">*</span></h6>
                                        </div>
                                    </div> --}}
                                    <div class="row">
                                        {{-- <div class="col-md-9 d-flex">
                                            <ol>
                                                <li>First, download the upload example file using the blue button above.</li>
                                                <li>Edit the file on your computer /tablet /phone and save it.</li>
                                                <li>The file has 2 sheets i.e. <strong>Sheet1 is for Preliminary Information</strong> and <strong>Sheet2 for steps</strong></li>
                                                <li>The class colum should be in the form of <strong>S1, S2, S3, S4, S5, S6</strong>. For example S1 is Senior 1</li>
                                                <li>Upload the file in the upload section below:
                                                    <ul>
                                                        <li>Click on the choose file, and select the file you saved.</li>
                                                        <li>Then click on the upload button.</li>
                                                    </ul>
                                                </li>
                                                <li>The steps on Sheet2 should be on seperate rows</li>
                                            </ol>
                                        </div> --}}
                                        <div class="card ">
                                            {{-- <div class="card-header"><h5>Upload Section</h5></div> --}}
                                                <form action="{{ route('upload.teachers') }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <p class="card-text mt-3 mb-2"><strong>Select File to Upload</strong> - <small class="text-muted">{{__('Please upload only Excel (.xlsx or .xls) files')}}</small></p>
                                                    <input type="file" id="teacherFile" name="teacher_upload" accept=".xls,.xlsx">
                                                    <button type="submit" class="btn btn-success mt-4">Upload Teachers</button>
                                                </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
