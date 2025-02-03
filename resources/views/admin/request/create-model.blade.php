<div class="modal fade" tabindex="-1" role="dialog" id="newRequestModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Service Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.service-request.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="client_name" class="col-form-label font-weight-bold">Client Name</label>
                                <input type="text" class="form-control" id="client_name" name="client_name" readonly>
                                <input type="hidden" name="client_id" id="client_id">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="client_number" class="col-form-label font-weight-bold">Client Number</label>
                                <input type="text" class="form-control" id="client_number" readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="service_type_id" class="col-form-label font-weight-bold">Service
                                    Type</label>
                                <select name="service_type_id" id="service_type_id"
                                    class="form-control select2 @error('service_id') is-invalid @enderror">
                                    <option value="">Select a service type</option>
                                    @foreach ($service_types as $service_type)
                                        <option value="{{ $service_type->id }}">{{ $service_type->code }} -
                                            {{ $service_type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('service_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="service_id" class="col-form-label font-weight-bold">Service</label>
                                <select name="service_id" id="service_id"
                                    class="form-control @error('service_id') is-invalid @enderror">
                                    <option value="" selected>Select a service</option>
                                </select>
                                @error('service_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12" id="subservice-container" style="display:none;">
                            <div class="form-group">
                                <label for="subservice_id" class="col-form-label font-weight-bold">Sub Service</label>
                                <select name="subservice_id" id="subservice_id"
                                    class="form-control @error('subservice_id') is-invalid @enderror">
                                    <option value="" selected>Select a subservice</option>
                                </select>
                                @error('subservice_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="status_id" class="col-form-label font-weight-bold">Status</label>
                                <select name="status_id" id="status_id"
                                    class="form-control @error('status_id') is-invalid @enderror">
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->status_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="notes" class="col-form-label font-weight-bold">Notes</label>
                                <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="4"
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
                <button type="submit" class="btn btn-primary">Save Request</button>
            </div>
            </form>
        </div>
    </div>
</div>
