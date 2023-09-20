<style>

    .select2-container--default .select2-selection--single {
        padding: 4px;
        border: 1px solid #d2d6da !important;
    }

    .select2-container .select2-selection--single {
        height: 38px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #7b809a !important;
        font-size: 0.875rem !important;
        font-weight: 400 !important;
    }
</style>
<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <x-navbars.sidebar activePage="lesson-plans"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100 pb-5">
        <!-- Navbar -->
        <x-navbars.topbar titlePage='Lesson Plan'></x-navbars.topbar>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4 mt-2">
            <div class="card card-body mx-3 mx-md-4 ">
                <div class="card card-plain h-100">
                    <div class="card-body p-3">
                        <div class=" me-3 my-3 text-end">
                            <a class="btn bg-gradient-info mb-0" href="{{ asset('assets') }}/download/act_now_lp_template.docx">
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
                                            <h4 class="mb-3">Upload Lesson Plan</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 d-flex align-items-center">
                                            <h6 class="mb-3"><u>Instructions</u> <span class="text-primary">*</span></h6>
                                        </div>
                                    </div>
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
                                        <div class="col-md-9 d-flex">
                                            <ol>
                                                <li>First, download the upload example file using the blue button above.</li>
                                                <li>Edit the file on your computer /tablet /phone and save it.</li>
                                                <li>The file has 2 tables i.e. <strong>Table 1 is for Preliminary Information</strong> and <strong>Table 2 for steps</strong></li>
                                                <li>The class cell<strong>MUST</strong> be in the form of <strong>S1, S2, S3, S4, S5, S6</strong>. For example S1 is Senior 1</li>
                                                <li>The term cell <strong>MUST</strong> be in the form of <strong>1, 2, 3</strong>. For example 1 is Term 1</li>
                                                <li>Demo data has been added and it sould be follwoed the way it is input.</li>
                                                <li>You can add another row for a new step on the Steps table, and you can add as many they are available for your lesson.</li>
                                                <li>Upload the saved file in the upload section below:
                                                    <ul>
                                                        <li>Make sure you select the subject for the lesson plan.</li>
                                                        <li>Click on the choose file, and select the file you saved.</li>
                                                        <li>Then click on the upload button.</li>
                                                    </ul>
                                                </li>
                                            </ol>
                                        </div>
                                        <div class="card ">
                                            <div class="card-header"><h5>Upload Section</h5></div>
                                                <form action="{{ route('upload.lesson.plan') }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <p class="card-text mb-2 font-weight-bold">Select Teacher for the Lesson Plan</p>
                                                    @if(auth()->user()->isAdmin())
                                                    <div class="mb-3 col-md-6">
                                                        <select id="teacher-records" class="form-select border-2 p-2" name="teacher" aria-label="">
                                                            <option value="" selected>Select Teacher</option>
                                                            @foreach($teachers as $teacher)
                                                            <option value="{!! $teacher->id !!}">{!! $teacher->name !!}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @endif

                                                    <p class="card-text mb-2 font-weight-bold">Select Subject for the Lesson Plan</p>
                                                    <div class="mb-3 col-md-6">
                                                        <select id="subject-records" class="form-select border-2 p-2" name="subject" aria-label="">
                                                            <option value="" selected>Select Subject</option>
                                                            @foreach($subjects as $subject)
                                                            <option value="{!! $subject->id !!}">{!! $subject->name !!}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <p class="card-text mt-3 mb-2"><strong>Select File to Upload</strong> - <small class="text-muted">{{__('Please upload only Microsoft Word (.docx or .doc) files')}}</small></p>
                                                    {{-- <input type="file" id="lpFile" name="lesson_plan_file" accept=".doc,.docx"> --}}
                                                    {{-- <input type="file" id="lpFile" name="lesson_plan_file" accept=".xls,.xlsx"> --}}
                                                    <input type="file" id="lpFile" name="lesson_plan_file" accept=".doc,.docx">
                                                    <button type="submit" class="btn btn-success mt-4">Upload Lesson Plan</button>
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

<script>
    $(document).ready(function() {
        $('#teacher-records').select2();
        $('#subject-records').select2();
    });
</script>
