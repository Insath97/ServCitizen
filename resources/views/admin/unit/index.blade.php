@extends('admin.layouts.master')

@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Sub units</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Units</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>All Units</h4>
                    <div class="card-header-action">
                        <a href="" class="btn btn-primary" data-toggle="modal" data-target="#newSubUnitModal">
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
                                    <th>Unit Name</th>
                                    <th>Branch Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($units as $unit)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $unit->unit_name }}</td>
                                        <td>{{ $unit->branch->name }}</td>
                                        <td>
                                            <a href="" class="btn btn-success mr-1 text-center modal_link"
                                                data-id="{{ $unit->id }}" data-unit-name="{{ $unit->unit_name }}"
                                                data-branch-id="{{ $unit->branch_id }}"
                                                data-branch="{{ @$unit->branc->name }}" data-toggle="modal"
                                                data-target="#editSubUnitModal">
                                                <i class="fas fa-edit fa-lg"></i>
                                            </a>

                                            <a href="{{ route('admin.units.destroy', $unit->id) }}"
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

    {{-- create new unit model --}}
    @include('admin.unit.create')

    {{-- edit unit model --}}
    @include('admin.unit.edit')
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

            $('.select2').select2({
                width: '100%',
                placeholder: 'Select a Branch',
                allowClear: true
            });

            $('body').on('click', '.modal_link', function() {
                var id = $(this).data('id');
                var unitName = $(this).data('unit-name');
                var branchId = $(this).data('branch-id');

                console.log(branchId);


                let updateUrl = "{{ route('admin.units.update', 'ID') }}".replace('ID', id);
                $('#editSubUnitForm').attr('action', updateUrl);

                $('input[name="unit_name_update"]').val(unitName);
                $('select[name="branch_id_update"]').val(branchId).trigger('change');




            });

            @if ($errors->any())
                $('#editSubUnitModal').modal('show');
            @endif
        });
    </script>
@endpush
