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
    <div class="modal fade" tabindex="-1" role="dialog" id="newRequestModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Service Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.service-request.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="client_name" class="col-form-label font-weight-bold">Client Name</label>
                                    <input type="text" class="form-control" id="client_name" name="client_name" readonly>
                                    <input type="hidden" name="client_id" id="client_id">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="client_number" class="col-form-label font-weight-bold">Client Number</label>
                                    <input type="text" class="form-control" id="client_number" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="service_type_id" class="col-form-label font-weight-bold">Service
                                        Type</label>
                                    <select name="service_type_id" id="service_type_id"
                                        class="form-control select2 @error('service_id') is-invalid @enderror">
                                        <option value="">Select a service type</option>
                                        @foreach ($service_types as $service_type)
                                            <option value="{{ $service_type->id }}">{{ $service_type->code }} -
                                                {{ $service_type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('service_type_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="service_id" class="col-form-label font-weight-bold">Service</label>
                                    <select name="service_id" id="service_id"
                                        class="form-control @error('service_id') is-invalid @enderror">
                                        <option value="" selected>Select a service</option>
                                    </select>
                                    @error('service_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12" id="subservice-container" style="display:none;">
                                <div class="form-group">
                                    <label for="subservice_id" class="col-form-label font-weight-bold">Sub Service</label>
                                    <select name="subservice_id" id="subservice_id"
                                        class="form-control @error('subservice_id') is-invalid @enderror">
                                        <option value="" selected>Select a subservice</option>
                                    </select>
                                    @error('subservice_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="status_id" class="col-form-label font-weight-bold">Status</label>
                                    <select name="status_id" id="status_id"
                                        class="form-control @error('status_id') is-invalid @enderror">
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->status_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="notes" class="col-form-label font-weight-bold">Notes</label>
                                    <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="4"
                                        placeholder="Additional notes..."></textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                </div>

                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Request</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

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

            $('#service_type_id').on('change', function() {
                let service_type_id = $(this).val();

                $('#service_id').empty();

                $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.fetch-service-type') }}",
                    data: {
                        service_type_id: service_type_id
                    },
                    success: function(data) {

                        $('#service_id').append('<option value="">Select Service</option>');

                        $.each(data, function(index, item) {
                            $('#service_id').append(
                                `<option value="${item.id}">${item.code} - ${item.name}</option>`
                            );
                        });
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });

            $('#service_id').on('change', function() {
                let service_id = $(this).val();

                // Fetch service data based on service_id
                $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.fetch-main-service') }}",
                    data: {
                        service_id: service_id
                    },
                    success: function(service) {
                        if (service.have_sub_service === 0) {
                            // Show subservice container if subservices exist
                            $('#subservice-container').show();

                            // Fetch subservices for the selected service
                            $.ajax({
                                method: 'GET',
                                url: "{{ route('admin.fetch-subservice') }}",
                                data: {
                                    service_id: service_id
                                },
                                success: function(subservices) {
                                    // Clear the subservice select box
                                    $('#subservice_id').empty();
                                    $('#subservice_id').append(
                                        '<option value="" selected>Select a subservice</option>'
                                    );

                                    // Populate subservice select box with options
                                    $.each(subservices, function(index,
                                        subservice) {
                                        $('#subservice_id').append(
                                            `<option value="${subservice.id}">${subservice.code} - ${subservice.name}</option>`
                                        );
                                    });
                                },
                                error: function(error) {
                                    console.error("Error fetching subservices:",
                                        error);
                                }
                            });
                        } else {
                            // Hide subservice container if service doesn't have subservices
                            $('#subservice-container').hide();
                        }
                    },
                    error: function(error) {
                        console.error("Error fetching service:", error);
                    }
                });
            });

        });
    </script>
@endpush
