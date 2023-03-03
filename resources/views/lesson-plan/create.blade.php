<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <x-navbars.sidebar activePage="lesson-plan"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100 pb-5">
        <!-- Navbar -->
        <x-navbars.topbar titlePage='Update User'></x-navbars.topbar>
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
                                <div class="card-header pb-0 p-3">
                                    <div class="row">
                                        <div class="col-md-8 d-flex align-items-center">
                                            <h6 class="mb-3">Preliminary Information</h6>
                                        </div>
                                    </div>
                                </div>
                                <form method='POST' action="">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Owner</label>
                                            <input type="text" name="owner" class="form-control border border-2 p-2">
                                            @error('owner')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Status</label>
                                            <select class="form-select border-2 p-2" name="status" aria-label="">
                                                <option value="" selected>Select Status</option>
                                                <option value="edit">Edit</option>
                                                <option value="submitted">Submitted</option>
                                                <option value="reviewed">Reviewed</option>
                                                <option value="approved">Approved</option>
                                                <option value="saved">Saved</option>
                                            </select>
                                            @error('status')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Public</label>
                                            <select class="form-select border-2 p-2" name="visibility" aria-label="">
                                                <option value="" selected>Select</option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                            @error('visibility')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Topic</label>
                                            <input type="text" name="topic" class="form-control border border-2 p-2">
                                            @error('topic')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Subject</label>
                                            <select class="form-select border-2 p-2" name="subject" aria-label="">
                                                <option value="" selected>Select Subject</option>
                                                @foreach($subjects as $subject)
                                                <option value="{!! $subject->id !!}">{!! $subject->name !!}</option>
                                                @endforeach
                                            </select>
                                            @error('subject')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Class</label>
                                            <select class="form-select border-2 p-2" name="class" aria-label="">
                                                <option value="" selected>Select Subject</option>
                                                <option value="1">Senior One</option>
                                                <option value="2">Senior Two</option>
                                                <option value="3">Senior Three</option>
                                                <option value="4">Senior Four</option>
                                                <option value="5">Senior Five</option>
                                                <option value="6">Senior Six</option>
                                            </select>
                                            @error('class')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">No. of Learners</label>
                                            <input type="number" name="learners_no" class="form-control border border-2 p-2">
                                            @error('learners_no')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Theme</label>
                                            <input type="text" name="theme" class="form-control border border-2 p-2">
                                            @error('theme')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Learning outcomes</label>
                                            <textarea name="learning_outcomes" class="form-control border border-2 p-2"></textarea>
                                            @error('learning_outcomes')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Generic Skills</label>
                                            <textarea name="generic_skills" class="form-control border border-2 p-2"></textarea>
                                            @error('generic_skills')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Values</label>
                                            <textarea name="values" class="form-control border border-2 p-2"></textarea>
                                            @error('values')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Cross-cutting Issues</label>
                                            <textarea name="cross_cutting" class="form-control border border-2 p-2"></textarea>
                                            @error('cross_cutting')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Key learning outcomes</label>
                                            <textarea name="key_learning_outcomes" class="form-control border border-2 p-2"></textarea>
                                            @error('key_learning_outcomes')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Pre-requisite Knowledge</label>
                                            <textarea name="pre_requisite_knowledge" class="form-control border border-2 p-2"></textarea>
                                            @error('pre_requisite_knowledge')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Learning materials</label>
                                            <textarea name="learning_materials" class="form-control border border-2 p-2"></textarea>
                                            @error('learning_materials')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Learning methods</label>
                                            <textarea name="learning_methods" class="form-control border border-2 p-2"></textarea>
                                            @error('learning_methods')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">References</label>
                                            <textarea name="references" class="form-control border border-2 p-2"></textarea>
                                            @error('references')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                    </div>
                                    <button type="submit" class="btn bg-gradient-dark">Start Lesson Plan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>

