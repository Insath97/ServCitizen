<div class="card-body">
    <form action="{{ route('admin.general-setting.update') }}" method="post" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="form-group">
            <label>System Name</label>
            <input type="text" name="site_name" value="{{ getSettingInfo('site_name') }}"
                class="form-control @error('site_name') is-invalid @enderror" id="name">
            @error('site_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>DS Office Name</label>
            <input type="text" name="site_office_name" value="{{ getSettingInfo('site_office_name') }}"
                class="form-control @error('site_office_name') is-invalid @enderror" id="name">
            @error('site_office_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>System Mail</label>
            <input type="text" name="site_office_mail" value="{{ getSettingInfo('site_office_mail') }}"
                class="form-control @error('site_office_mail') is-invalid @enderror" id="name">
            @error('site_office_mail')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Company Name</label>
            <input type="text" name="site_company_name" value="{{ getSettingInfo('site_company_name') }}"
                class="form-control @error('site_company_name') is-invalid @enderror" id="name">
            @error('site_company_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{--     <div class="form-group">

            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-3  border justify-content-center">
                        <div class="gallery gallery-fw w-100 h-100">
                            <div class="gallery-item ">
                                <img src="" alt="Site Logo"
                                    class="img-fluid w-100 h-100 my-2" style="object-fit:contain;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <label> Logo</label>
            <input type="file" name="site_logo" class="form-control @error('site_logo') is-invalid @enderror"
                id="name">
            @error('site_logo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-3  border justify-content-center">
                        <div class="gallery gallery-fw w-100 h-100">
                            <div class="gallery-item ">
                                <img src="" alt="Site Logo"
                                    class="img-fluid w-100 h-100 my-2" style="object-fit:contain;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <label> Favicon</label>
            <input type="file" name="site_favicon" value=""
                class="form-control @error('site_favicon') is-invalid @enderror" id="name">
            @error('site_favicon')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        --}}

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
