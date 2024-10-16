@extends('admin.layouts.master')

@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Complaints</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Complaints</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>All Complaints</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.complaint.create') }}" class="btn btn-primary">
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
                                    <th>Complaint Type</th>
                                    <th>Platform</th>
                                    <th>Complainant Name (Online)</th> <!-- For online complaints -->
                                    <th>Complainant Email (Online)</th> <!-- For online complaints -->
                                    <th>Complainant Name (Offline)</th> <!-- For offline complaints -->
                                    <th>Complainant NIC (Offline)</th> <!-- For offline complaints -->
                                    <th>Subject</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>

                            </thead>
                            <tbody>
                                @foreach ($complaints as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->code }}</td>
                                        <td>{{ $item->complaint_type }}</td>
                                        <td>
                                            @if ($item->complaint_type === 'online')
                                                {{ $item->platform }} <!-- Display platform for online complaints -->
                                            @else
                                                N/A <!-- Show N/A for offline complaints -->
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->complaint_type === 'online')
                                                {{ $item->complainant_name }} <!-- Display online complainant name -->
                                            @else
                                                N/A <!-- Show N/A for offline complaints -->
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->complaint_type === 'online')
                                                {{ $item->complainant_email }} <!-- Display online complainant email -->
                                            @else
                                                N/A <!-- Show N/A for offline complaints -->
                                            @endif
                                        </td>

                                        <td>
                                            @if ($item->complaint_type === 'offline')
                                                {{ $item->complainant_name_offline }}
                                                <!-- Display offline complainant name -->
                                            @else
                                                N/A <!-- Show N/A for online complaints -->
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->complaint_type === 'offline')
                                                {{ $item->complainant_nic_offline }}
                                                <!-- Display NIC for offline complaints -->
                                            @else
                                                N/A <!-- Show N/A for online complaints -->
                                            @endif
                                        </td>
                                        <td>{{ $item->subject }}</td> <!-- Display subject of the complaint -->
                                        <td>{{ $item->description }}</td> <!-- Display description of the complaint -->
                                        <td>
                                            <div class="d-flex justify-content-start">
                                                <a href="{{ route('admin.complaint.edit', $item->id) }}"
                                                    class="btn btn-success mr-1 text-center">
                                                    <i class="fas fa-edit fa-lg"></i>
                                                </a>
                                                <a href="{{ route('admin.complaint.destroy', $item->id) }}"
                                                    class="btn btn-danger text-center delete-item">
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
