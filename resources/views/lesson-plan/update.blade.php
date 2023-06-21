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
                                <form method='POST' action="{{ route('update.lesson.plan', $lesson->id) }}">
                                    @csrf
                                    <input type="text" name="updated_by" value="{{ auth()->user()->id }}" hidden>
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Choose Owner</label>
                                            <select class="form-select border border-2 p-2" name="owner" aria-label="" @if(@auth()->user()->isAdmin()) '' @else disabled @endif>
                                                <option value="" selected>Select Owner</option>
                                                @foreach($teachers as $teacher)
                                                <option value="{{ $teacher->id }}" @if($teacher->id == $lesson->owner) {{'selected'}} @endif>{{ $teacher->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('owner')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Status</label>
                                            <select class="form-select border-2 p-2" name="status" aria-label="">
                                                <option value="" selected>Select Status</option>
                                                <option value="edit" {{ $lesson->status == "edit" ? "selected" : '' }}>Edit</option>
                                                <option value="submitted" {{ $lesson->status == "submitted" ? "selected" : '' }}>Submitted</option>
                                                @if(@auth()->user()->isAdmin())
                                                <option value="reviewed" {{ $lesson->status == "reviewed" ? "selected" : '' }}>Reviewed</option>
                                                <option value="approved" {{ $lesson->status == "approved" ? "selected" : '' }}>Approved</option>
                                                @endif
                                                <option value="saved" {{ $lesson->status == "saved" ? "selected" : '' }}>Saved</option>
                                            </select>
                                            @error('status')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Public</label>
                                            <select class="form-select border-2 p-2" name="visibility" aria-label="">
                                                <option value="" selected>Select</option>
                                                <option value="1" {{ $lesson->visibility == 1 ? "selected" : '' }}>Yes</option>
                                                <option value="0" {{ $lesson->visibility == 0 ? "selected" : '' }}>No</option>
                                            </select>
                                            @error('visibility')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Subject</label>
                                            <select class="form-select border-2 p-2" name="subject" aria-label="">
                                                <option value="" selected>Select Subject</option>
                                                @foreach($subjects as $subject)
                                                <option value="{!! $subject->id !!}" @if($subject->id == $lesson->subject) {{'selected'}} @endif>{!! $subject->name !!}</option>
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
                                                <option value="S1" {{ $lesson->class == "S1" ? "selected" : '' }}>Senior One</option>
                                                <option value="S2" {{ $lesson->class == "S2" ? "selected" : '' }}>Senior Two</option>
                                                <option value="S3" {{ $lesson->class == "S3" ? "selected" : '' }}>Senior Three</option>
                                                <option value="S4" {{ $lesson->class == "S4" ? "selected" : '' }}>Senior Four</option>
                                                <option value="S5" {{ $lesson->class == "S5" ? "selected" : '' }}>Senior Five</option>
                                                <option value="S6" {{ $lesson->class == "S6" ? "selected" : '' }}>Senior Six</option>
                                            </select>
                                            @error('class')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">No. of Learners</label>
                                            <input type="number" name="learners_no" class="form-control border border-2 p-2" value="{{ $lesson->learners_no }}">
                                            @error('learners_no')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">No. of Female Learners</label>
                                            <input type="number" name="female_learners" class="form-control border border-2 p-2" value="{{ $lesson->female_learners }}">
                                            @error('female_learners')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">No. of Male Learners</label>
                                            <input type="number" name="male_learners" class="form-control border border-2 p-2" value="{{ $lesson->male_learners }}">
                                            @error('male_learners')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">School Term</label>
                                            <input type="text" name="term" class="form-control border border-2 p-2" value="{{ $lesson->term }}">
                                            @error('term')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Theme</label>
                                            <input type="text" name="theme" class="form-control border border-2 p-2" value="{{ $lesson->theme }}">
                                            @error('theme')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Topic</label>
                                            <input type="text" name="topic" class="form-control border border-2 p-2" value="{{ $lesson->topic }}">
                                            @error('topic')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Competency</label>
                                            <input type="text" name="competency" class="form-control border border-2 p-2" value="{{ $lesson->competency }}">
                                            @error('competency')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Learning outcomes</label>
                                            <textarea name="learning_outcomes" class="form-control border border-2 p-2">{{ $lesson->learning_outcomes }}</textarea>
                                            @error('learning_outcomes')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Generic Skills</label>
                                            <textarea name="generic_skills" class="form-control border border-2 p-2">{{ $lesson->generic_skills}}</textarea>
                                            @error('generic_skills')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Values</label>
                                            <textarea name="values" class="form-control border border-2 p-2">{{ $lesson->values}}</textarea>
                                            @error('values')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Cross-cutting Issues</label>
                                            <textarea name="cross_cutting_issues" class="form-control border border-2 p-2">{{ $lesson->cross_cutting_issues }}</textarea>
                                            @error('cross_cutting_issues')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Key learning outcomes</label>
                                            <textarea name="key_learning_outcomes" class="form-control border border-2 p-2">{{ $lesson->key_learning_outcomes }}</textarea>
                                            @error('key_learning_outcomes')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Pre-requisite Knowledge</label>
                                            <textarea name="pre_requisite_knowledge" class="form-control border border-2 p-2">{{ $lesson->pre_requisite_knowledge }}</textarea>
                                            @error('pre_requisite_knowledge')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Learning materials</label>
                                            <textarea name="learning_materials" class="form-control border border-2 p-2">{{ $lesson->learning_materials}}</textarea>
                                            @error('learning_materials')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Learning methods</label>
                                            <textarea name="learning_methods" class="form-control border border-2 p-2">{{ $lesson->learning_methods }}</textarea>
                                            @error('learning_methods')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">References</label>
                                            <textarea name="references" class="form-control border border-2 p-2">{{ $lesson->references }}</textarea>
                                            @error('references')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Activity Aim</label>
                                            <textarea name="activity_aim" class="form-control border border-2 p-2">{{ $lesson->activity_aim }}</textarea>
                                            @error('activity_aim')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                    </div>
                                    <button type="submit" class="btn bg-gradient-dark btn-submit">Update Lesson Plan <span id="loader"></span></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
