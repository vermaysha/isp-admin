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
                            <i class="icon icon-xl cil-people"></i>
                        </div>
                        <div>
                            <div class="fs-6 fw-semibold text-primary">{{ $userTotal }}</div>
                            <div class="text-medium-emphasis text-uppercase fw-semibold small">TOTAL Akun Pengguna</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card overflow-hidden">
                    <div class="card-body p-0 d-flex align-items-center">
                        <div class="bg-primary text-white py-4 px-4 me-3">
                            <i class="icon icon-xl cil-people"></i>
                        </div>
                        <div>
                            <div class="fs-6 fw-semibold text-primary">{{ $mitraTotal }}</div>
                            <div class="text-medium-emphasis text-uppercase fw-semibold small">TOTAL Reseller AKTIF</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card overflow-hidden">
                    <div class="card-body p-0 d-flex align-items-center">
                        <div class="bg-primary text-white py-4 px-4 me-3">
                            <i class="icon icon-xl cil-people"></i>
                        </div>
                        <div>
                            <div class="fs-6 fw-semibold text-primary">{{ $clientTotal }}</div>
                            <div class="text-medium-emphasis text-uppercase fw-semibold small">TOTAL Pelanggan RESELLER
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card overflow-hidden">
                    <div class="card-body p-0 d-flex align-items-center">
                        <div class="bg-primary text-white py-4 px-4 me-3">
                            <i class="icon icon-xl cil-people"></i>
                        </div>
                        <div>
                            <div class="fs-6 fw-semibold text-primary">{{ $mitraNonaktif }}</div>
                            <div class="text-medium-emphasis text-uppercase fw-semibold small">TOTAL RESELLER NONAKTIF</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div>
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <canvas id="clientChart" aria-label="Grafik Total Pelanggan" role="img" style="height: 350px">
                            Your browser does not support the canvas element
                        </canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <canvas id="resellerChart" aria-label="Grafik Total Reseller" role="img" style="height: 350px">
                            Your browser does not support the canvas element
                        </canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row-->
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header text-center fw-semibold">Mitra Dengan Pelanggan Terbanyak</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table border mb-0">
                                <thead class="table-light fw-semibold">
                                    <tr class="align-middle">
                                        <th class="text-center">
                                            <i class="icon cil-people"></i>
                                        </th>
                                        <th class="text-center">Nama Mitra</th>
                                        <th class="text-center">Alamat</th>
                                        <th class="text-center">Jumlah Pelanggan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mitras as $mitra)
                                        <tr>
                                            <td class="text-center">
                                                <div class="avatar avatar-md">
                                                    <img alt="{{ $mitra->user->fullname }}"
                                                        src="{{ asset($mitra->user->photo ?? 'assets/brand/GMDP_100x100.png') }}"
                                                        class="avatar-img">
                                            </td>
                                            <td>
                                                <div class="fw-semibold text-center">{{ $mitra->user->fullname }}</div>
                                                <div class="small text-medium-emphasis text-center">Aktif sejak
                                                    {{ $mitra->created_at->isoFormat('dddd, D MMMM g') }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-semibold text-center">
                                                    {{ $mitra->user->address->full_address }}</div>
                                                <div class="small text-medium-emphasis text-center">
                                                    {{ $mitra->user->phone_number }}</div>
                                            </td>
                                            <td>
                                                <div class="fw-bold text-center">{{ $mitra->clients_count }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <canvas id="ppnChart" aria-label="Grafik Total Reseller" role="img">
                            Your browser does not support the canvas element
                        </canvas>
                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div>
        <!-- /.row-->
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.0/dist/chart.umd.min.js"></script>
    <script>
        const clientCtx = document.getElementById('clientChart')
        const resellerChart = document.getElementById('resellerChart')
        const ppnCtx = document.getElementById('ppnChart')

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

        new Chart(resellerChart, {
            type: 'bar',
            data: {
                labels: {{ Js::from($reseller['labels']) }},
                datasets: [{
                    label: 'Jumlah Reseller',
                    data: {{ Js::from($reseller['data']) }},
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
