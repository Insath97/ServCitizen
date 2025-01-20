@extends('admin.layouts.master')

@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Requests</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">All Requests</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>All Requests</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.service-request.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            Create New
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="table-1">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Token</th>
                                    <th>NIC</th>
                                    <th>Client Name</th>
                                    <th>Phone Number</th>
                                    <th>Service Name</th>
                                    <th>Sub Service Name</th>
                                    <th>Request Status</th>
                                    <th>Created Date</th>
                                    <th>View More</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($request_services as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->token_number }}</td>
                                        <td>{{ $item->client->nic }}</td>
                                        <td>{{ $item->client->name }}</td>
                                        <td>{{ $item->client->mobile }}</td>
                                        <td>{{ $item->main_service->name }}</td>
                                        <td>
                                            @if ($item->sub_service)
                                                {{ $item->sub_service->name }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge text-white"
                                                style="background-color: {{ $item->status->status_color }}">
                                                {{ $item->status->status_name }}
                                            </span>
                                        </td>
                                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="javascript:void(0);" class="btn btn-secondary text-center view-more"
                                                data-token="{{ $item->token_number }}" data-nic="{{ $item->client->nic }}"
                                                data-client_number="{{ $item->client->client_number }}"
                                                data-client_name="{{ $item->client->name }}"
                                                data-phone_number="{{ $item->client->mobile }}"
                                                data-service_name="{{ $item->main_service->name }}"
                                                data-service_type="{{ $item->main_service->service_type->name }}"
                                                data-status_name="{{ $item->status->status_name }}"
                                                data-remarks="{{ $item->status_history()->latest()->first()->feedback ?? 'No feedback available';  }}"
                                                data-status_color="{{ $item->status->status_color }}"
                                                data-created_at="{{ $item->created_at->format('Y-m-d H:i:s') }}"
                                                @if ($item->main_service->have_sub_service == 0 && $item->sub_service) data-sub_service="{{ $item->sub_service->name }}"
                                                    data-branch_name="{{ $item->sub_service->branch->name }}"
                                                    data-unit_name="{{ $item->sub_service->unit->unit_name }}"
                                                    data-fees_type="{{ $item->sub_service->fees_type }}"
                                                    @if ($item->sub_service->fees_type == 'paid')
                                                        data-amount="{{ $item->sub_service->amount }}" @endif
                                                @endif
                                                @if ($item->main_service->have_sub_service == 1) data-sub_service="N/A"
                                                    data-branch_name="{{ $item->service->branch->name }}"
                                                    data-unit_name="{{ $item->service->unit->unit_name }}"
                                                    data-fees_type="{{ $item->service->fees_type }}"
                                                    @if ($item->service->fees_type == 'paid')
                                                        data-amount="{{ $item->service->amount }}" @endif
                                @endif
                                data-toggle="modal" data-target="#exampleModal">
                                <i class="fas fa-external-link-alt"></i>
                                </a>

                                </td>
                                <td style="width: 15%;">

                                    @if ($item->payment_status == 'free')
                                        <a href="{{ route('admin.service-request.print', $item->id) }}"
                                            class="btn btn-warning mr-1 text-center print-request"
                                            data-id="{{ $item->id }}">
                                            <i class="fas fa-print fa-lg"></i>
                                        </a>
                                    @endif

                                    {{-- <a href="#" class="btn btn-success mr-1 text-center edit-request"
                                        data-id="{{ $item->id }}" data-client_name="{{ $item->client->name }}"
                                        data-client_number="{{ $item->client->client_number }}"
                                        data-client_id="{{ $item->client->id }}"
                                        data-service_type_id="{{ $item->main_service_type_id }}"
                                        data-service_id="{{ $item->service_id }}" data-status_id="{{ $item->status_id }}"
                                        data-notes="{{ $item->description }}" data-toggle="modal"
                                        data-target="#editRequestModal">
                                        <i class="fas fa-edit fa-lg"></i>
                                    </a> --}}

                                    <a href="{{ route('admin.service-request.destroy', $item->id) }}"
                                        class="btn btn-danger text-center delete-item">
                                        <i class="fas fa-trash fa-lg"></i>
                                    </a>
                                </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>

    {{-- show data in model --}}
    @include('admin.request.show')

    {{-- edit request --}}
    @include('admin.request.edit')
@endsection

@push('scripts')
    <script>
        $("#table-1").dataTable({
            "columnDefs": [{
                "sortable": false,
                "targets": [2, 3]
            }]
        });


        $(document).ready(function() {

            $('#edit_service_type_id').on('change', function() {
                let service_type_id = $(this).val();
                $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.fetch-service-type') }}",
                    data: {
                        service_type_id: service_type_id
                    },
                    success: function(data) {

                        $.each(data, function(index, item) {
                            $('#edit_service_id').append(
                                `<option value="${item.id}">${item.name}</option>`
                            );
                        });
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });

            $('body').on('click', '.view-more', function() {

                $('#modal-token').val($(this).data('token'));
                $('#modal-nic').val($(this).data('nic'));
                $('#modal-client_number').val($(this).data('client_number'));
                $('#modal-client_name').val($(this).data('client_name'));
                $('#modal-phone_number').val($(this).data('phone_number'));
                $('#modal-service_name').val($(this).data('service_name'));
                $('#modal-service_type').val($(this).data('service_type'));
                $('#modal-branch_name').val($(this).data('branch_name') ? $(this).data('branch_name') :
                    'N/A');
                $('#modal-unit_name').val($(this).data('unit_name') ? $(this).data('unit_name') : 'N/A');
                $('#modal-created_at').val($(this).data('created_at'));
                $('#modal-sub_service_name').val($(this).data('sub_service'));

                $('#modal-status_name').val($(this).data('status_name'));
                let status_color = $(this).data('status_color');
                $('#modal-status_name').css('background-color', status_color);

                $('#modal-feedback').val($(this).data('remarks'));

                $('#modal-fees_type').val($(this).data('fees_type'));
                $('#modal-amount').val($(this).data('amount') ? $(this).data('amount') : 'Free');
            });

            $('body').on('click', '.edit-request', function() {
                // Get data attributes from the clicked element
                let id = $(this).data('id');
                let clientName = $(this).data('client_name');
                let clientNumber = $(this).data('client_number');
                let clientId = $(this).data('client_id');
                let serviceTypeId = $(this).data('service_type_id');
                let serviceId = $(this).data('service_id');
                let statusId = $(this).data('status_id');
                let notes = $(this).data('notes');

                // Log values for debugging
                console.log('ID:', id);
                console.log('Client Name:', clientName);
                console.log('Client Number:', clientNumber);
                console.log('Client ID:', clientId);
                console.log('Service Type ID:', serviceTypeId);
                console.log('Service ID:', serviceId);
                console.log('Status ID:', statusId);
                console.log('Notes:', notes);

                // Set the form action to the correct update route
                let updateUrl = "{{ route('admin.service-request.update', ':id') }}".replace(':id', id);
                $('#editRequestModal form').attr('action', updateUrl);

                // Populate the modal fields
                $('#edit_client_name').val(clientName);
                $('#edit_client_number').val(clientNumber);
                $('#edit_client_id').val(clientId);
                $('select[name="service_type_id"]').val(serviceTypeId).trigger('change');
                $('select[name="service_id"]').val(serviceId).trigger('change');
                $('#edit_service_id').val(serviceId);
                $('#edit_status_id').val(statusId);
                $('textarea[name="notes"]').val(notes);

                // Show the modal
                $('#editRequestModal').modal('show');
            });

        });

        /* print receipt code */
        $(document).on('click', '.print-request', function(e) {
            e.preventDefault();

            var printUrl = $(this).attr('href');

            var printWindow = window.open(printUrl, '_blank', 'width=600,height=800');

            printWindow.onload = function() {
                setTimeout(function() {
                    printWindow.print();
                    printWindow.close();
                }, 1000);
            };
        });
    </script>
@endpush
