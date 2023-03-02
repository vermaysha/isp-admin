@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Dasboard' }}
@endsection

@section('content')
    <div class="container-lg">
        <div class="row mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card overflow-hidden">
                    <div class="card-body p-0 d-flex align-items-center">
                        <div class="bg-primary text-white py-4 px-4 me-3">
                            <i class="icon icon-xl cil-user"></i>
                        </div>
                        <div>
                            <div class="fs-6 fw-semibold text-primary">{{ $widget['totalClient'] }}</div>
                            <div class="text-medium-emphasis text-uppercase fw-semibold small">Jumlah Pelanggan</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card overflow-hidden">
                    <div class="card-body p-0 d-flex align-items-center">
                        <div class="bg-danger text-white py-4 px-4 me-3">
                            <i class="icon icon-xl cil-gem"></i>
                        </div>
                        <div>
                            <div class="fs-6 fw-semibold text-danger">{{ $widget['unpayedBill'] }}</div>
                            <div class="text-medium-emphasis text-uppercase fw-semibold small">Tagihan belum dibayar</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card overflow-hidden">
                    <div class="card-body p-0 d-flex align-items-center">
                        <div class="bg-info text-white py-4 px-4 me-3">
                            <i class="icon icon-xl cil-money"></i>
                        </div>
                        <div>
                            <div class="fs-6 fw-semibold text-info">
                                {{ rupiah_format($widget['totalEarning']) }}</div>
                            <div class="text-medium-emphasis text-uppercase fw-semibold small">Penghasilan Bulan
                                {{ now()->setDay(1)->subMonth()->isoFormat('MMMM') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div>
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <canvas id="earningChart" aria-label="Grafik Penghasilan Perbulan" role="img"
                            style="height: 350px">
                            Your browser does not support the canvas element
                        </canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <canvas id="clientChart" aria-label="Grafik Pelanggan" role="img" style="height: 350px">
                            Your browser does not support the canvas element
                        </canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <canvas id="ppnChart" aria-label="Grafik Pelanggan PPN" role="img" style="height: 350px">
                            Your browser does not support the canvas element
                        </canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.0/dist/chart.umd.min.js"></script>
    <script>
        const earningCtx = document.getElementById('earningChart')
        const clientCtx = document.getElementById('clientChart')
        const ppnCtx = document.getElementById('ppnChart')

        new Chart(earningCtx, {
            type: 'line',
            data: {
                labels: {{ Js::from($earning['labels']) }},
                datasets: [{
                    label: 'Penghasilan',
                    data: {{ Js::from($earning['data']) }},
                    borderWidth: 1,
                    fill: false
                }, {
                    label: 'Penghasilan Outstanding',
                    data: {{ Js::from($outstanding['data']) }},
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });

        new Chart(clientCtx, {
            type: 'bar',
            data: {
                labels: {{ Js::from($client['labels']) }},
                datasets: [{
                    label: 'Jumlah Pelanggan',
                    data: {{ Js::from($client['data']) }},
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });

        new Chart(ppnCtx, {
            type: 'doughnut',
            data: {
                labels: [
                    'Pelanggan PPN',
                    'Pelanggan NON-PPN'
                ],
                datasets: [{
                    label: 'Total',
                    data: [{{ $totalPPNusers }}, {{ $totalNonPPNUsers }}],
                    backgroundColor: [
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            },
        });
    </script>
@endsection
