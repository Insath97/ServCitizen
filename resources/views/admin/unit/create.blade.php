<div class="modal fade" tabindex="-1" role="dialog" id="newSubUnitModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Sub Unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createSubUnitForm" action="{{ route('admin.units.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="unit_name" class="col-form-label font-weight-bold">Sub Unit Name</label>
                        <input type="text" class="form-control @error('unit_name') is-invalid @enderror"
                               id="unit_name" name="unit_name" placeholder="Enter sub unit name" required>
                        @error('unit_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="branch_id" class="col-form-label font-weight-bold">Branch Name</label>
                        <select name="branch_id" id="branch_id" class="form-control select2 @error('branch_id') is-invalid @enderror" required>
                            <option value="">Select Branch</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                        @error('branch_id')
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
