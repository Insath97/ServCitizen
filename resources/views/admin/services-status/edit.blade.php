<div class="modal fade" tabindex="-1" role="dialog" id="editServiceStatusModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Service Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editServiceStatusForm" action="" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="status_name" class="col-form-label font-weight-bold">Status Name</label>
                        <input type="text" name="status_name_update"
                               class="form-control @error('status_name_update') is-invalid @enderror"
                               id="status_name" required>
                        @error('status_name_update')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status_color" class="col-form-label font-weight-bold">Color Code</label>
                        <div class="input-group colorpickerinput">
                            <input type="text"
                                   class="form-control @error('status_color_update') is-invalid @enderror"
                                   name="status_color_update" id="status_color" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="fas fa-fill-drip"></i>
                                </div>
                            </div>
                            @error('status_color_update')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
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
