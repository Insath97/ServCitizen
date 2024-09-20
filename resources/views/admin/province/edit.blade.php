<!-- Edit Province Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editProvinceModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Province</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editProvinceForm" action="" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="province" class="col-form-label font-weight-bold">Province Code</label>
                        <input type="number" class="form-control @error('province_code_update') is-invalid @enderror"
                               id="province_code_update" name="province_code_update" placeholder="Enter province code" required>
                        @error('province_code_update')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="province" class="col-form-label font-weight-bold">Province Name</label>
                        <input type="text" class="form-control @error('province_update') is-invalid @enderror"
                               id="province_update" name="province_update" required>
                        @error('province_update')
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
