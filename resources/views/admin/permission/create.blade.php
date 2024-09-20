<div class="modal fade" tabindex="-1" role="dialog" id="createPermission">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Province</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.permission.store') }}" method="POST">

                    @csrf

                    <div class="form-group">
                        <label for="province" class="col-form-label font-weight-bold">Permission Group</label>
                        <input type="text" class="form-control @error('permission_group') is-invalid @enderror"
                            id="permission_group" name="permission_group" placeholder="Enter Permission Group" required>
                        @error('permission_group')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="province" class="col-form-label font-weight-bold">Permission Title</label>
                        <input type="text" class="form-control @error('permission') is-invalid @enderror"
                            id="permission" name="permission" placeholder="Enter Permission" required>
                        @error('permission')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
