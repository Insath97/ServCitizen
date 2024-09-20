@extends('admin.layouts.master')

@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Services Status</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Status</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>All Services Status</h4>
                    <div class="card-header-action">
                        <a href="" class="btn btn-primary" data-toggle="modal" data-target="#newServiceStatusModal">
                            <i class="fas fa-plus"></i>
                            Create New
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Status Name</th>
                                    <th>Color Code</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($statues as $status)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $status->status_name }}</td>
                                        <td> <span class="badge text-white"
                                                style="background-color: {{ $status->status_color }}">{{ $status->status_name }}</span>
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-success mr-1 text-center modal_link"
                                                data-id="{{ $status->id }}" data-statusname="{{ $status->status_name }}"
                                                data-statuscolor="{{ $status->status_color }}" data-toggle="modal"
                                                data-target="#editServiceStatusModal">
                                                <i class="fas fa-edit fa-lg"></i>
                                            </a>

                                            <a href="{{ route('admin.services-status.destroy', $status->id) }}"
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

    {{-- create status model --}}
    @include('admin.services-status.create')

    {{-- update status model --}}
    @include('admin.services-status.edit')
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#table-1").dataTable({
                "columnDefs": [{
                    "sortable": false,
                    "targets": [2, 3]
                }]
            });

            $('body').on('click', '.modal_link', function() {
                var id = $(this).data('id');
                var statusName = $(this).data('statusname');
                var statusColor = $(this).data('statuscolor');

                let updateUrl = "{{ route('admin.services-status.update', 'ID') }}".replace('ID', id);
                $('#editServiceStatusForm').attr('action', updateUrl);

                $('input[name="status_name_update"]').val(statusName);
                $('input[name="status_color_update"]').val(statusColor);

            });

            @if ($errors->any())
                $('#editServiceStatusModal').modal('show');
            @endif
        });
    </script>
@endpush
