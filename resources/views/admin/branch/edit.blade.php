<div class="modal fade" tabindex="-1" role="dialog" id="editBranchModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Branch</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editBranchForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="branch" class="col-form-label font-weight-bold">Branch Name</label>
                        <input type="text" class="form-control @error('branch_update') is-invalid @enderror"
                            id="branch" name="branch_update" required>
                        @error('branch_update')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="floor_name" class="col-form-label font-weight-bold">Floor Number</label>
                        <input type="text" class="form-control @error('floor_name_update') is-invalid @enderror"
                            id="floor_name" name="floor_name_update" required>
                        @error('floor_name_update')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <input type="hidden" id="branch_id" name="branch_id" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
