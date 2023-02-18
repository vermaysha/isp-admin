@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Tagihan' }}
@endsection

@section('content')
    <div class="container-lg">
        <div class="row g-0">
            <div class="card">
                <div class="card-header">
                    <strong>Tagihan</strong>
                </div>
                <div class="card-body py-4">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="px-3">
                            <input type="text" class="form-control" placeholder="Search ..">
                        </div>
                        <div class="px-3">
                            <p class="btn btn-warning btn-outline rounded-pill"><strong>Terdapat 2 Tagihan</strong></p>
                        </div>
                    </div>
                    <div class="table-responsive px-3">
                        <table class="table table-hover align-middle custom-table">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Bulan</th>
                                    <th scope="col">Paket</th>
                                    <th scope="col">Tagihan</th>
                                    <th scope="col">Kirim Bukti Bayar</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <td>
                                    <div class="">1</div> {{-- edit lagi --}}
                                </td>
                                <td>
                                    <div class="">Januari 2023</div> {{-- edit lagi --}}
                                </td>
                                <td>
                                    <div class="">Paket Small (10Mbps)</div> {{-- edit lagi --}}
                                </td>
                                <td>
                                    <div class="">Rp 200.000</div> {{-- edit lagi --}}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info rounded-pill">
                                        <i class="cil-plus"></i>
                                    </button> {{-- edit lagi --}}
                                </td>
                                <tr>
                                    <td>
                                        <div class="">2</div> {{-- edit lagi --}}
                                    </td>
                                    <td>
                                        <div class="">Februari 2023</div> {{-- edit lagi --}}
                                    </td>
                                    <td>
                                        <div class="">Paket Small (10Mbps)</div> {{-- edit lagi --}}
                                    </td>
                                    <td>
                                        <div class="">Rp 200.000</div> {{-- edit lagi --}}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info rounded-pill">
                                            <i class="cil-plus"></i>
                                        </button> {{-- edit lagi --}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
