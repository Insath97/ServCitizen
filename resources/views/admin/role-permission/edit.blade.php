@extends('admin.layouts.master')

@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Roles</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.role.index') }}">Roles & Permissions</a></div>
                <div class="breadcrumb-item">Edit</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Edit Role</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.role.update',$roles->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Role Name</label>
                            <input type="text" name="role_name" value="{{ $roles->name }}"
                                class="form-control @error('role_name') is-invalid @enderror" id="name">
                            @error('role_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @foreach ($permissions as $groupName => $permission)
                            <div class="section-title mt-0">{{ $groupName }}</div>
                            <div class="form-group">
                                <div class="row">

                                    @foreach ($permission as $item)
                                        <div class="col-12 col-sm-6 col-md-3">
                                            <label class="custom-switch mt-2">
                                                <input type="checkbox" name="permissions[]" class="custom-switch-input"
                                                    {{ in_array($item->name, $role_permission) ? 'checked' : '' }}
                                                    value="{{ $item->name }}">
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">{{ $item->name }}</span>
                                            </label>
                                        </div>
                                    @endforeach

                                </div>
                                <hr>
                            </div>
                        @endforeach

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
