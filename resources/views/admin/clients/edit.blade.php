@extends('admin.layouts.master')

@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Clients</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.client.index') }}">Clients</a></div>
                <div class="breadcrumb-item">Edit</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Edit Client</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.client.update', $client->id) }}" method="post">

                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" value="{{ $client->name }}"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>NIC Number</label>
                                <input type="text" name="nic" value="{{ $client->nic }}"
                                    class="form-control @error('nic') is-invalid @enderror">
                                @error('nic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Client Queue Number</label>
                                <input type="text" name="client_number" readonly value="{{ $client->client_number }}"
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
                                    <option {{ $client->gender == 'Male' ? 'selected' : '' }} value="Male">Male</option>
                                    <option {{ $client->gender == 'Female' ? 'selected' : '' }} value="Female">Female
                                    </option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Date of Birth</label>
                                <input type="date" name="dob" value="{{ $client->dob }}"
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
                            <input type="text" value="{{ $client->street_name }}"
                                class="form-control @error('street') is-invalid @enderror" id="inputAddress" name="street">
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
                                        <option {{ $province->id == $client->province_id ? 'selected' : '' }}
                                            value="{{ $province->id }}">{{ $province->province }}</option>
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
                                    @foreach ($districts as $district)
                                        <option {{ $district->id == $client->district_id ? 'selected' : '' }} value="{{ $district->id }}">{{ $district->district }}</option>
                                    @endforeach
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
                                    @foreach ($dss as $ds)
                                        <option {{ $ds->id == $client->divisional_secretariat_id ? 'selected' : '' }} value="{{ $ds->id }}">{{ $ds->name }}</option>
                                    @endforeach
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
                                    @foreach ($gn_divisions as $gn_division)
                                        <option {{ $gn_division->id == $client->gn_division_id ? 'selected' : '' }} value="{{ $gn_division->id }}">{{ $gn_division->name }}</option>
                                    @endforeach
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
                            <input type="text" name="email" value="{{ $client->email }}"
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Mobile Number</label>
                                <input type="text" name="mobile" value="{{ $client->mobile }}"
                                    class="form-control @error('mobile') is-invalid @enderror">
                                @error('mobile')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Tel Number</label>
                                <input type="text" name="tel" value="{{ $client->tel }}"
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
