<div class="modal fade" tabindex="-1" role="dialog" id="newDivisionModal">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Divisional Secretariat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.division.store') }}" method="post">
                    @csrf

                    <!-- Province and District -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
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

                        <div class="form-group col-md-6">
                            <label>District Name</label>
                            <select name="district" id="district_id"
                                class="form-control @error('district') is-invalid @enderror">
                                <option value="">Select District</option>
                                @foreach ($districts as $item)
                                    <option value="{{ $item->id }}">{{ $item->district }}</option>
                                @endforeach
                            </select>
                            @error('district')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="province" class="col-form-label font-weight-bold">Divisional Secretariat
                                Code</label>
                            <input type="number" class="form-control @error('ds_code') is-invalid @enderror"
                                id="ds_code" name="ds_code" placeholder="Enter Divisional Secretariat code" required>
                            @error('ds_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Divisional Secretariat and Address -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Divisional Secretariat</label>
                            <input type="text" name="ds_name"
                                class="form-control @error('ds_name') is-invalid @enderror"
                                placeholder="Enter Divisional Secretariat Name" required>
                            @error('ds_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Address</label>
                            <input type="text" name="address"
                                class="form-control @error('address') is-invalid @enderror" placeholder="Enter Address">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Telephone, Fax, Email, and DS Officer -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Telephone</label>
                            <input type="text" name="telephone"
                                class="form-control @error('telephone') is-invalid @enderror"
                                placeholder="Enter Telephone Number">
                            @error('telephone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Fax</label>
                            <input type="text" name="fax" class="form-control @error('fax') is-invalid @enderror"
                                placeholder="Enter Fax Number">
                            @error('fax')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Enter Email Address">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>DS Officer</label>
                            <input type="text" name="ds_officer"
                                class="form-control @error('ds_officer') is-invalid @enderror"
                                placeholder="Enter DS Officer Name">
                            @error('ds_officer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
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
