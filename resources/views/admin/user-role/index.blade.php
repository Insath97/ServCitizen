@extends('admin.layouts.master')

@section('content')
    <div class="section">
        <div class="section-header">
            <h1>User Roles</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">User Roles</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>All User & Roles</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.user-role.create') }}" class="btn btn-primary">
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
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td><span class="badge badge-primary">{{ $user->getRoleNames()->first() }}</span>
                                        </td>
                                        <td>
                                            @if ($user->getRoleNames()->first() != 'Super Admin')
                                                <a href="{{ route('admin.user-role.edit', $user->id) }}"
                                                    class="btn btn-success mr-1 text-center">
                                                    <i class="fas fa-edit fa-lg"></i></a>

                                                <a href="{{ route('admin.user-role.destroy', $user->id) }}"
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
