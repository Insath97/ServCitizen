<div class="card-body">
    <form action="{{ route('admin.appearance.update') }}" method="post" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Pick Your Site Color</label>
            <div class="input-group colorpickerinput">
                <input type="text" value="" class="form-control @error('site_color') is-invalid @enderror" name="site_color">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-fill-drip"></i>
                    </div>
                </div>
            </div>
            @error('site_color')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
