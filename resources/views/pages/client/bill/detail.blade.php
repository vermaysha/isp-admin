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
                                    <td scope="col">{{ $bill->invoice_id }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Pembayaran Bulan</th>
                                    <td scope="col">:</td>
                                    <td scope="col">
                                        <span class="badge badge-pills bg-info">
                                            {{ $bill->created_at->subMonth()->isoFormat('MMMM g') }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col">Tagihan dibuat pada</th>
                                    <td scope="col">:</td>
                                    <td scope="col">{{ $bill->created_at->isoFormat('dddd, D MMMM g') }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Paket</th>
                                    <td scope="col">:</td>
                                    <td scope="col">{{ $bill->plan->name ?? $bill->plan_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Jumlah Bayar</th>
                                    <td scope="col">:</td>
                                    <td scope="col">{{ $bill->grand_total_formated }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Status Tagihan</th>
                                    <td scope="col">:</td>
                                    <td scope="col">
                                        @if (empty($bill->payed_at) && empty($bill->accepted_at))
                                            <span class="badge badge-pills bg-danger">Belum dibayar</span>
                                        @elseif ($bill->payed_at && empty($bill->accepted_at))
                                            <span class="badge badge-pills bg-warning">Belum dikonfirmasi</span>
                                        @elseif ($bill->payed_at && $bill->accepted_at)
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
                                    <td scope="col">{{ rupiah_format($bill->amount) }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Nilai PPN</th>
                                    <td scope="col">:</td>
                                    <td scope="col">{{ rupiah_format($bill->tax) }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Nilai setelah Pajak/Nilai Invoice</th>
                                    <td scope="col">:</td>
                                    <td scope="col" class="fw-bold">
                                        {{ rupiah_format($bill->grand_total) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('client.billMenu.invoice', ['id' => $bill->id]) }}"
                            class="btn btn-info text-white btn-sm">Invoice</a>
                        @if (empty($bill->payed_at) && empty($bill->accepted_at))
                            <button type="button" class="btn btn-sm btn-primary" data-coreui-toggle="modal"
                                data-coreui-target="#billPhoto">
                                Unggah Bukti Bayar
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
                                    <td scope="col">{{ $bill->plan_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Bandwidth</th>
                                    <td scope="col">:</td>
                                    <td scope="col">
                                        <span class="badge rounded-pill bg-primary">
                                            {{ $bill->plan_bandwidth }} Mbps
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col">Harga</th>
                                    <td scope="col">:</td>
                                    <td scope="col">{{ rupiah_format($bill->plan_price) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <strong>Reseller</strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tr>
                                        <th scope="col">Nama</th>
                                        <td scope="col">:</td>
                                        <td scope="col">{{ $bill->reseller->name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Alamat</th>
                                        <td scope="col">:</td>
                                        <td scope="col">{{ $bill->reseller->address }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Nomor Telepon</th>
                                        <td scope="col">:</td>
                                        <td scope="col">{{ $bill->reseller->phone_number }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (empty($bill->payed_at) && empty($bill->accepted_at))
        <div class="modal fade" id="billPhoto" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1"
            aria-labelledby="billPhotoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="billPhotoLabel">Unggah Bukti Pembayaran</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('client.billMenu.pay', $bill->id) }}" method="post"
                        enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="col g-0">
                                <div class="col-md-12 mb-3">
                                    <label for="paymentProff" class="form-label">Pilih bukti pembayaran</label>
                                    <input type="file" name="paymentProff" id="paymentProff" class="form-control"
                                        accept="image/*,application/pdf" onchange="preview(event, 'imgProof')">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <span class="mb-2 d-block">Pratinjau Gambar</span>
                                    <img id="imgProof" src="https://via.placeholder.com/500?text=Pratinjau Gambar"
                                        class="img-fluid img-thumbnail" />
                                </div>
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


@section('script')
    @include('js.previewImg')
@endsection
