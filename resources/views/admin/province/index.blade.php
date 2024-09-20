@extends('admin.layouts.master')

@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Provinces</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Province</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>All Provinces</h4>
                    <div class="card-header-action">
                        <a href="" class="btn btn-primary" data-toggle="modal" data-target="#newProvinceModal">
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
                                    <th>Province Code</th>
                                    <th>Province Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($provinces as $province)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $province->code }}</td>
                                        <td>{{ $province->province }}</td>
                                        <td>
                                            <a href="#" class="btn btn-success mr-1 text-center modal_link"
                                                data-id="{{ $province->id }}" data-province="{{ $province->province }}"
                                                data-code="{{ $province->code }}" data-toggle="modal"
                                                data-target="#editProvinceModal">
                                                <i class="fas fa-edit fa-lg"></i>
                                            </a>


                                            <a href="{{ route('admin.province.destroy', $province->id) }}"
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

    {{-- create model --}}
    @include('admin.province.create')

    {{-- edit model --}}
    @include('admin.province.edit')
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#table-1').DataTable({
                "columnDefs": [{
                    "sortable": false,
                    "targets": [2]
                }]
            });

            $('body').on('click', '.modal_link', function() {
                var id = $(this).data('id');
                var code = $(this).data('code');
                var province = $(this).data('province');

                console.log(code);

                let updateUrl = "{{ route('admin.province.update', 'ID') }}".replace('ID', id);
                $('#editProvinceForm').attr('action', updateUrl);

                $('input[name="province_code_update"]').val(code);
                $('input[name="province_update"]').val(province);

            });

            @if ($errors->any())
                $('#editServiceStatusModal').modal('show');
            @endif
        });
    </script>
@endpush
