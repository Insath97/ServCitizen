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
                    <form id="clientForm" method="post">

                        @csrf

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>NIC Number</label>
                                <input type="text" name="nic"
                                    class="form-control @error('nic') is-invalid @enderror">
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Client Queue Number</label>
                                <input type="text" name="client_number" readonly
                                    class="form-control @error('client_number') is-invalid @enderror">
                                <div class="invalid-feedback"></div>
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
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Date of Birth</label>
                                <input type="date" name="dob"
                                    class="form-control @error('dob') is-invalid @enderror">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <hr>
                        <h2 class="section-title">Address</h2>

                        <div class="form-group">
                            <label for="inputAddress">Street</label>
                            <input type="text" class="form-control @error('street') is-invalid @enderror"
                                id="inputAddress" name="street">
                            <div class="invalid-feedback"></div>
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
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputCity">District</label>
                                <select name="district_id" id="district_id"
                                    class="form-control select2 @error('district_id') is-invalid @enderror">
                                    <option value="">Select Districts</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">Divisional Secretariat</label>
                                <select name="ds_id" id="ds_id"
                                    class="form-control select2 @error('ds_id') is-invalid @enderror">
                                    <option value="">Select Divisional Secretariat</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>GN Division</label>
                                <select name="division_id" id="division_id"
                                    class="form-control select2 @error('division_id') is-invalid @enderror">
                                    <option value="">Select Division</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <hr>
                        <h2 class="section-title">Contact Details</h2>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Mobile Number</label>
                                <input type="text" name="mobile"
                                    class="form-control @error('mobile') is-invalid @enderror">
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Tel Number</label>
                                <input type="text" name="tel"
                                    class="form-control @error('tel') is-invalid @enderror">
                                <div class="invalid-feedback"></div>
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

            $('#clientForm').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.client.store') }}",
                    data: $(this).serialize(),
                    success: function(response) {
                        // Show success toast notification
                        showToast('success', response.success);

                        // Redirect after a delay
                        setTimeout(function() {
                            window.location.href = response.redirect;
                        }, 2000);
                    },
                    error: function(xhr) {
                        // Log the complete response for debugging
                        console.log(xhr);

                        // Clear previous errors
                        $('.invalid-feedback').html(''); // Clear previous error messages
                        $('.form-control').removeClass('is-invalid'); // Clear error highlights

                        if (xhr.status === 422) {
                            // Loop through the validation errors
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                // Find the input field and add the is-invalid class
                                let inputField = $('[name="' + key + '"]');

                                if (inputField.length > 0) {
                                    // Add error message to corresponding field
                                    inputField.addClass('is-invalid');
                                    inputField.siblings('.invalid-feedback').html(value[
                                        0]);
                                } else {
                                    console.warn('No input field found for ' + key);
                                }
                            });

                            // Show a general error message
                            showToast('error', 'Please correct the errors in the form.');
                        } else {
                            showToast('error',
                                'An error occurred while processing your request.');
                        }
                    }
                });
            });



            function showToast(type, message) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: type, // 'success', 'error', 'warning', 'info', 'question'
                    title: message,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
            }

        });
    </script>
@endpush
