<div class="card-body">
    <form action="" method="post" enctype="multipart/form-data">

        @csrf
        @method('PUT')

       {{--  <div class="form-group">
            <label>Footer Name</label>
            <input type="text" name="site_footer_name" value="" class="form-control @error('site_footer_name') is-invalid @enderror"
                id="name">
            @error('site_footer_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Footer Link</label>
            <input type="text" name="site_footer_link" value="" class="form-control @error('site_footer_link') is-invalid @enderror"
                id="name">
            @error('site_footer_link')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div> --}}

        <div class="form-group">
            <label>Version</label>
            <input type="text" name="site_footer_version" value="" class="form-control @error('site_footer_version') is-invalid @enderror"
                id="name">
            @error('site_footer_version')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
