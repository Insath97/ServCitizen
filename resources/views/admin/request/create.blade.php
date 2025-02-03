@extends('admin.layouts.master')

@section('content')
    <div class="section">
        <div class="section-header">
            <h1>New Request</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Create Request</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-body">
                    <form id="search-form">
                        <div class="form-group">
                            <label>NIC / Client Number</label>
                            <input type="text" name="search" id="search-input"
                                class="form-control @error('search') is-invalid @enderror"
                                placeholder="Search by NIC or Client Number">
                            @error('search')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </form>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-striped" id="clientTable">
                            <thead>
                                <tr>
                                    <th>NIC</th>
                                    <th>Client Number</th>
                                    <th>Client Name</th>
                                    <th>Gender</th>
                                    <th>GN Division</th>
                                    <th>Mobile Number</th>
                                </tr>
                            </thead>
                            <tbody id="resultBody">
                                <tr id="no-data-row">
                                    <td colspan="6" class="text-center">No data found</td>
                                </tr>
                            </tbody>
                        </table>
                        <div id="noDataMessage" style="display:none; color: red; margin-top: 20px;">
                            No data found.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section-body">
        <div class="card card-primary">
            <div class="card-body">
                <div class="d-flex flex-wrap mb-3">
                    <a href="{{ route('admin.client.create') }}" class="btn btn-primary mb-2 mr-2 convert"
                        id="action-button">Create New Client</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped" id="requestsTable">
                        <thead>
                            <tr>
                                <th>Token</th>
                                <th>Service Type</th>
                                <th>Service Name</th>
                                <th>Sub Service Name</th>
                                <th>Request Status</th>
                                <th>Created Date</th>
                            </tr>
                        </thead>
                        <tbody id="requestsTableBody">
                            <tr id="no-requests-row">
                                <td colspan="10" class="text-center">No requests found for this client.</td>
                            </tr>
                        </tbody>
                    </table>
                    <div id="noRequestsMessage" style="display:none; color: red; margin-top: 20px;">
                        No requests found for this client.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Request Modal -->
    @include('admin.request.demo-model')
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            /* select 2 select box editable set */
            $('#newRequestModal').on('shown.bs.modal', function() {
                $('#service_id').select2({
                    placeholder: "Select a service",
                    tags: true,
                    width: '100%',
                    dropdownParent: $(
                        '#newRequestModal'
                    ) // Attach the dropdown to the modal to avoid conflicts
                });

                $('#subservice_id').select2({
                    placeholder: "Select a sub service",
                    tags: true,
                    width: '100%',
                    dropdownParent: $(
                        '#newRequestModal'
                    ) // Attach the dropdown to the modal to avoid conflicts
                });
            });

            /* search client number or nic get response */
            $('#search-form').on('submit', function(event) {
                event.preventDefault();
                var searchQuery = $('#search-input').val();

                if (searchQuery === '') {
                    $('#resultBody').empty();
                    $('#resultBody').append(`
                        <tr>
                            <td colspan="8" class="text-center">No data found</td>
                        </tr>
                    `);

                    $('#requestsTableBody').empty();
                    $('#requestsTableBody').append(`
                        <tr>
                            <td colspan="8" class="text-center">No requests found for this client.</td>
                        </tr>
                    `);

                    $('#action-button').text('Create New Client')
                        .removeClass('btn-dark')
                        .addClass('btn-primary')
                        .attr('href', "{{ route('admin.client.create') }}");

                    $('#no-data-row').show();
                    return;
                }

                $.ajax({
                    url: "{{ route('admin.search-client') }}",
                    type: "GET",
                    data: {
                        search: searchQuery
                    },
                    success: function(response) {
                        // Clear tables and messages
                        $('#resultBody').empty();
                        $('#requestsTableBody').empty();
                        $('#noDataMessage').hide();
                        $('#noRequestsMessage').hide();
                        $('#no-data-row').hide();
                        $('#no-requests-row').hide();

                        if (response.status === 'success' && response.client) {
                            // Display client information
                            $('#resultBody').append(`
                        <tr>
                            <td>${response.client.nic}</td>
                            <td>${response.client.client_number}</td>
                            <td>${response.client.name}</td>
                            <td>${response.client.gender}</td>
                            <td>${response.client.gndivison ? response.client.gndivison.name : ''}</td>
                            <td>${response.client.mobile}</td>
                        </tr>
                    `);
                            $('#no-data-row').hide();
                            $('#action-button').text('Create New Request')
                                .removeClass('btn-primary')
                                .addClass('btn-dark')
                                .attr('href', "#")
                                .off('click')
                                .on('click', function() {
                                    $('#client_id').val(response.client.id);
                                    $('#client_name').val(response.client.name);
                                    $('#client_number').val(response.client.client_number);
                                    $('#service_id').val('');
                                    $('#request_date').val('');
                                    $('#notes').val('');
                                    $('#newRequestModal').modal('show');
                                });
                        } else {
                            $('#action-button').text('Create New Client')
                                .removeClass('btn-dark')
                                .addClass('btn-primary')
                                .attr('href', "{{ route('admin.client.create') }}");

                            $('#noDataMessage').show();
                            $('#no-data-row').show();
                        }

                        if (response.requests && response.requests.length > 0) {
                            response.requests.forEach(function(request) {
                                if (request.token_number) {
                                    var createdAtDate = new Date(request.created_at)
                                        .toLocaleDateString();

                                    let service_name = '';
                                    if (request.main_service.have_sub_service == 1) {
                                        service_name = request.sub_service ? request
                                            .sub_service.name : 'N/A';
                                    } else {

                                    }
                                    $('#requestsTableBody').append(`
                                <tr>
                                    <td>${request.token_number}</td>
                                     <td>${request.main_service.service_type.name}</td>
                                    <td>${request.main_service.name}</td>
                                    <td>${request.sub_service ? request.sub_service.name : 'N/A'}</td>
                                    <td>${request.status ? `<span class="badge text-white" style="background-color: ${request.status.status_color}">
                                                                                                                                                            ${request.status.status_name} </span>` : ''}
                                    </td>
                                    <td>${createdAtDate}</td>
                                </tr>
                            `);
                                }
                            });
                        } else {
                            $('#noRequestsMessage').show();
                            $('#no-requests-row').show();
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });

            $('#service_id').on('change', function() {
                let service_id = $(this).val();
                let hasSubService = $('#service_id option:selected').data('has-subservice');

                // Clear previous data when changing service
                clearFields();

                if (!service_id) {
                    return; // If no service is selected, exit
                }

                // Fetch main service data
                $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.fetch-main-service') }}",
                    data: {
                        service_id: service_id
                    },
                    success: function(service) {
                        if (service.have_sub_service === 1) {
                            // If no sub-services, show service details
                            $('#subservice_id').prop('disabled', true).select2({
                                placeholder: "No subservices available",
                                width: '100%',
                                dropdownParent: $('#newRequestModal')
                            });

                            fetchServiceData(service_id);
                        } else {
                            // If sub-services exist, populate sub-service select box
                            $('#subservice_id').prop('disabled', false).select2({
                                placeholder: "Select a sub-servicet ",
                                width: '100%',
                                dropdownParent: $('#newRequestModal')
                            });
                            fetchSubServices(service_id);
                        }
                    },
                    error: function(error) {
                        console.error("Error fetching service:", error);
                    }
                });

            });

            $('#subservice_id').on('change', function() {
                let subservice_id = $(this).val();

                if (!subservice_id) {
                    return; // Exit if no sub-service is selected
                }

                // Clear previous service details
                clearFields();

                // Fetch sub-service details
                fetchSubServiceData(subservice_id);
            });

            // Function to fetch sub-services for a selected service
            function fetchSubServices(service_id) {
                $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.fetch-subservice') }}",
                    data: {
                        service_id: service_id
                    },
                    success: function(subservices) {
                        $('#subservice_id').empty().append(
                            '<option value="">Select a sub-service</option>');

                        $.each(subservices, function(index, subservice) {
                            $('#subservice_id').append(
                                `<option value="${subservice.id}">${subservice.code} - ${subservice.name}</option>`
                            );
                        });

                        // Enable sub-service select
                        $('#subservice_id').prop('disabled', false).select2({
                            placeholder: "Select a sub service",
                            width: '100%',
                            dropdownParent: $('#newRequestModal')
                        });

                    },
                    error: function(error) {
                        console.error("Error fetching subservices:", error);
                    }
                });
            }

            // Function to fetch service data
            function fetchServiceData(serviceId) {
                $.ajax({
                    url: `{{ url('admin/get-services') }}/${serviceId}`,
                    method: 'GET',
                    success: function(response) {
                        let serviceData = response.data[0];

                        if (serviceData) {
                            $('#newRequestModal').modal('show');
                            $('#a').val(serviceData.service_type.name || "No Service Type");
                            $('#b').val(serviceData.fees_type || "No Fees Type");
                            $('#c').val(serviceData.amount || "No Amount");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching service data:", error);
                    }
                });
            }

            // Function to fetch sub-service data
            function fetchSubServiceData(subserviceId) {
                $.ajax({
                    url: `{{ url('admin/get-sub-services') }}/${subserviceId}`,
                    method: 'GET',
                    success: function(response) {
                        let serviceData = response.data[0];

                        if (serviceData) {
                            $('#newRequestModal').modal('show');
                            $('#a').val(serviceData.service_type.name || "No Service Type");
                            $('#b').val(serviceData.fees_type || "No Fees Type");
                            $('#c').val(serviceData.amount || "No Amount");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching sub-service data:", error);
                    }
                });
            }

            // Function to clear fields
            function clearFields() {
                $('#a, #b, #c').val(""); // Clear fields
                $('#subservice_id').empty().prop('disabled', true); // Reset sub-service dropdown
            }

            // Reset fields when modal closes
            $('#newRequestModal').on('hidden.bs.modal', function() {
                clearFields();
            });

        });
    </script>
@endpush
