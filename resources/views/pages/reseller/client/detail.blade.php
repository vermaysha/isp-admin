@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title }}
@endsection

@section('content')
    <div class="container-lg">
        <div class="row g-0 mb-4">
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Data Diri Pelanggan</strong>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4">
                                <img class="img-thumbnail mx-auto d-block img-fluid"
                                    src="{{ asset($client->user->photo ?? 'assets/brand/GMDP_100x100.png') }}"
                                    alt="{{ $client->user->fullname }}" />
                            </div>
                            <div class="col-md-8">
                                <div class="table-responsive px-3">
                                    <table class="table table-hover">
                                        <tr>
                                            <td scope="col"><strong>Nama Lengkap</strong></td>
                                            <td>:</td>
                                            <td>{{ $client->user->fullname }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="col"><strong>Nama Pengguna</strong></td>
                                            <td>:</td>
                                            <td>{{ '@' . $client->user->username }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="col"><strong>Alamat Email</strong></td>
                                            <td>:</td>
                                            <td>{{ $client->user->email ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="col"><strong>Nomor Telepon</strong></td>
                                            <td>:</td>
                                            <td>{{ $client->user->phone_number ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="col"><strong>Jenis Kelamin</strong></td>
                                            <td>:</td>
                                            <td>
                                                @if ($client->user->gender == 'male')
                                                    Laki-Laki
                                                @else
                                                    Wanita
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="col"><strong>Tanggal Lahir</strong></td>
                                            <td>:</td>
                                            <td>{{ $client->user->birth?->isoFormat('dddd, D MMMM g') ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="col"><strong>Alamat</strong></td>
                                            <td>:</td>
                                            <td>{{ $client->user->address->full_address ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="col"><strong>Tanggal Pendaftaran</strong></td>
                                            <td>:</td>
                                            <td>{{ $client->user->created_at->isoFormat('dddd, D MMMM g / HH:MM:ss') . ' WIB' ?? '-' }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{ route('business.clientMenu.edit', ['id' => $client->id]) }}"
                        class="text-white btn btn-info">Edit</a>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Data Langganan</strong>
                </div>
                <div class="card-body">
                    <div class="table-responsive px-3">
                        <table class="table table-hover">
                            <tr>
                                <td scope="col"><strong>Paket Internet</strong></td>
                                <td>:</td>
                                <td>
                                    <a href="{{ route('business.planMenu.detail', ['id' => $client->plan->id]) }}">
                                        {{ $client->plan->name }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td scope="col"><strong>Termasuk PPN ?</strong></td>
                                <td>:</td>
                                <td>
                                    @if ($client->is_ppn)
                                        <span class="badge badge-pills bg-info">Ya</span>
                                    @else
                                        <span class="badge badge-pills bg-danger">Tidak</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Transaksi Terakhir</strong>
                </div>
                <div class="card-body">
                    <div class="table-responsive px-3">
                        @php
                            $bills = $client->bills;
                            $hideClientCol = true;
                        @endphp
                        @include('pages.reseller.transaction.indexTable')
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{ route('business.billMenu.index', ['client_id' => $client->id]) }}"
                        class="btn btn-info text-white">Selengkapnya</a>
                </div>
            </div>
        </div>
    </div>
@endsection
