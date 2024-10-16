@extends('admin.layouts.master')

@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Complaints</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.complaint.index') }}">Complaints</a></div>
                <div class="breadcrumb-item">Create New</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Create New Complaint</h4>
                </div>
                <div class="card-body">
                    <!-- AJAX Form -->
                    <form id="complaintForm" action="{{ route('admin.complaint.store') }}" method="post">

                        @csrf

                        <div class="form-group">
                            <label>Complaint Type</label>
                            <select name="complaint_type" id="complaint_type" class="form-control">
                                <option value="">Select Complaint Type</option>
                                <option value="online">Online</option>
                                <option value="offline">Offline</option>
                            </select>
                            <span class="text-danger error-text complaint_type_error"></span>
                        </div>

                        <div id="online-complaint" style="display: none;">
                            <div class="form-group">
                                <label>Complainant Name</label>
                                <input type="text" name="complainant_name" class="form-control">
                                <span class="text-danger error-text complainant_name_error"></span>
                            </div>

                            <div class="form-group">
                                <label>Complainant Email</label>
                                <input type="email" name="complainant_email" class="form-control">
                                <span class="text-danger error-text complainant_email_error"></span>
                            </div>

                            <div class="form-group">
                                <label>Platform</label>
                                <select name="platform" class="form-control">
                                    <option value="">Select Platform</option>
                                    <option value="WhatsApp">WhatsApp</option>
                                    <option value="Facebook">Facebook</option>
                                    <option value="Email">Email</option>
                                    <option value="Others">Others</option>
                                </select>
                                <span class="text-danger error-text platform_error"></span>
                            </div>
                        </div>

                        <div id="offline-complaint" style="display: none;">
                            <div class="form-group">
                                <label>Complainant Name</label>
                                <input type="text" name="complainant_name_offline" class="form-control">
                                <span class="text-danger error-text complainant_name_offline_error"></span>
                            </div>

                            <div class="form-group">
                                <label>Complainant NIC</label>
                                <input type="text" name="complainant_nic_offline" class="form-control">
                                <span class="text-danger error-text complainant_nic_offline_error"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Complaint Subject</label>
                            <input type="text" name="subject" class="form-control">
                            <span class="text-danger error-text subject_error"></span>
                        </div>

                        <div class="form-group">
                            <label>Complaint Description</label>
                            <textarea name="description" class="form-control" rows="4"></textarea>
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

            /* Show/Hide online or offline fields */
            $('#complaint_type').on('change', function() {
                if ($(this).val() === 'online') {
                    $('#online-complaint').show();
                    $('#offline-complaint').hide();
                } else if ($(this).val() === 'offline') {
                    $('#online-complaint').hide();
                    $('#offline-complaint').show();
                } else {
                    $('#online-complaint').hide();
                    $('#offline-complaint').hide();
                }
            });

            /* AJAX Form Submission */
            $('#complaintForm').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let formData = form.serialize();

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: formData,
                    beforeSend: function() {
                        form.find('span.error-text').text(''); // Clear previous error messages
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            // Clear form after successful submission
                            form[0].reset();
                            $('#online-complaint').hide();
                            $('#offline-complaint').hide();
                            showToast('success', response.success); // Show success toast

                            // Redirect after a short delay
                            setTimeout(function() {
                                window.location.href = response
                                .redirect; // Ensure this is formatted correctly
                            }, 1000); // Redirect after 1 seconds
                        }
                    },
                    error: function(response) {
                        // Check if errors are present in response
                        if (response.responseJSON && response.responseJSON.errors) {
                            let errors = response.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $('span.' + key + '_error').text(value[
                                0]); // Display each error
                            });
                        } else {
                            showToast('error',
                            'An unexpected error occurred.'); // General error toast
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
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
            }


        });
    </script>
@endpush
