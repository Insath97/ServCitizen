@extends('admin.layouts.master')

@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Complaints</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.complaint.index') }}">Complaints</a></div>
                <div class="breadcrumb-item">Edit Complaint</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Edit Complaint</h4>
                </div>
                <div class="card-body">
                    <!-- AJAX Form -->
                    <form id="complaintForm" action="{{ route('admin.complaint.update', $complaint->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Complaint Type</label>
                            <select name="complaint_type" id="complaint_type" class="form-control">
                                <option value="">Select Complaint Type</option>
                                <option {{ $complaint->complaint_type == 'online' ? 'selected' : '' }} value="online">Online</option>
                                <option {{ $complaint->complaint_type == 'offline' ? 'selected' : '' }} value="offline">Offline</option>
                            </select>
                            <span class="text-danger error-text complaint_type_error"></span>
                        </div>

                        <!-- Online Complaint Fields -->
                        <div id="online-complaint" style="display: none;">
                            <div class="form-group">
                                <label>Complainant Name</label>
                                <input type="text" name="complainant_name" value="{{ $complaint->complainant_name }}" class="form-control">
                                <span class="text-danger error-text complainant_name_error"></span>
                            </div>

                            <div class="form-group">
                                <label>Complainant Email</label>
                                <input type="text" name="complainant_email" value="{{ $complaint->complainant_email }}" class="form-control">
                                <span class="text-danger error-text complainant_email_error"></span>
                            </div>

                            <div class="form-group">
                                <label>Platform</label>
                                <select name="platform" class="form-control">
                                    <option value="">Select Platform</option>
                                    <option {{ $complaint->platform == 'WhatsApp' ? 'selected' : '' }} value="WhatsApp">WhatsApp</option>
                                    <option {{ $complaint->platform == 'Facebook' ? 'selected' : '' }} value="Facebook">Facebook</option>
                                    <option {{ $complaint->platform == 'Email' ? 'selected' : '' }} value="Email">Email</option>
                                    <option {{ $complaint->platform == 'Others' ? 'selected' : '' }} value="Others">Others</option>
                                </select>
                                <span class="text-danger error-text platform_error"></span>
                            </div>
                        </div>

                        <!-- Offline Complaint Fields -->
                        <div id="offline-complaint" style="display: none;">
                            <div class="form-group">
                                <label>Complainant Name</label>
                                <input type="text" name="complainant_name_offline" value="{{ $complaint->complainant_name_offline }}" class="form-control">
                                <span class="text-danger error-text complainant_name_offline_error"></span>
                            </div>

                            <div class="form-group">
                                <label>Complainant NIC</label>
                                <input type="text" name="complainant_nic_offline" value="{{ $complaint->complainant_nic_offline }}" class="form-control">
                                <span class="text-danger error-text complainant_nic_offline_error"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Complaint Subject</label>
                            <input type="text" name="subject" value="{{ $complaint->subject }}" class="form-control">
                            <span class="text-danger error-text subject_error"></span>
                        </div>

                        <div class="form-group">
                            <label>Complaint Description</label>
                            <textarea name="description" class="form-control" rows="4">{{ $complaint->description }}</textarea>
                            <span class="text-danger error-text description_error"></span>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="submitBtn">Save</button>
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
            // Show/hide complaint fields based on type
            function toggleComplaintFields() {
                var complaintType = $('#complaint_type').val();
                if (complaintType === 'online') {
                    $('#online-complaint').show();
                    $('#offline-complaint').hide();
                } else if (complaintType === 'offline') {
                    $('#online-complaint').hide();
                    $('#offline-complaint').show();
                } else {
                    $('#online-complaint').hide();
                    $('#offline-complaint').hide();
                }
            }

            toggleComplaintFields();

            // Trigger toggleComplaintFields when complaint type changes
            $('#complaint_type').on('change', function() {
                toggleComplaintFields();
            });

            // Handle AJAX submission and validation
            $('#complaintForm').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = form.serialize();

                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: formData,
                    beforeSend: function() {
                        form.find('span.error-text').text(''); // Clear previous error messages
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Complaint updated successfully!');
                            window.location.href = "{{ route('admin.complaint.index') }}"; // Redirect after success
                        }
                    },
                    error: function(xhr) {
                        // Loop through errors and display them
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, error) {
                                $('span.' + key + '_error').text(error[0]); // Display error in the relevant span
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush
