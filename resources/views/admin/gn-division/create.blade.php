<div class="modal fade" tabindex="-1" role="dialog" id="newGnDivisionModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New GN Divisions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.gn-division.store') }}" method="post">
                    @csrf

                    <div class="form-group ">
                        <label>Province Name</label>
                        <select name="province" id="province_id"
                            class="form-control @error('province') is-invalid @enderror">
                            <option value="">Select Province</option>
                            @foreach ($province as $item)
                                <option value="{{ $item->id }}">{{ $item->province }}</option>
                            @endforeach
                        </select>
                        @error('province')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>District Name</label>
                        <select name="district" id="district_id"
                            class="form-control @error('district') is-invalid @enderror">
                            <option value="">Select District</option>
                        </select>
                        @error('district')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Divisional Secretariat Name</label>
                        <select name="ds_name" id="ds_id"
                            class="form-control @error('ds_name') is-invalid @enderror">
                            <option value="">Select Divisional Secretariat</option>
                        </select>
                        @error('ds_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="province" class="col-form-label font-weight-bold">GN Division Code</label>
                            <input type="number" class="form-control @error('gn_code') is-invalid @enderror"
                                id="gn_code" name="gn_code" placeholder="Enter GN Division Code" required>
                            @error('gn_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>GN Division</label>
                        <input type="text" name="gn_name" placeholder="Enter GN Division Name"
                            class="form-control @error('gn_name') is-invalid @enderror">
                        @error('gn_name')
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
