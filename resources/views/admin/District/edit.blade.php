<div class="modal fade" tabindex="-1" role="dialog" id="editDistrictModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit District</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editDistrictForm" action="" method="POST">
                    @csrf
                    @method('PUT')


                    <div class="form-group">
                        <label for="province">Province Name</label>
                        <select name="province_update" id="province"
                            class="form-control @error('province_update') is-invalid @enderror" required>
                            <option value="">Select Province</option>
                            @foreach ($province as $item)
                                <option value="{{ $item->id }}">{{ $item->province }}</option>
                            @endforeach
                        </select>
                        @error('province_update')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="province" class="col-form-label font-weight-bold">District Code</label>
                        <input type="number" class="form-control @error('district_code_update') is-invalid @enderror"
                            id="district_code_update" name="district_code_update" placeholder="Enter district code" required>
                        @error('district_code_update')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">district_update
                        <label for="district">District</label>
                        <input type="text" name="district_update" id="district"
                            class="form-control @error('district_update') is-invalid @enderror"
                            placeholder="Enter District Name" required>
                        @error('district_update')
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
