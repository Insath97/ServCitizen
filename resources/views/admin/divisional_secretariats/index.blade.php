@extends('admin.layouts.master')

@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Divisional Secretariats</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Divisional Secretariat</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="row w-100">
                        <div class="col-md-4">
                            <select id="province_id_filter" name="province_id" class="form-control select2"
                                style="width: 100%;">
                                <option value="">Select Province</option>
                                @foreach ($province as $item)
                                    <option value="{{ $item->id }}">{{ $item->province }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <select id="district_id_filter" name="district_id_filter" class="form-control select2"
                                style="width: 100%;">
                                <option value="">Select District</option>

                            </select>
                        </div>

                        <div class="col-md-4 text-right">
                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#newDivisionModal">
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
                                    <th>Divisional Secretariat</th>
                                    <th>Address</th>
                                    <th>Telephone</th>
                                    <th>Fax</th>
                                    <th>Email</th>
                                    <th>Ds Officer</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="resultBody">
                                <tr id="no-data-row" style="display: table-row;">
                                    <td colspan="9" class="text-center">No data found</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Create New Divisional Secretariat Modal -->
    @include('admin.divisional_secretariats.create')

    {{-- edit model --}}
    @include('admin.divisional_secretariats.edit')
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Function to get districts based on province
            function getDistricts(provinceId, districtSelect) {
                return $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.get-districts') }}",
                    data: {
                        province_id: provinceId
                    },
                    success: function(data) {
                        districtSelect.html('<option value="">Select District</option>');
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

            // Event for province selection to update district dropdown
            $('#province_id, #province_id_filter').on('change', function() {
                let provinceId = $(this).val();
                let districtSelect = $(this).attr('id') === 'province_id' ? $('#district_id') : $(
                    '#district_id_filter');

                getDistricts(provinceId, districtSelect).then(function() {
                    // Clear the division table if no districts are available
                    if (districtSelect.find('option').length ===
                        1) { // Only the default option exists
                        $('#resultBody').empty().append(
                            '<tr><td colspan="9" class="text-center">No data found</td></tr>');
                        $('#no-data-row').show();
                        if ($.fn.DataTable.isDataTable('#table-1')) {
                            $('#table-1').DataTable().clear().destroy();
                        }
                    } else {
                        $('#no-data-row').hide();
                    }
                });
            });

            // Function to populate division table based on district selection
            function populateDivisionTable(districtId) {
                if ($.fn.DataTable.isDataTable('#table-1')) {
                    $('#table-1').DataTable().clear().destroy();
                }

                $('#resultBody').empty();
                if (districtId === '') {
                    $('#resultBody').append('<tr><td colspan="9" class="text-center">No data found</td></tr>');
                    $('#no-data-row').show();
                    return;
                }
                $('#no-data-row').hide();

                $.ajax({
                    url: "{{ route('admin.district-filter') }}",
                    type: "GET",
                    data: {
                        district_id_filter: districtId
                    },
                    success: function(response) {
                        if (response.length > 0) {
                            $.each(response, function(index, division) {
                                $('#resultBody').append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${division.code}</td>
                                    <td>${division.name}</td>
                                    <td>${division.address}</td>
                                    <td>${division.telephone}</td>
                                    <td>${division.fax}</td>
                                    <td>${division.email}</td>
                                    <td>${division.ds_officer}</td>
                                    <td>
                                        <a href="#" class="btn btn-success mr-1 text-center modal_link"
                                           data-id="${division.id}"
                                           data-province-id="${division.district ? division.district.province_id : ''}"
                                           data-district-id="${division.district_id}"
                                           data-ds-name="${division.name}"
                                           data-address="${division.address}"
                                           data-telephone="${division.telephone}"
                                           data-fax="${division.fax}"
                                           data-email="${division.email}"
                                           data-ds-officer="${division.ds_officer}"
                                           data-code="${division.code}"
                                           data-toggle="modal"
                                           data-target="#editDivisionModal">
                                            <i class="fas fa-edit fa-lg"></i>
                                        </a>
                                        <button class="btn btn-danger text-center delete-item-d" data-id="${division.id}">
                                            <i class="fas fa-trash fa-lg"></i>
                                        </button>
                                    </td>
                                </tr>
                            `);
                            });
                        } else {
                            $('#resultBody').append(
                                '<tr><td colspan="9" class="text-center">No data found</td></tr>');
                            $('#no-data-row').show();
                        }

                        // Reinitialize DataTable
                        $('#table-1').DataTable({
                            "columnDefs": [{
                                "sortable": false,
                                "targets": [1]
                            }]
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                    }
                });
            }

            // Event for district selection to populate division table
            $('#district_id_filter').on('change', function() {
                var districtId = $(this).val();
                populateDivisionTable(districtId);
            });

            // Handle modal link click for editing division
            $('body').on('click', '.modal_link', function() {
                var id = $(this).data('id');
                var provinceId = $(this).data('province-id');
                var districtId = $(this).data('district-id');
                var dsName = $(this).data('ds-name');
                var address = $(this).data('address');
                var telephone = $(this).data('telephone');
                var fax = $(this).data('fax');
                var email = $(this).data('email');
                var dsOfficer = $(this).data('ds-officer');
                var code = $(this).data('code');

                // Set the action for the update form
                let updateUrl = "{{ route('admin.division.update', ':id') }}".replace(':id', id);
                $('#editDivisionForm').attr('action', updateUrl);

                // Populate fields
                $('input[name="ds_code_update"]').val(code);
                $('input[name="ds_name_update"]').val(dsName);
                $('input[name="address_update"]').val(address);
                $('input[name="telephone_update"]').val(telephone);
                $('input[name="fax_update"]').val(fax);
                $('input[name="email_update"]').val(email);
                $('input[name="ds_officer_update"]').val(dsOfficer);

                // Update province and districts
                $('select[name="province_update"]').val(provinceId).trigger('change');
                getDistricts(provinceId, $('#district_id_update')).then(function() {
                    $('select[name="district_update"]').val(districtId).trigger('change');
                });
            });

            // Handle delete button click
            $(document).on('click', '.delete-item-d', function(e) {
                e.preventDefault();

                let divisionId = $(this).data('id');
                let url = `/admin/division/${divisionId}`;
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
                                        row.remove();
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
        });
    </script>
@endpush
