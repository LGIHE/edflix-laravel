<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <x-navbars.sidebar activePage="subjects"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100 pb-5">
        <!-- Navbar -->
        <x-navbars.topbar titlePage='Update Subject'></x-navbars.topbar>
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
                        @elseif (session('error'))
                            <div class="row">
                                <div class="alert alert-danger alert-dismissible text-white" role="alert">
                                    <span class="text-sm">{{ Session::get('error') }}</span>
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
                                            <h6 class="mb-3">School Information</h6>
                                        </div>
                                    </div>
                                </div>
                                <form method='POST' action="{{ route('update.subject', $subject->id) }}">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name" class="form-control border border-2 p-2" value='{{ $subject->name }}'>
                                            @error('name')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">UNEB Code</label>
                                            <input type="text" name="code" class="form-control border border-2 p-2" value='{{ $subject->code }}'>
                                            @error('code')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Short Name</label>
                                            <input type="text" name="short" class="form-control border border-2 p-2" value='{{ $subject->short }}'>
                                            @error('address')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Level</label>
                                            <select class="form-select border border-2 p-2" name="level" aria-label="">
                                                <option vlaue="Select Level" {{ $subject->level == "Select Level" ? "selected" : '' }}>Select Level</option>
                                                <option value="UACE" {{ $subject->level == "UACE" ? "selected" : '' }}>UACE</option>
                                                <option value="UCE" {{ $subject->level == "UCE" ? "selected" : '' }}>UCE</option>
                                            </select>
                                            @error('city')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Description</label>
                                            <input type="text" name="description" class="form-control border border-2 p-2" value='{{ $subject->description }}'>
                                            @error('description')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>
                                    </div>
                                    <button type="submit" class="btn bg-gradient-dark">Update Subject</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
