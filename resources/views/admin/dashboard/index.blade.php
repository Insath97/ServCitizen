@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>

        <div class="row">

            @if (canAccess(['Request Index', 'Request Create', 'Request Update', 'Request Delete']))
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Clients</h4>
                            </div>
                            <div class="card-body">
                                {{ $total_clients }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Today Requests</h4>
                            </div>
                            <div class="card-body">
                                {{ $today_request }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Paid Tokens</h4>
                            </div>
                            <div class="card-body">
                                {{ $non_free_tokens }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-circle"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Free Tokens</h4>
                            </div>
                            <div class="card-body">
                                {{ $free_tokens }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif


            @if (canAccess(['Payment Index']))
                {{-- today revenue --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-download"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Today Cash Recieved Tokens</h4>
                            </div>
                            <div class="card-body">
                                {{ $paid_tokens }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- today revenue --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Today Cash Recieved</h4>
                            </div>
                            <div class="card-body">
                                Rs.{{ $today_amount_total }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- total revenue --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-history"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Cash Recieved (This Month)</h4>
                            </div>
                            <div class="card-body">
                                Rs.{{ $todal_amount }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>

        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <canvas id="myChart4"></canvas>
                    </div>
                </div>
            </div>


            <div class="col-12 col-md-6 col-lg-6">
                <div class="card d-flex align-items-center justify-content-center">
                    <div class="card-body text-center">

                        <!-- Button for Payments -->
                        @if (canAccess(['Payment Index']))
                            <a href="{{ route('admin.payment.index') }}" class="btn btn-primary btn-lg w-100 mb-2">
                                <i class="fas fa-plus" style="margin-right: 8px;"></i> Payments
                            </a>
                        @endif

                        <!-- Button for Create Request -->
                        @if (canAccess(['Request Index', 'Request Create', 'Request Update', 'Request Delete']))
                            <a href="{{ route('admin.service-request.create') }}" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-plus" style="margin-right: 8px;"></i> Create Request
                            </a>
                        @endif

                    </div>
                </div>
            </div>

        </div>

    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Use Laravel's json directive to pass PHP data to JavaScript
            var chartData = @json($chartData);

            var chartElement = document.getElementById("myChart4");
            if (chartElement) {
                var ctx = chartElement.getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        datasets: [{
                            data: chartData.counts,
                            backgroundColor: chartData.colors,
                            label: 'Dataset 1'
                        }],
                        labels: chartData.labels,
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'right',
                        },
                    }
                });
            } else {
                console.error('Canvas element with id "myChart4" not found.');
            }
        });
    </script>
@endpush
