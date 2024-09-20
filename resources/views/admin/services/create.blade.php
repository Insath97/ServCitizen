@extends('admin.layouts.master')

@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Services</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.services.index') }}">Services</a></div>
                <div class="breadcrumb-item">Create New</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Create New Service</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.services.store') }}" method="post">
                        @csrf

                        <div class="form-group">
                            <label>Service Type</label>
                            <select name="service_type"
                                class="form-control select2 @error('service_type') is-invalid @enderror" id="service_type">
                                <option value="">Select Service Type</option>
                                @foreach ($service_type as $stype)
                                    <option value="{{ $stype->id }}">{{ $stype->name }}</option>
                                @endforeach
                            </select>
                            @error('service_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="service" class="col-form-label font-weight-bold">Service Code</label>
                            <input type="text" class="form-control @error('service_code') is-invalid @enderror"
                                name="service_code">
                            @error('service_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Service Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Does this service have subservices?</label>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-primary">
                                    <input type="radio" name="has_subservices" id="has_subservices_yes" autocomplete="off"
                                        value="0"> Yes
                                </label>
                                <label class="btn btn-primary">
                                    <input type="radio" name="has_subservices" id="has_subservices_no" autocomplete="off"
                                        value="1" checked> No
                                </label>
                            </div>
                        </div>

                        <!-- Subservice input fields -->
                        <div id="subservice-fields" style="display: none;">

                            <div class="form-group">
                                <label>Branch Name</label>
                                @if (count($branches) > 0)
                                    <select name="branch_id" id="branch_id"
                                        class="form-control select2 @error('branch_id') is-invalid @enderror">
                                        <option value="">Select Branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="text" name="" class="form-control" value="No Data Found"
                                        readonly>
                                @endif
                                @error('branch_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Sub Unit</label>
                                <select name="unit_id" id="unit_id"
                                    class="form-control select2 @error('unit_id') is-invalid @enderror">
                                    <option value="">Select unit</option>
                                </select>
                                @error('unit_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Fees Type</label>
                                <select name="fees_type"
                                    class="form-control select2 @error('fees_type') is-invalid @enderror" id="fees_type">
                                    <option value="">Select Fees Type</option>
                                    <option value="free">Free Service</option>
                                    <option value="paid">Paid</option>
                                </select>
                                @error('fees_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Amount (LKR)</label>
                                <input type="text" name="amount" id="amount"
                                    class="form-control @error('amount') is-invalid @enderror">
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label>Resolution Time (Benchmark)</label>
                                    <input type="text" id="r_time" name="r_time"
                                        class="form-control @error('r_time') is-invalid @enderror">
                                    @error('r_time')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4 mt-4 d-flex justify-content-start">
                                    <label class="custom-switch mt-2">
                                        <input type="radio" name="r_time_type" value="minutes"
                                            class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Minutes</span>
                                    </label>
                                    <label class="custom-switch mt-2 ml-3">
                                        <input type="radio" name="r_time_type" value="hours"
                                            class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Hours</span>
                                    </label>
                                    <label class="custom-switch mt-2 ml-3">
                                        <input type="radio" name="r_time_type" value="days"
                                            class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Days</span>
                                    </label>
                                </div>
                            </div>

                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('input[name="has_subservices"]').on('change', function() {
                let value = $(this).val();
                if (value === "1") {
                    $('#subservice-fields').show();
                } else {
                    $('#subservice-fields').hide();
                }
            });

            $('input[name="has_subservices"]:checked').trigger('change');

            // Fees Type change event
            $('#fees_type').on('change', function() {
                let select_value = $(this).val();
                if (select_value === 'free') {
                    $('#amount').val('Free');
                    $('#amount').prop('readonly', true);
                    $('#amount').css({
                        'text-align': 'left'
                    });
                } else {
                    $('#amount').val('');
                    $('#amount').prop('readonly', false);
                    $('#amount').css({
                        'text-align': 'right'
                    });

                    $('#amount').on('input', function() {
                        let value = $(this).val();
                        value = value.replace(/[^0-9.]/g, '');
                        let parts = value.split('.');

                        if (parts[0].length > 0) {
                            parts[0] = String(parseInt(parts[0], 10));
                        }

                        if (parts[1] && parts[1].length > 2) {
                            parts[1] = parts[1].substr(0, 2);
                        }

                        value = parts.join('.');

                        $(this).val(value);
                    });

                    $('#amount').on('blur', function() {
                        let value = $(this).val();
                        if (value && value.indexOf('.') === -1) {
                            value += '.00';
                        } else if (value && value.indexOf('.') !== -1) {
                            let parts = value.split('.');
                            if (parts[1].length === 1) {
                                value += '0';
                            }
                        }
                        $(this).val(value);
                    });
                }
            });

            $('#fees_type').trigger('change');

            // Branch change event for fetching units
            $('#branch_id').on('change', function() {
                let branch_id = $(this).val();

                // using ajax
                $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.fetch-service-unit') }}",
                    data: {
                        branch_id: branch_id
                    },
                    success: function(data) {
                        $('#unit_id').html("");
                        $('#unit_id').html(`<option value="">Select unit</option>`);

                        $.each(data, function(index, item) {
                            $('#unit_id').append(
                                `<option value="${item.id}">${item.unit_name}</option>`
                            );
                        });
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });


        });
    </script>
@endpush
