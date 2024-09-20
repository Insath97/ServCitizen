@extends('admin.layouts.master')

@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Permissions</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Permission</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>All Permission</h4>
                    <div class="card-header-action">
                        <a href="" class="btn btn-primary" data-toggle="modal" data-target="#createPermission">
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
                                    <th>Group Name</th>
                                    <th>Permission</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->group_name }}</td>
                                        <th>{{ $item->name }}</th>
                                        <th>
                                            <a href="javascript;" class="btn btn-success mr-1 text-center modal_link"
                                                data-toggle="modal" data-target="#editPermissionModal"
                                                data-id="{{ $item->id }}" data-group-name="{{ $item->group_name }}"
                                                data-name="{{ $item->name }}">
                                                <i class="fas fa-edit fa-lg"></i>
                                            </a>

                                            <a href="{{ route('admin.permission.destroy', $item->id) }}"
                                                class="btn btn-danger text-center delete-item">
                                                <i class="fas fa-trash fa-lg"></i>
                                            </a>
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- create permission --}}
    @include('admin.permission.create')

    {{-- update permission --}}
    @include('admin.permission.edit')
@endsection

@push('scripts')
    <script>
        $("#table-1").dataTable({
            "columnDefs": [{
                "sortable": false,
                "targets": [2, 3]
            }]
        });

        $('body').on('click', '.modal_link', function() {
            var id = $(this).data('id');
            var group = $(this).data('group-name');
            var pname = $(this).data('name');

            let updateUrl = "{{ route('admin.permission.update', 'ID') }}".replace('ID', id);
            $('#editPermission').attr('action', updateUrl);

            $('input[name="permission_group_update"]').val(group);
            $('input[name="permission_update"]').val(pname);

        });

        @if ($errors->any())
            $('#editServiceStatusModal').modal('show');
        @endif
    </script>
@endpush
