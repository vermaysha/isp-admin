@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Dasboard' }}
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="https://unpkg.com/@coreui/icons/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@coreui/icons/css/free.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@coreui/icons/css/brand.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@coreui/icons/css/flag.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@coreui/chartjs@3.0.0/dist/css/coreui-chartjs.min.css">
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.1.2/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@coreui/chartjs@3.0.0/dist/js/coreui-chartjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@coreui/utils@1.3.1/dist/coreui-utils.js"></script>
    <script src="js/main.js"></script>
@endsection

@section('content')
    <div class="container-lg">
        <div class="row">
            {{-- col --}}
            <div class="col-sm-6 col-lg-3">
                <div class="card mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="fs-4 fw-semibold">{{ number_format($cpuLoad, 2) }}%</div>
                            <div>CPU Load</div>
                            <div class="progress progress-thin my-2">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ number_format($cpuLoad, 2) }}%"
                                    aria-valuenow="{{ number_format($cpuLoad, 2) }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                            {{-- <small class="text-medium-emphasis-inverse">Widget helper text</small> --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- /col --}}
            {{-- col --}}
            <div class="col-sm-6 col-lg-3">
                <div class="card mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="fs-4 fw-semibold">{{ number_format($memUsed / $memTotal, 2) }}%</div>
                            <div>Memory Usage</div>
                            <div class="progress progress-thin my-2">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ number_format($memUsed / $memTotal, 2) }}%"
                                    aria-valuenow="{{ number_format($memUsed / $memTotal, 2) }}" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                            {{-- <small class="text-medium-emphasis-inverse">Widget helper text</small> --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- /col --}}
            {{-- col --}}
            <div class="col-sm-6 col-lg-3">
                <div class="card mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="fs-4 fw-semibold">{{ number_format($diskUsed / $diskTotal, 2) }}%</div>
                            <div>Disk Usage</div>
                            <div class="progress progress-thin my-2">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ number_format($diskUsed / $diskTotal, 2) }}%"
                                    aria-valuenow="{{ number_format($diskUsed / $diskTotal, 2) }}" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                            {{-- <small class="text-medium-emphasis-inverse">Widget helper text</small> --}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="fs-4 fw-semibold">{{ $upTime }}</div>
                            <div>Server Uptime</div>
                            <div class="progress progress-thin my-2">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            {{-- <small class="text-medium-emphasis-inverse">Widget helper text</small> --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- /col --}}
            {{-- col --}}
            {{-- <div class="col-sm-6 col-lg-3">
                <div class="card mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="fs-4 fw-semibold">{{ number_format($diskUsed/$diskTotal, 2) }}%</div>
                            <div>Connection</div>
                            <div class="progress progress-thin my-2">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ number_format($diskUsed/$diskTotal, 2) }}%" aria-valuenow="{{ number_format($diskUsed/$diskTotal, 2) }}"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            {{-- <small class="text-medium-emphasis-inverse">Widget helper text</small> --}}
            {{-- </div>
                    </div>
                </div>
            </div> --}}
            {{-- /col --}}
        </div>
        <div class="row mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card overflow-hidden">
                    <div class="card-body p-0 d-flex align-items-center">
                        <div class="bg-primary text-white py-4 px-4 me-3">
                            <i class="icon icon-xl cil-people"></i>
                        </div>
                        <div>
                            <div class="fs-6 fw-semibold text-primary">{{ $userTotal }}</div>
                            <div class="text-medium-emphasis text-uppercase fw-semibold small">Akun Pengguna</div>
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
                            <div class="text-medium-emphasis text-uppercase fw-semibold small">Reseller AKTIF</div>
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
                            <div class="text-medium-emphasis text-uppercase fw-semibold small">Pelanggan RESELLER</div>
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
                            <div class="text-medium-emphasis text-uppercase fw-semibold small">RESELLER NONAKTIF</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div>
        <!-- /.row-->
        <div class="row">
            <div class="col-md-12">
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
                                                <div class="fw-semibold text-center">{{ $mitra->user->address }}</div>
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
            <!-- /.col-->
        </div>
        <!-- /.row-->
    </div>
@endsection
