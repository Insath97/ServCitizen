<div class="modal fade" tabindex="-1" role="dialog" id="editGnDivisionModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit GN Division</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="editGnDivisionForm">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Divisional Secretariat Name</label>
                        <select name="ds_name_update" id="ds_id_update"
                            class="form-control @error('ds_name_update') is-invalid @enderror">
                            <option value="">Select Divisional Secretariat</option>
                            @foreach ($division as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('ds_name_update')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="province" class="col-form-label font-weight-bold">GN Division Code</label>
                            <input type="number" class="form-control @error('gn_code_update') is-invalid @enderror"
                                id="gn_code_update" name="gn_code_update" placeholder="Enter GN Division Code" required>
                            @error('gn_code_update')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>GN Division</label>
                        <input type="text" name="gn_name_update" placeholder="Enter GN Division Name"
                            class="form-control @error('gn_name_update') is-invalid @enderror">
                        @error('gn_name_update')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
