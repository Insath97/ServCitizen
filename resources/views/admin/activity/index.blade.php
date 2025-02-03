@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Working Progress Status</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Token Status</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-body">
                    <form id="search-form">

                        {{--  <div class="form-group">
                            <label>Token Number</label>
                            <input type="text" name="search" id="search-input"
                                class="form-control @error('search') is-invalid @enderror"
                                placeholder="Search by Token Number">
                            @error('search')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div> --}}

                        <div class="form-group">
                            <select name="search" id="search-select-input" class="form-control select2">
                                <option value="">Search by Token Number</option>
                                @foreach ($request_services as $item)
                                    <option value="{{ $item->id }}">{{ $item->token_number }}</option>
                                @endforeach

                            </select>
                        </div>

                    </form>
                    <hr>

                    <div class="table-responsive">
                        <table class="table table-striped" id="clientTable">
                            <thead>
                                <tr>
                                    <th>Token</th>
                                    <th>Client Number</th>
                                    <th>Client Name</th>
                                    <th>Service Type</th>
                                    <th>Service Name</th>
                                    <th>Subservice Name</th>
                                    <th>Token Status</th>
                                    <th>Created Date</th>
                                    <th>Current Phase</th>
                                    <th>Update Status</th>
                                </tr>
                            </thead>
                            <tbody id="resultBody">
                                <tr id="no-data-row">
                                    <td colspan="10" class="text-center">No data found</td>
                                </tr>
                            </tbody>
                        </table>
                        <div id="noDataMessage" style="display:none; color: red; margin-top: 20px;">
                            No data found.
                        </div>
                    </div>

                    <div id="ticket-status-section" style="display:none; margin-top: 20px;">
                        <hr>
                        <h5>Update Ticket Status</h5>
                        <form id="status-form" method="POST">
                            @csrf
                            <input type="hidden" id="token-id" name="token_id">

                            <div class="form-group">
                                <label for="ticket-status">Ticket Status</label>
                                <select class="form-control" id="ticket-status" name="ticket_status" required>
                                    <option value="pending">Pending</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="status-feedback">Status Feedback</label>
                                <textarea class="form-control" id="status-feedback" name="status_feedback" rows="3"
                                    placeholder="Enter any feedback or comments about the status"></textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update Status</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div class="section-body" id="work-flow">
            <h2 class="section-title">Workflow Status Overview</h2>

            <div class="row mb-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="progress-wrapper">
                                <div class="progress-indicator">
                                    <div class="stepper-wrapper">
                                        <div class="stepper-item active" data-target="#open-form">
                                            <div class="step-counter">1</div>
                                            <div class="step-name">Open</div>
                                        </div>
                                        <div class="stepper-item" data-toggle="modal" data-target="#verification-form"
                                            style="cursor: pointer;">
                                            <div class="step-counter">2</div>
                                            <div class="step-name">Document Verification</div>
                                        </div>
                                        <div class="stepper-item" data-toggle="modal" data-target="#calling-form"
                                            style="cursor: pointer;">
                                            <div class="step-counter">3</div>
                                            <div class="step-name">Calling Reports</div>
                                        </div>
                                        <div class="stepper-item" data-toggle="modal" data-target="#final-decision-form"
                                            style="cursor: pointer;">
                                            <div class="step-counter">4</div>
                                            <div class="step-name">Final Decision</div>
                                        </div>
                                        <div class="stepper-item" data-target="#completed-form" style="cursor: pointer;">
                                            <div class="step-counter">5</div>
                                            <div class="step-name">Completed</div>
                                        </div>
                                        <input type="hidden" id="token-id-com" name="completed_token">
                                        <input type="hidden" id="status_id_five" value="5">
                                    </div>
                                    <!-- Progress bar -->
                                    <div class="progress mt-3" style="height: 8px;">
                                        <div id="progress-bar" class="progress-bar bg-success" role="progressbar"
                                            style="width: 0%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    @include('admin.activity.update_status')

    @include('admin.activity.document_verification')

    @include('admin.activity.calling_report')

    @include('admin.activity.final_decision')

    @include('admin.activity.completed')
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('#search-select-input').select2({
                placeholder: "Search by Token Number",
                tags: true,
                width: '100%'
            });

            // Hide the workflow section by default
            $('#work-flow').hide();

            // Initialize DataTable
            $("#table-1").dataTable({
                "columnDefs": [{
                    "sortable": false,
                    "targets": [2, 3]
                }]
            });

            // Search form submission
            $('#search-select-input').on('change', function(event) {
                event.preventDefault();

                var searchQuery = $(this).val();

                console.log(searchQuery);


                // Client-side validation
                if (searchQuery === '') {
                    alert('Please enter a token number.');
                    return; // Stop the form submission
                }

                $.ajax({
                    url: "{{ route('admin.request-search') }}",
                    type: "GET",
                    data: {
                        search: searchQuery
                    },
                    success: function(response) {
                        // Clear previous results
                        $('#resultBody').empty();
                        $('#noDataMessage').hide();
                        $('#no-data-row').hide();

                        // Check if token data exists
                        if (response && response.token) {
                            var tokenId = response.token.id;
                            var subServiceName = response.token.sub_service ? response.token
                                .sub_service.name : 'N/A';
                            var statusName = response.token.status.status_name;
                            var statusColor = response.token.status.status_color;
                            var status_id = response.token.status.id;

                            var current_phase = '';
                            if (response.token.current_phase === 'open') {
                                $('#progress-bar').css('width', '20%');
                                current_phase = "Open";
                            } else if (response.token.current_phase ===
                                'document_verification') {
                                $('#progress-bar').css('width', '40%');
                                current_phase = "Document Verification";
                            } else if (response.token.current_phase === 'calling_report') {
                                $('#progress-bar').css('width', '60%');
                                current_phase = "Calling Report";
                            } else if (response.token.current_phase === 'final_decision') {
                                $('#progress-bar').css('width', '80%');
                                current_phase = "Final Decision";
                            } else if (response.token.current_phase === 'completed') {
                                $('#progress-bar').css('width', '100%');
                                current_phase = "Completed";
                            }

                            // Populate table with token details
                            $('#resultBody').append(`
                    <tr data-token-id="${response.token.id}">
                        <td>${response.token.token_number}</td>
                        <td>${response.token.client.client_number}</td>
                        <td>${response.token.client.name}</td>
                        <td>${response.token.main_service.service_type.name}</td>
                        <td>${response.token.main_service.name}</td>
                        <td>${subServiceName}</td>
                        <td>
                            <span class="badge text-white" style="background-color: ${statusColor};" id="status-badge-${response.token.id}">
                                ${statusName}
                            </span>
                        </td>
                        <td>${new Date(response.token.created_at).toLocaleDateString()}</td>
                        <td id="current-phase-${response.token.id}">${current_phase}</td>
                        <td>
                            <a href="javascript:void(0);"
                               data-toggle="modal"
                               data-target="#updateStatusModal"
                               data-token-id="${response.token.id}"
                               data-status="${statusName}"
                               class="btn btn-danger text-center">
                                <i class="fas fa-wrench"></i>
                            </a>
                        </td>
                    </tr>
                `);

                            $('#work-flow').show();
                            $('#token-id').val(tokenId);
                            $('#status_id_one').val(status_id);
                            $('#token-id-com').val(tokenId);
                        } else {
                            $('#noDataMessage').show();
                            $('#no-data-row').show();
                            $('#work-flow').hide();
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error!', 'An error occurred while searching for the token.',
                            'error');
                    }
                });
            });

            // Open update status modal
            $('#updateStatusModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var tokenId = button.data('token-id');
                var status = button.data('status');

                if (status !== 'Open') {
                    event.preventDefault();
                    return false;
                }

                var modal = $(this);
                modal.find('#modal-token-id').val(tokenId);
            });

            // Handle status form submission inside modal
            $('#updateStatusForm').on('submit', function(event) {
                event.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('admin.update-status') }}",
                    method: "POST",
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            $('#updateStatusModal').modal('hide');
                            Swal.fire('Success!', response.message, 'success');

                            var tokenId = $('#modal-token-id').val();
                            var statusText = $('#modal-ticket-status option:selected').text();
                            var statusColor = $('#modal-ticket-status option:selected').data(
                                'color');

                            var statusBadge = $('#status-badge-' + tokenId);
                            statusBadge.text(statusText);
                            statusBadge.css('background-color', statusColor);

                            var newPhaseText = 'Open';
                            var currentPhaseCell = $('#current-phase-' + tokenId);
                            currentPhaseCell.text(newPhaseText);

                            // Update the progress bar
                            var currentPhase = response.data.current_phase;
                            var progressPercentage = 0;

                            if (currentPhase == 'open') {
                                progressPercentage = 20;
                            } else if (currentPhase == 'document_verification') {
                                progressPercentage = 40;
                            } else if (currentPhase == 'calling_report') {
                                progressPercentage = 60;
                            } else if (currentPhase == 'final_decision') {
                                progressPercentage = 80;
                            } else if (currentPhase == 'completed') {
                                progressPercentage = 100;
                            } else {
                                progressPercentage = 0;
                            }

                            $('#progress-bar').css('width', progressPercentage + '%');

                            $('#work-flow').show(); // Ensure workflow section is visible
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                            $('#work-flow').hide(); // Hide workflow section on error
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Failed to update status. Please try again.',
                            'error');
                    }
                });
            });

            // Document Verification form modal
            $('#verification-form').on('show.bs.modal', function(event) {
                var tokenId = $('#token-id').val();
                var statusId = $('#status_id_one').val();
                var currentPhaseCell = $('#current-phase-' + tokenId).text();

                if (currentPhaseCell !== 'Open') {
                    event.preventDefault();
                    Swal.fire('Error!', 'You can only access this form when the phase is "Open".', 'error');
                } else {
                    var modal = $(this);
                    modal.find('input[name="token_id"]').val(tokenId);
                    modal.find('input[name="status_id_one"]').val(statusId);

                    $('#verification-form').modal('show');
                }
            });

            // Document Verification Update
            $('#documentVerificationForm').on('submit', function(event) {
                event.preventDefault();

                var formData = {
                    token_id: $('#token-id').val(),
                    statusId: $('#status_id_one').val(),
                    documentVerificationStatus: $('#documentVerificationStatus').val(),
                    remarks: $('#remarks').val(),
                    _token: "{{ csrf_token() }}"
                };

                $.ajax({
                    method: 'POST',
                    url: "{{ route('admin.update-status-one') }}",
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            $('#verification-form').modal('hide');
                            Swal.fire('Success!', response.message, 'success');
                            var tokenId = $('#token-id').val();
                            var newPhaseText = 'Document Verification';
                            var currentPhaseCell = $('#current-phase-' + tokenId);

                            currentPhaseCell.text(newPhaseText);

                            var currentPhase = response.data.current_phase;
                            var progressPercentage = 0;

                            if (currentPhase == 'open') {
                                progressPercentage = 20;
                            } else if (currentPhase == 'document_verification') {
                                progressPercentage = 40;
                            } else if (currentPhase == 'calling_report') {
                                progressPercentage = 60;
                            } else if (currentPhase == 'final_decision') {
                                progressPercentage = 80;
                            } else if (currentPhase == 'completed') {
                                progressPercentage = 100;
                            } else {
                                progressPercentage = 0;
                            }

                            $('#progress-bar').css('width', progressPercentage + '%');
                            $('#work-flow').show();
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Failed to update status. Please try again.',
                            'error');
                    }
                });
            });

            /* calling report form model */
            $('#calling-form').on('show.bs.modal', function(event) {
                var tokenId = $('#token-id').val();
                var statusId = $('#status_id_two').val();
                var currentPhaseCell = $('#current-phase-' + tokenId).text();

                if (currentPhaseCell !== 'Document Verification') {
                    event.preventDefault();
                    Swal.fire('Error!',
                        'You can only access this form when the phase is "Document Verification".',
                        'error');
                } else {
                    var modal = $(this);
                    modal.find('input[name="token_id"]').val(tokenId);
                    modal.find('input[name="status_id_two"]').val(statusId);

                    $('#calling-form').modal('show');
                }
            });


            /* Calling Report Status Update */
            $('#callingReportsForm').on('submit', function(event) {
                event.preventDefault();

                var formData = {
                    token_id: $('#token-id').val(),
                    statusId: $('#status_id_one').val(),
                    callingReportsStatus: $('#callingReportsStatus').val(),
                    remarks: $('#remarks').val(),
                    _token: "{{ csrf_token() }}"
                };

                $.ajax({
                    method: 'POST',
                    url: "{{ route('admin.update-status-two') }}",
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            $('#calling-form-form').modal('hide');
                            Swal.fire('Success!', response.message, 'success');

                            var tokenId = $('#token-id').val();
                            var newPhaseText = 'Calling Report';
                            var currentPhaseCell = $('#current-phase-' + tokenId);
                            currentPhaseCell.text(newPhaseText);

                            // Update the progress bar
                            var currentPhase = response.data.current_phase;
                            var progressPercentage = 0;

                            if (currentPhase == 'open') {
                                progressPercentage = 20;
                            } else if (currentPhase == 'document_verification') {
                                progressPercentage = 40;
                            } else if (currentPhase == 'calling_report') {
                                progressPercentage = 60;
                            } else if (currentPhase == 'final_decision') {
                                progressPercentage = 80;
                            } else if (currentPhase == 'completed') {
                                progressPercentage = 100;
                            } else {
                                progressPercentage = 0;
                            }

                            $('#progress-bar').css('width', progressPercentage + '%');
                            $('#work-flow').show();
                            $('#calling-form').modal('hide');
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Failed to update status. Please try again.',
                            'error');
                    }
                });
            });


            /* Final Decision form model */
            $('#final-decision-form').on('show.bs.modal', function(event) {
                var tokenId = $('#token-id').val(); // Get the token ID
                var currentPhaseCell = $('#current-phase-' + tokenId).text(); // Get the current phase text

                // Check if the current phase is "Calling Report"
                if (currentPhaseCell !== 'Calling Report') {
                    event.preventDefault(); // Prevent the modal from opening
                    Swal.fire('Error!', 'You must complete the "Calling Report" phase before proceeding.',
                        'error');
                    return false;
                }

                // Set token ID and status ID in the modal form inputs if conditions are met
                var modal = $(this);
                var statusId = $('#status_id_one').val();

                modal.find('input[name="token_id"]').val(tokenId);
                modal.find('input[name="status_id_one"]').val(statusId);

                $('#final-decision-form').modal('show');
            });


            /* Final Decision Status Update */
            $('#finalDecisionForm').on('submit', function(event) {
                event.preventDefault();

                var formData = {
                    token_id: $('#token-id').val(),
                    statusId: $('#status_id_one').val(),
                    finalDecisionStatus: $('#finalDecisionStatus').val(),
                    remarks: $('#remarks').val(),
                    _token: "{{ csrf_token() }}"
                };

                $.ajax({
                    method: 'POST',
                    url: "{{ route('admin.update-status-three') }}",
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            $('#final-decision-form').modal('hide');
                            Swal.fire('Success!', response.message, 'success');

                            // Update status badge
                            var tokenId = $('#token-id').val();

                            var newPhaseText = 'Final Decision';
                            var currentPhaseCell = $('#current-phase-' + tokenId);
                            currentPhaseCell.text(newPhaseText);

                            var currentStatusName = response.data.status.status_name;
                            var currentStatusColor = response.data.status.status_color;

                            var statusBadge = $('#status-badge-' + tokenId);
                            statusBadge.text(currentStatusName);
                            statusBadge.css('background-color', currentStatusColor);

                            // Update progress bar
                            var currentPhase = response.data.current_phase;
                            var progressPercentage = 0;

                            if (currentPhase == 'open') {
                                progressPercentage = 20;
                            } else if (currentPhase == 'document_verification') {
                                progressPercentage = 40;
                            } else if (currentPhase == 'calling_report') {
                                progressPercentage = 60;
                            } else if (currentPhase == 'final_decision') {
                                progressPercentage = 80;
                            } else if (currentPhase == 'completed') {
                                progressPercentage = 100;
                            } else {
                                progressPercentage = 0;
                            }

                            $('#progress-bar').css('width', progressPercentage + '%');
                            $('#work-flow').show();
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Failed to update status. Please try again.',
                            'error');
                    }
                });
            });

            /* completed status */
            $('body').on('click', '[data-target="#completed-form"]', function(event) {
                event.preventDefault();

                var tokenId = $('#token-id-com').val();

                if (!tokenId) {
                    Swal.fire('Error!', 'Please search for a token first.', 'warning');
                    return;
                }

                Swal.fire({
                    title: 'Mark as Completed',
                    text: 'Are you sure you want to mark this token as completed?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, mark as completed',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.update-status-four') }}",
                            method: 'POST',
                            data: {
                                completed_token: tokenId,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                if (response.success) {
                                    $('#completed-form').modal('hide');
                                    Swal.fire('Success!', response.message, 'success');

                                    // Update status badge
                                    var statusBadge = $('#status-badge-' + tokenId);
                                    var currentStatusName = response.data.status
                                        .status_name;
                                    var currentStatusColor = response.data.status
                                        .status_color;

                                    statusBadge.text(currentStatusName);
                                    statusBadge.css('background-color',
                                        currentStatusColor);

                                    // Update progress bar
                                    var progressPercentage =
                                        100; // Completed phase is always 100%
                                    $('#progress-bar').css('width', progressPercentage +
                                        '%');
                                    $('#work-flow').show();
                                } else {
                                    Swal.fire('Error!', response.message, 'error');
                                }
                            },
                            error: function(xhr) {
                                Swal.fire('Error!',
                                    'Failed to update status. Please try again.',
                                    'error');
                            }
                        });
                    }
                });
            });

        });
    </script>
@endpush
