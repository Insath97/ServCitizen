<div class="modal fade" tabindex="-1" role="dialog" id="newBranchModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New District</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.district.store') }}" method="POST">
                    @csrf

                    <div class="form-group ">
                        <label>Province Name</label>
                        <select name="province" class="form-control @error('province') is-invalid @enderror">
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
                        <label for="province" class="col-form-label font-weight-bold">District Code</label>
                        <input type="number" class="form-control @error('district_code') is-invalid @enderror"
                            id="district_code" name="district_code" placeholder="Enter district code" required>
                        @error('district_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>District</label>
                        <input type="text" name="district"
                            class="form-control @error('district') is-invalid @enderror"
                            placeholder="Enter District Name" required>
                        @error('district')
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
