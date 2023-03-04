<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <x-navbars.sidebar activePage="lesson-plans"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100 pb-5">
        <!-- Navbar -->
        <x-navbars.topbar titlePage='Lesson Plan'></x-navbars.topbar>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4 mt-5">
            <div class="card card-body mx-3 mx-md-4 ">

                <div class="card card-plain h-100">
                    <div class="card-body p-3">
                        @if (session('status'))
                        <div class="row">
                            <div class="alert alert-success alert-dismissible text-white" role="alert">
                                <span class="text-sm">{{ Session::get('status') }}</span>
                                <button type="button" class="btn-close text-lg py-3 opacity-10"
                                    data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        @endif
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="bio-form">
                                <div class="card-header pb-0 p-2 pt-0">
                                    <div class="row mb-5">
                                        <div class="col-md-8 d-flex align-items-center">
                                            <h6 class="mb-3">{{ $lesson->topic }}</h6>
                                        </div>
                                        <div class="col-md-2 d-flex ">
                                            <a class="btn bg-gradient-success mb-0 end">
                                                <i class="material-icons text-sm">edit</i>&nbsp;&nbsp;Edit
                                            </a>
                                        </div>
                                        <div class="col-md-2 d-flex ">
                                            <a class="btn bg-gradient-info mb-0 end">
                                                <i class="material-icons text-sm">download</i>&nbsp;&nbsp;Download
                                            </a>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 d-flex">
                                            <p class="text-dark font-weight-bold">Subject:</p>&nbsp;
                                            <p class="text-dark">{{ $subject->name }}</p>
                                        </div>
                                        <div class="col-md-4 d-flex">
                                            <p class="text-dark font-weight-bold">Class:</p>&nbsp;
                                            <p class="text-dark">{{ $lesson->class }}</p>
                                        </div>
                                        <div class="col-md-4 d-flex">
                                            <p class="text-dark font-weight-bold">No. of Learners:</p>&nbsp;
                                            <p class="text-dark">{{ $lesson->learners_no }}</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 d-flex">
                                            <p class="text-dark font-weight-bold">Theme:</p>&nbsp;
                                            <p class="text-dark">{{ $lesson->theme }}</p>
                                        </div>
                                        <div class="col-md-4 d-flex">
                                            <p class="text-dark font-weight-bold">Status:</p>&nbsp;
                                            <p class="text-dark">{{ ucfirst(trans($lesson->status)) }}</p>
                                        </div>
                                        <div class="col-md-4 d-flex">
                                            <p class="text-dark font-weight-bold">Public:</p>&nbsp;
                                            <p class="text-dark">@if ($lesson->visibility == 1) {{ 'Yes' }} @else {{ 'No' }} @endif</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 d-flex">
                                            <p class="text-dark font-weight-bold">Duration:</p>&nbsp;
                                            <p class="text-dark">0</p>
                                        </div>
                                        <div class="col-md-4 d-flex">
                                            <p class="text-dark font-weight-bold">Owner:</p>&nbsp;
                                            <p class="text-dark">{{ $owner->name }} ({{ $school->name }})</p>
                                        </div>
                                        <div class="col-md-4 d-flex">
                                            <p class="text-dark font-weight-bold">Last Edited:</p>&nbsp;
                                            <p class="text-dark">{{ $lesson->updated_at }}</p>
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

<script>
