@extends('admin.layouts.master')

@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Sub Services</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Sub Services</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>All Sub Services</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.sub-service.create') }}" class="btn btn-primary">
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
                                    <th>Service Name</th>
                                    <th>Sub Service Code</th>
                                    <th>Sub Service Name</th>
                                    <th>Branch</th>
                                    <th>Sub Unit</th>
                                    <th>Fees Type</th>
                                    <th>Amout</th>
                                    <th>Resolution Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sub_services as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->main_service->code }}</td>
                                        <td>{{ $item->main_service->name }}</td>
                                        <td>{{ $item->code }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->branch->name }}</td>
                                        <td>{{ $item->unit->unit_name }}</td>
                                        <td>{{ $item->fees_type }}</td>
                                        @if ($item->fees_type === 'free')
                                            <td><span class="badge badge-success">{{ $item->amount }}</span></td>
                                        @else
                                            <td><span class="badge badge-primary">₨
                                                    {{ number_format($item->amount, 2) }}</span></td>
                                        @endif
                                        <td>{{ $item->r_time }} {{ $item->r_time_type }}</td>
                                        <td>
                                            <div class="d-flex justify-content-start">
                                                <a href="{{ route('admin.sub-service.edit', $item->id) }}"
                                                    class="btn btn-success mr-2">
                                                    <i class="fas fa-edit fa-lg"></i>
                                                </a>
                                                <a href="{{ route('admin.sub-service.destroy', $item->id) }}"
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
    </script>
@endpush
