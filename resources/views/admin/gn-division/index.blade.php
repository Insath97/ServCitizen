@extends('admin.layouts.master')

@section('content')
    <div class="section">
        <div class="section-header">
            <h1>GN Divisions</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">GN Division</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="row w-100">
                        <div class="col-md-3">
                            <select id="province_id_filter" name="province_id" class="form-control select2"
                                style="width: 100%;">
                                <option value="">Select Province</option>
                                @foreach ($province as $item)
                                    <option value="{{ $item->id }}">{{ $item->province }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select id="district_id_filter" name="district_id" class="form-control select2"
                                style="width: 100%;">
                                <option value="">Select District</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select id="ds_id_filter" name="ds_id" class="form-control select2" style="width: 100%;">
                                <option value="">Select Divisional Secretariat</option>
                            </select>
                        </div>

                        <div class="col-md-3 text-right">
                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#newGnDivisionModal">
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
                                    <th>Code</th>
                                    <th>GN Divisions</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="resultBody">
                                <tr id="no-data-row">
                                    <td colspan="4" class="text-center">No data available</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Create Model --}}
    @include('admin.gn-division.create')

    <!-- Edit GN Division Modal -->
    @include('admin.gn-division.edit')
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Function to fetch districts based on province
            function fetchDistricts(provinceId, districtSelect) {
                return $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.get-districts') }}",
                    data: {
                        province_id: provinceId
                    },
                    success: function(data) {
                        districtSelect.html("<option value=''>Select District</option>");
                        $.each(data, function(index, item) {
                            districtSelect.append(
                                `<option value="${item.id}">${item.district}</option>`);
                        });
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }

            // Event handlers for province selection
            $('#province_id, #province_id_update, #province_id_filter').on('change', function() {
                let provinceId = $(this).val();
                let districtSelect;

                if ($(this).is('#province_id')) {
                    districtSelect = $('#district_id');
                } else if ($(this).is('#province_id_update')) {
                    districtSelect = $('#district_id_update');
                } else {
                    districtSelect = $('#district_id_filter');
                }

                fetchDistricts(provinceId, districtSelect).then(function() {
                    if (districtSelect.find('option').length === 1) {
                        // Clear district and DS selections if no districts found
                        $('#ds_id_filter').html(
                            "<option value=''>Select Divisional Secretariat</option>");
                        $('#resultBody').empty().append(
                            "<tr><td colspan='3' class='text-center'>No data found</td></tr>");
                        $('#table-1').DataTable().clear().destroy();
                    }
                });
            });

            // Function to fetch Divisional Secretariats based on district
            function fetchDivisionalSecretariats(districtId, dsSelect) {
                return $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.get-divisional-secretariat') }}",
                    data: {
                        district_id: districtId
                    },
                    success: function(data) {
                        dsSelect.html("<option value=''>Select Divisional Secretariat</option>");
                        $.each(data, function(index, item) {
                            dsSelect.append(`<option value="${item.id}">${item.name}</option>`);
                        });
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }

            // Event handlers for district selection
            $('#district_id, #district_id_update, #district_id_filter').on('change', function() {
                let districtId = $(this).val();
                let dsSelect;

                if ($(this).is('#district_id')) {
                    dsSelect = $('#ds_id');
                } else if ($(this).is('#district_id_update')) {
                    dsSelect = $('#ds_id_update');
                } else {
                    dsSelect = $('#ds_id_filter');
                }

                fetchDivisionalSecretariats(districtId, dsSelect).then(function() {
                    // Clear the results table if no DS available
                    if (dsSelect.find('option').length === 1) {
                        $('#resultBody').empty().append(
                            "<tr><td colspan='3' class='text-center'>No data found</td></tr>");
                        $('#table-1').DataTable().clear().destroy();
                    }
                });
            });

            // Handle the view table based on Divisional Secretariat selection
            $('#ds_id_filter').on('change', function() {
                let dsId = $(this).val();

                // Clear previous data and destroy the DataTable instance if it exists
                if ($.fn.DataTable.isDataTable('#table-1')) {
                    $('#table-1').DataTable().clear().destroy();
                }

                // Clear the table body
                $('#resultBody').empty();

                if (dsId === '') {
                    $('#resultBody').append(
                        "<tr><td colspan='3' class='text-center'>No data found</td></tr>");
                    return;
                }

                // Fetch data based on the selected Divisional Secretariat
                $.ajax({
                    url: "{{ route('admin.ds-filter') }}",
                    type: "GET",
                    data: {
                        ds_id: dsId
                    },
                    success: function(response) {
                        if (response.length > 0) {
                            $.each(response, function(index, gnDivision) {
                                $('#resultBody').append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${gnDivision.code}</td>
                                <td>${gnDivision.name}</td>
                                <td>
                                    <a href="#" class="btn btn-success mr-1 text-center modal_link"
                                       data-id="${gnDivision.id}"
                                       data-province-id="${gnDivision.divisionalSecretariat?.district?.province_id || ''}"
                                       data-district-id="${gnDivision.divisionalSecretariat?.district_id || ''}"
                                       data-ds-id="${gnDivision.divisional_secretariat_id || ''}"
                                       data-gn-name="${gnDivision.name || ''}"
                                       data-code="${gnDivision.code}"
                                       data-toggle="modal"
                                       data-target="#editGnDivisionModal">
                                        <i class="fas fa-edit fa-lg"></i>
                                    </a>
                                    <button class="btn btn-danger text-center delete-item-d" data-id="${gnDivision.id}">
                                        <i class="fas fa-trash fa-lg"></i>
                                    </button>
                                </td>
                            </tr>
                        `);
                            });
                        } else {
                            $('#resultBody').append(
                                "<tr><td colspan='3' class='text-center'>No data found</td></tr>"
                                );
                        }

                        // Reinitialize DataTable after data is populated
                        $('#table-1').DataTable({
                            "columnDefs": [{
                                "sortable": false,
                                "targets": [1, 2]
                            }]
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                    }
                });
            });

            // Handle modal population
            $('body').on('click', '.modal_link', function() {
                var id = $(this).data('id');
                var code = $(this).data('code');
                var province_id = $(this).data('province-id');
                var district_id = $(this).data('district-id');
                var ds_id = $(this).data('ds-id');
                var gn_name = $(this).data('gn-name');

                $('#editGnDivisionForm').attr('action', "{{ route('admin.gn-division.update', ':id') }}"
                    .replace(':id', id));
                $('input[name="gn_code_update"]').val(code);
                $('input[name="gn_name_update"]').val(gn_name);
                $('select[name="ds_name_update"]').val(ds_id).trigger('change');
            });
        });

        $(document).on('click', '.delete-item-d', function(e) {
            e.preventDefault();

            let GNdivisionId = $(this).data('id');
            let url = `/admin/gn-division/${GNdivisionId}`;
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
                                        .remove();
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
