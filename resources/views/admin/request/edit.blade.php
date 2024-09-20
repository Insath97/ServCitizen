<div class="modal fade" tabindex="-1" role="dialog" id="editRequestModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Service Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="editRequest">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_client_name" class="col-form-label font-weight-bold">Client
                                    Name</label>
                                <input type="text" class="form-control" id="edit_client_name" name="edit_client_name"
                                    readonly>
                                <input type="hidden" name="client_id" id="edit_client_id">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_client_number" class="col-form-label font-weight-bold">Client
                                    Number</label>
                                <input type="text" class="form-control" id="edit_client_number" name="client_number"
                                    readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_service_type_id" class="col-form-label font-weight-bold">Service
                                    Type</label>
                                <select name="service_type_id" id="edit_service_type_id"
                                    class="form-control @error('service_type_id') is-invalid @enderror">
                                    <option value="">Select Service Type</option>
                                    @foreach ($service_types as $service_type)
                                        <option value="{{ $service_type->id }}">{{ $service_type->name }}</option>
                                    @endforeach
                                </select>
                                @error('service_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_service_id" class="col-form-label font-weight-bold">Service</label>
                                <select name="service_id" id="edit_service_id"
                                    class="form-control @error('service_id') is-invalid @enderror">
                                    <option value="">Select Service</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                    @endforeach
                                </select>
                                @error('service_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edit_status_id" class="col-form-label font-weight-bold">Status</label>
                                <select name="status_id" id="edit_status_id"
                                    class="form-control @error('status_id') is-invalid @enderror">
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->status_name }}</option>
                                    @endforeach
                                </select>
                                @error('status_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edit_notes" class="col-form-label font-weight-bold">Notes</label>
                                <textarea name="notes" id="edit_notes" class="form-control @error('notes') is-invalid @enderror" rows="4"
                                    placeholder="Additional notes..."></textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
            </div>

            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
