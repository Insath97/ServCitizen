<div class="modal fade" tabindex="-1" role="dialog" id="newServiceTypeModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Service Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.service-type.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="service_type" class="col-form-label font-weight-bold">Service Type Code</label>
                        <input type="text" class="form-control @error('service_type_code') is-invalid @enderror"
                            id="service_type" name="service_type_code" placeholder="Enter service type code" required>
                        @error('service_type_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="service_type" class="col-form-label font-weight-bold">Service Type Name</label>
                        <input type="text" class="form-control @error('service_type') is-invalid @enderror"
                            id="service_type" name="service_type" placeholder="Enter service type name" required>
                        @error('service_type')
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
