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
                        @if (session('status'))
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Berhasil!</strong> {{ session('status') }}
                                        <button type="button" class="btn-close" data-coreui-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                            </div>
                        @endif
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
                                                @elseif ($client->user->gender == 'female')
                                                    Wanita
                                                @else
                                                    -
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
                                            <td scope="col"><strong>Alamat jalan/gedung</strong></td>
                                            <td>:</td>
                                            <td>{{ $client->user->address->address_line ?? '-' }}</td>
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
                                <td scope="col"><strong>Status</strong></td>
                                <td>:</td>
                                <td>
                                    @if ($client->status === \App\Enums\ClientStatus::NOT_INSTALLED)
                                        <span class="badge rounded-pill bg-danger">Belum Terpasang</span>
                                    @elseif ($client->status === \App\Enums\ClientStatus::ACTIVED)
                                        <span class="badge rounded-pill bg-info">Terpasang</span>
                                    @elseif ($client->status === \App\Enums\ClientStatus::BLOCKED)
                                        <span class="badge rounded-pill bg-danger">Diblokir</span>
                                    @elseif ($client->status === \App\Enums\ClientStatus::INACTIVE)
                                        <span class="badge rounded-pill bg-warning"> Berhenti Sementara</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td scope="col"><strong>Tanggal Pemasangan</strong></td>
                                <td>:</td>
                                <td>
                                    {{ $client->installed_at ? $client->installed_at->isoFormat('dddd, D MMMM g / HH:MM:ss') . ' WIB' : '-' }}
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
                <div class="card-footer d-flex justify-content-end">
                    <button class="btn btn-primary text-white" data-coreui-toggle="modal"
                        data-coreui-target="#editStatusModal">Ubah Status</button>
                </div>
            </div>

            @hasanyrole([\App\Models\Role::RESELLER_OWNER, \App\Models\Role::RESELLER_ADMIN])
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
            @endhasanyrole
        </div>
    </div>

    <div class="modal fade" id="editStatusModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1"
        aria-labelledby="editStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStatusModalLabel">Ubah Status "{{ $client->user->fullname }}" ?</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('business.clientMenu.updateStatus', ['id' => $client->id]) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="0" @selected($client->status == \App\Enums\ClientStatus::NOT_INSTALLED)>Belum Terpasang</option>
                            <option value="1" @selected($client->status == \App\Enums\ClientStatus::ACTIVED)>Terpasang</option>
                            <option value="2" @selected($client->status == \App\Enums\ClientStatus::BLOCKED)>Diblokir</option>
                            <option value="3" @selected($client->status == \App\Enums\ClientStatus::INACTIVE)>Berhenti Sementara
                            </option>
                        </select>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-success text-white" data-coreui-dismiss="modal">TIDAK</button>
                        <button type="submit" class="btn btn-info text-white">YA</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
