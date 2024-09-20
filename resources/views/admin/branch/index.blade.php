@extends('admin.layouts.master')

@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Branch</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Branch</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>All Branches</h4>
                    <div class="card-header-action">
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#newBranchModal">
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
                                    <th>Branch Name</th>
                                    <th>Floor Number</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($branches as $branch)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $branch->name }}</td>
                                        <td>{{ $branch->floor }}</td>
                                        <td>
                                            <a href="#" class="btn btn-success modal_link"
                                                data-id="{{ $branch->id }}" data-branch="{{ $branch->name }}"
                                                data-floor="{{ $branch->floor }}" data-toggle="modal"
                                                data-target="#editBranchModal">
                                                <i class="fas fa-edit fa-lg"></i>
                                            </a>

                                            <a href="{{ route('admin.branch.destroy', $branch->id) }}"
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

    {{-- create new branch model --}}
    @include('admin.branch.create')

    {{-- edit branch model --}}
    @include('admin.branch.edit')
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
            $('body').on('click', '.modal_link', function() {
                var id = $(this).data('id');
                var branchName = $(this).data('branch');
                var floorName = $(this).data('floor');

                let updateUrl = "{{ route('admin.branch.update', 'ID') }}".replace('ID', id);
                $('#editBranchForm').attr('action', updateUrl);

                // Populate the input fields
                $('input[name="branch_update"]').val(branchName);
                $('input[name="floor_name_update"]').val(floorName);
                $('input[name="branch_id"]').val(id);

                $('#editBranchModal').modal('show');

            });
        });
    </script>
@endpush
