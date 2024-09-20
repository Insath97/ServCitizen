<div class="modal fade" tabindex="-1" role="dialog" id="editPermissionModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Permission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="editPermission">

                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="permission_group" class="col-form-label font-weight-bold">Permission Group</label>
                        <input type="text" class="form-control @error('permission_group_update') is-invalid @enderror"
                            id="permission_group" name="permission_group_update" value=""
                            placeholder="Enter Permission Group" required>
                        @error('permission_group_update')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="permission" class="col-form-label font-weight-bold">Permission Title</label>
                        <input type="text" class="form-control @error('permission_update') is-invalid @enderror"
                            id="permission" name="permission_update" value=""
                            placeholder="Enter Permission Title" required>
                        @error('permission_update')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
