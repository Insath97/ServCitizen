<div class="modal fade" id="updateServiceTypeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Service Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateServiceTypeForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="service_type" class="col-form-label font-weight-bold">Service Type Code</label>
                        <input type="text"
                            class="form-control @error('service_type_code_update') is-invalid @enderror"
                            name="service_type_code_update" placeholder="Enter service type code" required>
                        @error('service_type_code_update')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="service_type" class="col-form-label font-weight-bold">Service Type Name</label>
                        <input type="text" class="form-control @error('service_type') is-invalid @enderror"
                            id="service_type" name="service_type_update" required>
                        @error('service_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <input type="hidden" name="id" id="service_type_id">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
