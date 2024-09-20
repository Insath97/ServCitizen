@extends('admin.layouts.master')

@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Clients</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.client.index') }}">Clients</a></div>
                <div class="breadcrumb-item">Create New</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Create New Clients</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.client.store') }}" method="post">

                        @csrf

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>NIC Number</label>
                                <input type="text" name="nic"
                                    class="form-control @error('nic') is-invalid @enderror">
                                @error('nic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Client Queue Number</label>
                                <input type="text" name="client_number" readonly
                                    class="form-control @error('client_number') is-invalid @enderror">
                                @error('client_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Gender</label>
                                <select name="gender" class="form-control select2 @error('gender') is-invalid @enderror">
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Date of Birth</label>
                                <input type="date" name="dob"
                                    class="form-control @error('dob') is-invalid @enderror">
                                @error('dob')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <h2 class="section-title">Address</h2>

                        <div class="form-group">
                            <label for="inputAddress">Street</label>
                            <input type="text" class="form-control @error('street') is-invalid @enderror"
                                id="inputAddress" name="street">
                            @error('street')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">Province</label>
                                <select name="province_id" id="province_id"
                                    class="form-control select2 @error('province_id') is-invalid @enderror">
                                    <option value="">Select Province</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}">{{ $province->province }}</option>
                                    @endforeach
                                </select>
                                @error('province_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputCity">District</label>
                                <select name="district_id" id="district_id"
                                    class="form-control select2 @error('district_id') is-invalid @enderror">
                                    <option value="">Select Districts</option>
                                </select>
                                @error('district_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">Divisional Secretariat</label>
                                <select name="ds_id" id="ds_id"
                                    class="form-control select2 @error('ds_id') is-invalid @enderror">
                                    <option value="">Select Divisional Secretariat</option>
                                </select>
                                @error('ds_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>GN Division</label>
                                <select name="division_id" id="division_id"
                                    class="form-control select2 @error('division_id') is-invalid @enderror">
                                    <option value="">Select Division</option>
                                </select>
                                @error('division_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <h2 class="section-title">Contact Details</h2>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email"
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Mobile Number</label>
                                <input type="text" name="mobile"
                                    class="form-control @error('mobile') is-invalid @enderror">
                                @error('mobile')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Tel Number</label>
                                <input type="text" name="tel"
                                    class="form-control @error('tel') is-invalid @enderror">
                                @error('tel')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            /* get district */
            $('#province_id').on('change', function() {
                let province_id = $(this).val();

                /* using ajax */
                $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.get-districts') }}",
                    data: {
                        province_id: province_id
                    },
                    success: function(data) {
                        $('#district_id').html("");
                        $('#district_id').html(`<option value="">Select Districts</option>`);

                        $.each(data, function(index, item) {

                            $('#district_id').append(
                                `<option value="${item.id}">${item.district}</option>`
                            );
                        });
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });

            /* get ds */
            $('#district_id').on('change', function() {
                let district_id = $(this).val();

                /* using ajax */
                $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.get-divisional-secretariat') }}",
                    data: {
                        district_id: district_id
                    },
                    success: function(data) {
                        $('#ds_id').html("");
                        $('#ds_id').html(
                            `<option value="">Select Divisional Secretariat</option>`);

                        $.each(data, function(index, item) {

                            $('#ds_id').append(
                                `<option value="${item.id}">${item.name}</option>`
                            );
                        });
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });

            /* get Gn division */
            $('#ds_id').on('change', function() {
                let divisional_secretariat_id = $(this).val();

                /* using ajax */
                $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.get-gn-divison') }}",
                    data: {
                        ds_id: divisional_secretariat_id
                    },
                    success: function(data) {
                        $('#division_id').html("");
                        $('#division_id').html(`<option value="">Select Division</option>`);

                        $.each(data, function(index, item) {

                            $('#division_id').append(
                                `<option value="${item.id}">${item.name}</option>`
                            );
                        });
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });

        });
    </script>
@endpush
