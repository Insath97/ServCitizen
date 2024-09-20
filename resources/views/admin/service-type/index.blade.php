@extends('admin.layouts.master')

@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Service Types</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Service Types</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>All Service Types</h4>
                    <div class="card-header-action">
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#newServiceTypeModal">
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
                                    <th>Code</th>
                                    <th>Service Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($service_types as $service_type)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $service_type->code }}</td>
                                        <td>{{ $service_type->name }}</td>
                                        <td>
                                            <a href="#" class="btn btn-success mr-1 text-center modal_link"
                                                data-id="{{ $service_type->id }}" data-value="{{ $service_type->name }}" data-code="{{ $service_type->code }}"
                                                data-toggle="modal" data-target="#updateServiceTypeModal">
                                                <i class="fas fa-edit fa-lg"></i>
                                            </a>

                                            <a href="{{ route('admin.service-type.destroy', $service_type->id) }}"
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

    {{-- Create Service Type Modal --}}
    @include('admin.service-type.create')

    {{-- Update Service Type Modal --}}
    @include('admin.service-type.edit')

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#table-1").dataTable({
                "columnDefs": [{
                    "sortable": false,
                    "targets": [2]
                }]
            });

            $('body').on('click', '.modal_link', function() {
                let id = $(this).data('id');
                let code = $(this).data('code');
                let value = $(this).data('value');

                let updateUrl = "{{ route('admin.service-type.update', 'ID') }}".replace('ID', id);
                $('#updateServiceTypeForm').attr('action', updateUrl);

                $('input[name="service_type_code_update"]').val(code);
                $('input[name="service_type_update"]').val(value);
                $('input[name="id"]').val(id);
            });
        });
    </script>
@endpush
