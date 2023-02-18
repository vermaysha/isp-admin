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
                            <i class="icon icon-xl cil-basket"></i>
                        </div>
                        <div>
                            <div class="fs-6 fw-semibold text-primary">{{ $client->plan->name }}</div>
                            <div class="text-medium-emphasis text-uppercase fw-semibold small">Paket</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card overflow-hidden">
                    <div class="card-body p-0 d-flex align-items-center">
                        <div class="{{ $bill ? 'bg-warning' : 'bg-success' }} text-white py-4 px-4 me-3">
                            <i class="icon icon-xl cil-chart-line"></i>
                        </div>
                        <div>
                            <div class="fs-6 fw-semibold {{ $bill ? 'text-warning' : 'text-success' }}">
                                {{ $bill->grand_total_formated ?? 'Lunas' }}</div>
                            <div class="text-medium-emphasis text-uppercase fw-semibold small">Tagihan Bulan
                                {{ $bill?->payment_month?->isoFormat('MMMM') ??now()->setDay(1)->subMonth()->isoFormat('MMMM') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card overflow-hidden">
                    <div class="card-body p-0 d-flex align-items-center">
                        <div class="bg-primary text-white py-4 px-4 me-3">
                            <i class="icon icon-xl cil-graph"></i>
                        </div>
                        <div>
                            <div class="fs-6 fw-semibold text-primary">{{ $client->reseller->name }}</div>
                            <div class="text-medium-emphasis text-uppercase fw-semibold small">RESELLER</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card overflow-hidden">
                    <div class="card-body p-0 d-flex align-items-center">
                        <div class="bg-primary text-white py-4 px-4 me-3">
                            <i class="icon icon-xl cil-calendar"></i>
                        </div>
                        <div>
                            <div class="fs-6 fw-semibold text-primary">{{ $client->created_at->isoFormat('MMMM g') }}</div>
                            <div class="text-medium-emphasis text-uppercase fw-semibold small">Terdaftar Sejak</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div>
        <!-- /.row-->
        {{-- <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header text-center fw-semibold">Daftar Transaksi</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table border mb-0">
                                <thead class="table-light fw-semibold">
                                    <tr class="align-middle">
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Nomor invoice</th>
                                        <th class="text-center">Paket</th>
                                        <th class="text-center">Tagihan</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Status Konfirmasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="align-middle">
                                        <td>
                                            <div class="fw-semibold text-center">1</div>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-center">INV/000</div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-center">Paket Small (10Mb)</div>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-center" >Rp 200.000</div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-center" >Senin, 02 januari 2023</div>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-center" >Dikonfirmasi</div>
                                        </td>
                                    </tr>
                                    <tr class="align-middle">
                                        <td>
                                            <div class="fw-semibold text-center">2</div>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-center">INV/001</div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-center">Paket Small (10Mb)</div>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-center" >Rp 200.000</div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-center" >Rabu, 02 Februari 2023</div>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-center" >Dikonfirmasi</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div> --}}
        <!-- /.row-->
    </div>
@endsection
