@extends('admin.layouts.master')

@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Services</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Services</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>All Services</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
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
                                    <th>Service Code</th>
                                    <th>Service Type</th>
                                    <th>Service Name</th>
                                    <th>Branch</th>
                                    <th>Sub Unit</th>
                                    <th>Fees Type</th>
                                    <th>Amout</th>
                                    <th>Resolution Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $service)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $service->code }}</td>
                                        <td>{{ $service->service_type->name }}</td>
                                        <td>{{ $service->name }}</td>
                                        <td>{{ $service->branch->name }}</td>
                                        <td>{{ $service->unit->unit_name }}</td>
                                        <td>{{ $service->fees_type }}</td>
                                        @if ($service->fees_type === 'free')
                                            <td><span class="badge badge-success">{{ $service->amount }}</span></td>
                                        @else
                                            <td><span class="badge badge-primary">₨
                                                    {{ number_format($service->amount, 2) }}</span></td>
                                        @endif
                                        <td>{{ $service->r_time }} {{ $service->r_time_type }}</td>
                                        <td>
                                            <div class="d-flex justify-content-start">
                                                <a href="{{ route('admin.services.edit', $service->id) }}"
                                                    class="btn btn-success mr-2">
                                                    <i class="fas fa-edit fa-lg"></i>
                                                </a>
                                                <a href="{{ route('admin.services.destroy', $service->id) }}"
                                                    class="btn btn-danger delete-item">
                                                    <i class="fas fa-trash fa-lg"></i>
                                                </a>
                                            </div>
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
@endsection

@push('scripts')
    <script>
        $("#table-1").dataTable({
            "columnDefs": [{
                "sortable": false,
                "targets": [2, 3]
            }]
        });

        $("#table-2").dataTable({
            "columnDefs": [{
                "sortable": false,
                "targets": [2, 3]
            }]
        });
    </script>
@endpush
