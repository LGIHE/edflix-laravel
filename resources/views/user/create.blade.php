<style>
    .btn-close{
        color: #000;
        background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
    }

    #newSchoolModalLabel {
        font-family: var(--bs-body-font-family)!important;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="newUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="newUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="newUserModalLabel">Add New User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method='POST' action='{{ route('create-user') }}'>
                    @csrf
                    <div class="row">

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control border border-2 p-2">
                            @error('name')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control border border-2 p-2">
                            @error('email')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="number" name="phone" class="form-control border border-2 p-2">
                            @error('phone')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-control border border-2 p-2">
                            @error('location')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label role">Role</label>
                            <select class="form-select" aria-label=".role">
                                <option selected>Select User Role</option>
                                <option value="Administrator">System Admin</option>
                                <option value="Facilitator">Facilitator</option>
                                <option value="Teacher">Teacher</option>
                            </select>
                            @error('role')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password" name="location" class="form-control border border-2 p-2">
                            @error('password')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-9">
                            <label class="form-label">School</label>
                            <input type="text" name="location" class="form-control border border-2 p-2">
                            @error('school')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-3"></div>

                        <div class="mb-3 col-md-4">
                            <label class="form-label subject-1">Subject 1</label>
                            <select class="form-select" aria-label=".subject-1">
                                <option selected>Select Subject</option>
                                <option value="1">Mathematics</option>
                                <option value="2">Biology</option>
                                <option value="3">History</option>
                            </select>
                        </div>

                        <div class="mb-3 col-md-4">
                            <label class="form-label subject-2">Subject 2</label>
                            <select class="form-select" aria-label=".subject-2">
                                <option selected>Select Subject</option>
                                <option value="1">Mathematics</option>
                                <option value="2">Biology</option>
                                <option value="3">History</option>
                            </select>
                        </div>

                        <div class="mb-3 col-md-4">
                            <label class="form-label subject-3">Subject 3</label>
                            <select class="form-select" aria-label=".subject-3">
                                <option selected>Select Subject</option>
                                <option value="1">Mathematics</option>
                                <option value="2">Biology</option>
                                <option value="3">History</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Add User</button>
            </div>
        </div>
    </div>
</div>
