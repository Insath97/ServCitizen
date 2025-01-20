@extends('admin.layouts.master')

@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Payments</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Payment</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-body">
                    <!-- Search Form -->
                    <form id="search-form">

                        <div class="form-group">
                            <select name="search" id="search-input" class="form-control select2">
                                <option value="">Token Number</option>
                                @foreach ($paid_token as $item)
                                    <option value="{{ $item->id }}">{{ $item->token_number }}</option>
                                @endforeach
                            </select>
                        </div>

                    </form>
                    <hr>
                    <!-- Results Table -->
                    <div class="table-responsive">
                        <table class="table table-striped" id="clientTable">
                            <thead>
                                <tr>
                                    <th>Token</th>
                                    <th>Client Number</th>
                                    <th>Service Type</th>
                                    <th>Service Name</th>
                                    <th>Sub Service</th>
                                    <th>Payment Status</th>
                                    <th>Amount</th>
                                    <th>Created Date</th>
                                </tr>
                            </thead>
                            <tbody id="resultBody">
                                <tr id="no-data-row">
                                    <td colspan="8" class="text-center">No data found</td>
                                </tr>
                            </tbody>
                        </table>
                        <div id="noDataMessage" style="display:none; color: red; margin-top: 20px;">
                            No data found.
                        </div>
                    </div>

                    <!-- Payment Form Section -->
                    <div id="payment-section" style="display:none; margin-top: 20px;">
                        <hr>
                        <h5>Payment Details</h5>
                        <form id="payment-form" method="POST">
                            @csrf
                            <input type="hidden" id="token-id" name="token_id">
                            <div class="form-group">
                                <label for="payment-method">Payment Method</label>
                                <select class="form-control" id="payment-method" name="payment_method">
                                    <option value="cash">Cash</option>
                                    <option value="card">Card</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control" id="amount" name="amount" step="0.01"
                                    required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Received Payment</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Your custom scripts -->
    <script>
        $(document).ready(function() {
            // Handle Search Form Submission
            $('#search-form').on('change', function(event) {
                event.preventDefault();
                var searchQuery = $('#search-input').val().trim();

                // Client-side validation
                if (searchQuery === '') {
                    alert('Please enter a token number.');
                    return; // Stop the form submission
                }

                $.ajax({
                    url: "{{ route('admin.payment.search') }}",
                    type: "GET",
                    data: {
                        search: searchQuery
                    },
                    success: function(response) {
                        $('#resultBody').empty();
                        $('#noDataMessage').hide();
                        $('#no-data-row').hide();
                        $('#payment-section').hide(); // Hide payment section initially

                        if (response.status === 'success' && response.token) {
                            var subServiceName = response.token.sub_service ? response.token
                                .sub_service.name : 'N/A';

                            let amount = '';
                            if (response.token.main_service.have_sub_service === 1) {
                                amount = response.token.service.amount;
                            } else if (response.token.main_service.have_sub_service === 0) {
                                amount = response.token.sub_service.amount
                            }
                            $('#amount').val(amount).prop('readonly', true);


                            let badgeClass = '';
                            let badgeText = response.token.payment_status;

                            if (badgeText.toLowerCase() === 'pending payment') {
                                badgeClass = 'badge badge-danger';
                            } else if (badgeText.toLowerCase() === 'free') {
                                badgeClass = 'text-darkgreen'; // Use custom text color
                            } else if (badgeText.toLowerCase() === 'paid') {
                                badgeClass = 'badge badge-primary';
                            }

                            // Populate the table with the token details
                            $('#resultBody').append(`
                    <tr>
                        <td>${response.token.token_number}</td>
                        <td>${response.token.client.client_number}</td>
                        <td>${response.token.main_service.service_type.name}</td>
                        <td>${response.token.main_service.name}</td>
                        <td>${subServiceName}</td>
                        <td>
                            <span class="${badgeClass}">
                                ${badgeText}
                            </span>
                        </td>
                        <td>LKR ${amount}</td>
                        <td>${new Date(response.token.created_at).toLocaleDateString()}</td>
                    </tr>
                `);

                            // Show the payment form only if the payment status is "Pending Payment"
                            if (badgeText.toLowerCase() === 'pending payment') {
                                $('#payment-section').show();
                                $('#token-id').val(response.token.id);

                            }
                        } else {
                            $('#noDataMessage').show();
                            $('#no-data-row').show();
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire(
                            'Error!',
                            'An error occurred while searching for the token.',
                            'error'
                        );
                    }
                });
            });


            $('#payment-form').on('submit', function(event) {
                event.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('admin.payment.store') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Payment Saved!',
                                text: 'Do you want to print the invoice?',
                                icon: 'success',
                                showCancelButton: true,
                                confirmButtonText: 'Yes, print it!',
                                cancelButtonText: 'No, thanks'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    var printRoute =
                                        "{{ route('admin.token.print', ':request_id') }}";
                                    printRoute = printRoute.replace(':request_id',
                                        response.token.id);

                                    // Open the print window with the correct request ID
                                    var printWindow = window.open(printRoute, '_blank',
                                        'width=600,height=800');
                                    printWindow.onload = function() {
                                        printWindow.print();

                                        // Close the print window after printing
                                        printWindow.onafterprint = function() {
                                            printWindow.close();
                                            window.location.reload();
                                        };

                                        // Fallback close mechanism
                                        setTimeout(function() {
                                            printWindow.close();
                                            window.location.reload();
                                        }, 20000);
                                    };
                                } else {
                                    Swal.fire('Success!', 'Payment saved successfully.',
                                            'success')
                                        .then(() => location.reload());
                                }
                            });
                        } else {
                            Swal.fire('Error!', 'There was an issue saving the payment.',
                                'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'An error occurred while saving the payment.',
                            'error');
                    }
                });
            });


        });
    </script>
@endpush
