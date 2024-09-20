@extends('admin.layouts.master')

@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Clients</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Clients</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>All Clients</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.client.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            Create New
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="table-1">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>NIC</th>
                                    <th>Client Queue</th>
                                    <th>Client Name</th>
                                    <th>Gender</th>
                                    <th>GN Division</th>
                                    <th>Mobile Number</th>
                                    <th>View More</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $client)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $client->nic }}</td>
                                        <td><span class="badge badge-primary">{{ $client->client_number }}</span></td>
                                        <td>{{ $client->name }}</td>
                                        <td>{{ $client->gender }}</td>
                                        <td>{{ $client->gndivison->name }}</td>
                                        <td>{{ $client->mobile }}</td>
                                        <td> <a href="javascript:void(0);"
                                                class="btn btn-secondary mr-1 text-center view-more"
                                                data-name="{{ @$client->name }}" data-nic="{{ $client->nic }}"
                                                data-client_number="{{ $client->client_number }}"
                                                data-gender="{{ $client->gender }}" data-dob="{{ $client->dob }}"
                                                data-street="{{ $client->street_name }}"
                                                data-province="{{ $client->province->province }}"
                                                data-district="{{ $client->district->district }}"
                                                data-divisionalS="{{ $client->divisionalSecretariat->name }}"
                                                data-email="{{ $client->email }}" data-mobile="{{ $client->mobile }}"
                                                data-tele="{{ $client->tel }}" data-id="{{ $client->id }}"
                                                data-gndivision="{{ @$client->gndivison->name }}" data-toggle="modal"
                                                data-target="#exampleModal">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-start">
                                                <!-- QR Code -->
                                                <a href="javascript:void(0);" class="btn btn-info mr-1 text-center">
                                                    <i class="fas fa-qrcode fa-lg"></i>
                                                </a>

                                                <!-- Print -->
                                                {{--  <a href="{{ route('admin.client-details.print',$client->id) }}" class="btn btn-warning mr-1 text-center">
                                                <i class="fas fa-print fa-lg"></i>
                                            </a> --}}

                                                <a href="{{ route('admin.client.edit', $client->id) }}"
                                                    class="btn btn-success mr-1 text-center">
                                                    <i class="fas fa-edit fa-lg"></i>
                                                </a>

                                                <a href="{{ route('admin.client.destroy', $client->id) }}"
                                                    class="btn btn-danger text-center delete-item">
                                                    <i class="fas fa-trash fa-lg"></i>
                                                </a>
                                            </div>
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

    <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
        <div class="modal-dialog modal-lg" role="document"> <!-- Increased modal width -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Client Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="modal-nic" class="col-form-label font-weight-bold">NIC</label>
                                    <input type="text" class="form-control-plaintext border-bottom" id="modal-nic"
                                        readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="modal-client_number" class="col-form-label font-weight-bold">Client
                                        Number</label>
                                    <input type="text" class="form-control-plaintext border-bottom"
                                        id="modal-client_number" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="modal-name" class="col-form-label font-weight-bold">Name</label>
                                    <input type="text" class="form-control-plaintext border-bottom" id="modal-name"
                                        readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="modal-gender" class="col-form-label font-weight-bold">Gender</label>
                                    <input type="text" class="form-control-plaintext border-bottom" id="modal-gender"
                                        readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="modal-dob" class="col-form-label font-weight-bold">Date of Birth</label>
                                    <input type="text" class="form-control-plaintext border-bottom" id="modal-dob"
                                        readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="modal-street" class="col-form-label font-weight-bold">Street Name</label>
                                    <input type="text" class="form-control-plaintext border-bottom" id="modal-street"
                                        readonly style="width: 100%;">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="modal-province" class="col-form-label font-weight-bold">Province</label>
                                    <input type="text" class="form-control-plaintext border-bottom"
                                        id="modal-province" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="modal-district" class="col-form-label font-weight-bold">District</label>
                                    <input type="text" class="form-control-plaintext border-bottom"
                                        id="modal-district" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="modal-divisionalS" class="col-form-label font-weight-bold">Divisional
                                        Secretariat</label>
                                    <input type="text" class="form-control-plaintext border-bottom"
                                        id="modal-divisionalS" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="modal-gndivision" class="col-form-label font-weight-bold">GN
                                        Division</label>
                                    <input type="text" class="form-control-plaintext border-bottom"
                                        id="modal-gndivision" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="modal-email" class="col-form-label font-weight-bold">Email</label>
                                    <input type="email" class="form-control-plaintext border-bottom" id="modal-email"
                                        readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="modal-mobile" class="col-form-label font-weight-bold">Mobile
                                        Number</label>
                                    <input type="text" class="form-control-plaintext border-bottom" id="modal-mobile"
                                        readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="modal-tele" class="col-form-label font-weight-bold">Telephone</label>
                                    <input type="text" class="form-control-plaintext border-bottom" id="modal-tele"
                                        readonly>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    {{-- <button type="button" class="btn btn-primary">Print</button> --}}
                </div>
            </div>
        </div>
    </div>
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
            $('body').on('click', '.view-more', function() {

                let name = $(this).attr('data-name');
                let nic = $(this).attr('data-nic');
                let clientNumber = $(this).attr('data-client_number');
                let gender = $(this).attr('data-gender');
                let dob = $(this).attr('data-dob');
                let street = $(this).attr('data-street');
                let province = $(this).attr('data-province');
                let district = $(this).attr('data-district');
                let divisionalS = $(this).attr('data-divisionals');
                let email = $(this).attr('data-email');
                let mobile = $(this).attr('data-mobile');
                let tele = $(this).attr('data-tele');
                let id = $(this).attr('data-id');
                let gnDivision = $(this).attr('data-gndivision');

                $('#modal-name').val(name);
                $('#modal-nic').val(nic);
                $('#modal-client_number').val(clientNumber);
                $('#modal-gender').val(gender);
                $('#modal-dob').val(dob);
                $('#modal-street').val(street);
                $('#modal-province').val(province);
                $('#modal-district').val(district);
                $('#modal-divisionalS').val(divisionalS);
                $('#modal-email').val(email);
                $('#modal-mobile').val(mobile);
                if (tele) {
                    $('#modal-tele').val(tele);
                } else {
                    $('#modal-tele').closest('.form-group').hide();
                }
                $('#modal-gndivision').val(gnDivision);

            });
        });
    </script>
@endpush
