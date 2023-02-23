@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Dasboard' }}
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@coreui/chartjs@3.0.0/dist/css/coreui-chartjs.min.css">
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
        </div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <canvas id="clientChart" aria-label="Grafik Pelanggan" role="img" style="height: 350px">
                        Your browser does not support the canvas element
                    </canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.0/dist/chart.umd.min.js"></script>
    <script>
        const clientCtx = document.getElementById('clientChart')

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
    </script>
@endsection
