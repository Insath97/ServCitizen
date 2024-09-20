<div class="card-body">
    <form action="" method="post" enctype="multipart/form-data">

        @csrf
        <div class="form-group">
            <label> Host</label>
            <input type="text" name="site_api_host" value="" class="form-control @error('site_api_host') is-invalid @enderror"
                id="name">
            @error('site_api_host')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label> Key</label>
            <input type="text" name="site_api_key" value="" class="form-control @error('site_api_key') is-invalid @enderror"
                id="name">
            @error('site_api_key')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
