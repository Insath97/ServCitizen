@extends('admin.layouts.master')

@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Roles & Permissions</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Roles & Permissions</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>All Roles & Permissions</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.role.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            Create New
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="table-1">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Role Name</th>
                                    <th>Permission</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td class="w-50">
                                            @foreach ($role->permissions as $permission)
                                                <span class="badge badge-primary mb-1">{{ $permission->name }}</span>
                                            @endforeach

                                            @if ($role->name === 'Super Admin')
                                                <span class="badge badge-info">All Permissions</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($role->name != 'Super Admin')
                                                <a href="{{ route('admin.role.edit', $role->id) }}"
                                                    class="btn btn-success mr-1 text-center">
                                                    <i class="fas fa-edit fa-lg"></i></a>

                                                <a href="{{ route('admin.role.destroy', $role->id) }}"
                                                    class="btn btn-danger text-center delete-item">
                                                    <i class="fas fa-trash fa-lg"></i></a>
                                            @endif
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
