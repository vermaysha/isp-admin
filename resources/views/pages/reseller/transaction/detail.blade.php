@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title }}
@endsection

@section('content')
    {{-- TODO: Data masih mengambil dari data master --}}
    <div class="container-lg">
        <div class="row mb-4">
            @if (session('status'))
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Berhasil!</strong> {{ session('status') }}
                        <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
            @if (session('warning'))
                <div class="col-md-12">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Berhasil!</strong> {{ session('warning') }}
                        <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>Detail Tagihan</strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tr>
                                    <th scope="col">Nomor Invoice</th>
                                    <td scope="col">:</td>
                                    <td scope="col">{{ $transaction->invoice_id }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Pembayaran Bulan</th>
                                    <td scope="col">:</td>
                                    <td scope="col">
                                        <span class="badge badge-pills bg-info">
                                            {{ $transaction->created_at->subMonth()->isoFormat('MMMM g') }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col">Tagihan dibuat pada</th>
                                    <td scope="col">:</td>
                                    <td scope="col">{{ $transaction->created_at->isoFormat('dddd, D MMMM g') }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Nama Pelanggan</th>
                                    <td scope="col">:</td>
                                    <td scope="col">
                                        {{ $transaction->client->user->fullname ?? $transaction->client_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Paket</th>
                                    <td scope="col">:</td>
                                    <td scope="col">{{ $transaction->plan->name ?? $transaction->plan_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Jumlah Bayar</th>
                                    <td scope="col">:</td>
                                    <td scope="col">{{ $transaction->grand_total_formated }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Status Tagihan</th>
                                    <td scope="col">:</td>
                                    <td scope="col">
                                        @if (empty($transaction->payed_at) && empty($transaction->accepted_at))
                                            <span class="badge badge-pills bg-danger">Belum dibayar</span>
                                        @elseif ($transaction->payed_at && empty($transaction->accepted_at))
                                            <span class="badge badge-pills bg-warning">Belum dikonfirmasi</span>
                                        @elseif ($transaction->payed_at && $transaction->accepted_at)
                                            <span class="badge badge-pills bg-success">Sudah diselesai</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>Rincian Pembayaran</strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tr>
                                    <th scope="col">Nilai sebelum PPN</th>
                                    <td scope="col">:</td>
                                    <td scope="col">{{ rupiah_format($transaction->amount) }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Nilai PPN</th>
                                    <td scope="col">:</td>
                                    <td scope="col">{{ rupiah_format($transaction->tax) }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Nilai setelah Pajak/Nilai Invoice</th>
                                    <td scope="col">:</td>
                                    <td scope="col" class="fw-bold">
                                        {{ rupiah_format($transaction->grand_total) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('business.billMenu.invoice', ['id' => $transaction->id]) }}"
                            class="btn btn-info text-white btn-sm">Invoice</a>
                        @if ($transaction->payed_at && empty($transaction->accepted_at))
                            <button type="button" class="btn btn-sm btn-primary" data-coreui-toggle="modal"
                                data-coreui-target="#billPhoto">
                                Tampilkan Bukti Bayar
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>Paket</strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tr>
                                    <th scope="col">Nama Paket</th>
                                    <td scope="col">:</td>
                                    <td scope="col">{{ $transaction->plan_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Bandwidth</th>
                                    <td scope="col">:</td>
                                    <td scope="col">
                                        <span class="badge rounded-pill bg-primary">
                                            {{ $transaction->plan_bandwidth }} Mbps
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col">Harga</th>
                                    <td scope="col">:</td>
                                    <td scope="col">{{ rupiah_format($transaction->plan_price) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <strong>Pelanggan</strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tr>
                                        <th scope="col">Nama</th>
                                        <td scope="col">:</td>
                                        <td scope="col">{{ $transaction->client->user->fullname }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Alamat</th>
                                        <td scope="col">:</td>
                                        <td scope="col">{{ $transaction->client->user->address }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Nomor Telepon</th>
                                        <td scope="col">:</td>
                                        <td scope="col">{{ $transaction->client->user->phone_number }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($transaction->payed_at && empty($transaction->accepted_at))
        <div class="modal fade" id="billPhoto" data-coreui-backdrop="static" data-coreui-keyboard="false"
            tabindex="-1" aria-labelledby="billPhotoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="billPhotoLabel">Bukti Pembayaran</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('business.billMenu.confirm', ['id' => $transaction->id]) }}" method="post"
                        enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="col-md-12">
                                <label class="mb-2 d-block">Bukti bayar</label>
                                <img src="{{ asset($transaction->bill_photo ?? 'assets/img/bills/belum-bayar.webp') }}"
                                    alt="{{ $transaction->invoice_id }}" class="img-thumbnail img-fluid mx-auto d-block">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Konfirmasi</button>
                            <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
                        </div>
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
