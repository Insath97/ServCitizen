@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Profile</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Profile</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Hi, {{ $user->name }}</h2>
            <p class="section-lead">
                Change information about yourself on this page.
            </p>

            <div class="row mt-sm-4">

                <div class="col-12 col-md-6">
                    <div class="card">

                        <form method="post"
                            action="{{ route('admin.profile.update', auth()->guard('admin')->user()->id) }}"
                            class="needs-validation" novalidate="" enctype="multipart/form-data">

                            @csrf
                            {{-- this is update route so we need to use put method --}}
                            @method('PUT')

                            <div class="card-header">
                                <h4>Edit Profile</h4>
                            </div>

                            <div class="card-body">

                                <div class="form-group col-12">
                                    <div id="image-preview" class="image-preview">
                                        <label for="image-upload" id="image-label">Choose File</label>
                                        <input type="file" name="image" id="image-upload">
                                        <input type="hidden" name="old_image" value="{{ $user->image }}">
                                    </div>
                                    @error('image')
                                        <p class="text-danger mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group col-12">
                                    <label>Name</label>
                                    <input type="text" class="form-control" value="{{ $user->name }}" required
                                        name="name">
                                    <div class="invalid-feedback">
                                        Please fill in the first name
                                    </div>
                                    @error('name')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group col-12">
                                    <label>Email</label>
                                    <input type="email" class="form-control" value="{{ $user->email }}" required
                                        name="email">
                                    <div class="invalid-feedback">
                                        Please fill in the email
                                    </div>
                                    @error('email')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="card">
                        <form method="post" action="{{ route('admin.profile-password-update', $user->id) }}"
                            class="needs-validation" novalidate="" enctype="multipart/form-data">

                            @csrf
                            {{-- this is update route so we need to use put method --}}
                            @method('PUT')

                            <div class="card-header">
                                <h4>Update Password</h4>
                            </div>

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="password">Old Password</label>
                                    <input id="password" type="password" class="form-control" name="current_password"
                                        tabindex="1" required autofocus>
                                    <div class="invalid-feedback">
                                        Please fill in the Old password
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password">New Password</label>
                                    <input id="password" type="password" class="form-control" name="password"
                                        tabindex="1" required autofocus>
                                    <div class="invalid-feedback">
                                        Please fill in the New password
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm">Confirm Password</label>
                                    <input id="password" type="password" class="form-control" name="password_confirmation"
                                        tabindex="1" required autofocus>
                                    <div class="invalid-feedback">
                                        Please fill in the Confirm password
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" name="submit"
                                    class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

{{-- stack code for script --}}
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.image-preview').css({
                "background-image": "url('{{ asset($user->image) }}')",
                "background-size": "cover",
                "background-position": "center center"
            });
        });
    </script>
@endpush
