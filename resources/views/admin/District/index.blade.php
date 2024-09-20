@extends('admin.layouts.master')

@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Districts</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">District</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="row w-100">
                        <div class="col-md-4">
                            <select id="provinceFilter" name="province_id" class="form-control select2"
                                style="width: 100%;">
                                <option value="">Select Province</option>
                                @foreach ($province as $item)
                                    <option value="{{ $item->id }}">{{ $item->province }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8 text-right">
                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#newBranchModal">
                                <i class="fas fa-plus"></i>
                                Create New
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    {{--   <th>Province</th> --}}
                                    <th>Code</th>
                                    <th>District</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="resultBody">
                                <tr id="no-data-row" style="display: table-row;">
                                    <td colspan="4" class="text-center">No data found</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- create model --}}
    @include('admin.District.create')

    {{-- edit model --}}
    @include('admin.District.edit')
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize select2 for province filter
            $('#provinceFilter').select2({
                width: '100%',
                placeholder: 'Select a Province',
                allowClear: true
            });

            // Handle province filter change
            $('#provinceFilter').on('change', function() {
                var provinceId = $(this).val();

                // Safely destroy existing DataTable before re-initializing
                if ($.fn.DataTable.isDataTable('#table-1')) {
                    $('#table-1').DataTable().clear().destroy(); // Fully destroy the DataTable
                }

                // Clear the table body before appending new rows
                $('#resultBody').empty();

                // If no province is selected, show "No data found"
                if (provinceId === '') {
                    $('#resultBody').append(`
                <tr>
                    <td colspan="4" class="text-center">No data found</td>
                </tr>
            `);

                    // Initialize DataTable with no data (just empty table structure)
                    $('#table-1').DataTable({
                        columnDefs: [{
                            sortable: false,
                            targets: [1, 2] // Adjust based on your columns
                        }]
                    });

                    return; // Stop further execution
                }

                // AJAX request to filter districts by province
                $.ajax({
                    url: "{{ route('admin.province-filter') }}",
                    type: "GET",
                    data: {
                        province_id: provinceId
                    },
                    success: function(response) {
                        if (response.length > 0) {
                            // Populate table with available data
                            $.each(response, function(index, district) {
                                $('#resultBody').append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${district.code}</td>
                                <td>${district.district}</td>
                                <td>
                                    <a href="#" class="btn btn-success mr-1 text-center modal_link"
                                        data-id="${district.id}"
                                        data-province="${district.province_id}"
                                        data-code="${district.code}"
                                        data-district="${district.district}"
                                        data-toggle="modal"
                                        data-target="#editDistrictModal">
                                        <i class="fas fa-edit fa-lg"></i>
                                    </a>
                                    <button class="btn btn-danger text-center delete-item-d" data-id="${district.id}">
                                        <i class="fas fa-trash fa-lg"></i>
                                    </button>
                                </td>
                            </tr>
                        `);
                            });

                            // Hide the "No data found" row if data exists
                            $('#no-data-row').hide();
                        } else {
                            // If no data is found, display a message
                            $('#resultBody').append(`
                        <tr>
                            <td colspan="4" class="text-center">No data found</td>
                        </tr>
                    `);
                    $('#table-1').DataTable({
                            destroy: true, // Ensure existing instance is destroyed
                            columnDefs: [{
                                sortable: false,
                                targets: [1, 2] // Adjust based on your columns
                            }]
                        });
                            $('#no-data-row').show(); // Show "No data found"
                        }

                        // Reinitialize DataTable after the data has been populated or not
                        $('#table-1').DataTable({
                            destroy: true, // Ensure existing instance is destroyed
                            columnDefs: [{
                                sortable: false,
                                targets: [1, 2] // Adjust based on your columns
                            }]
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error); // Handle any AJAX error
                    }
                });
            });

            // Handle modal link clicks for editing
            $('body').on('click', '.modal_link', function() {
                var id = $(this).data('id');
                var code = $(this).data('code');
                var province = $(this).data('province');
                var district = $(this).data('district');

                var updateUrl = "{{ route('admin.district.update', 'ID') }}".replace('ID', id);
                $('#editDistrictForm').attr('action', updateUrl);

                $('input[name="district_update"]').val(district);
                $('input[name="district_code_update"]').val(code);
                $('select[name="province_update"]').val(province).trigger('change');
            });
        });


        // Delete functionality with confirmation
        $(document).on('click', '.delete-item-d', function(e) {
            e.preventDefault();

            let districtId = $(this).data('id');
            let url = `/admin/district/${districtId}`;
            let row = $(this).closest('tr');

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: "DELETE",
                        url: url,
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    row
                                        .remove(); // Remove the row without reloading the page
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: response.message,
                                    icon: 'error'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'An error occurred while deleting the item.',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
