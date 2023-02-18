@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title }}
@endsection

@section('content')
    <div class="container-lg">
        <div class="row g-0">
            <div class="card">
                <div class="card-header">
                    <strong>Informasi Reseller</strong>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4">
                                <img class="img-thumbnail mx-auto d-block img-fluid"
                                    src="{{ asset($owner->photo ?? 'assets/brand/GMDP_100x100.png') }}"
                                    alt="{{ $owner->fullname }}" />
                            </div>
                            <div class="col-md-8">
                                <table class="table table-hover">
                                    <tr>
                                        <td>Nama lengkap</td>
                                        <td>{{ $owner->fullname ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>{{ $owner->email ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nama Pengguna</td>
                                        <td>{{ '@' . $owner->username ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>{{ $owner->address ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>NIK</td>
                                        <td>{{ $owner->nik ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Telepon</td>
                                        <td>{{ $owner->phone_number ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Lahir</td>
                                        <td>{{ $owner->birth ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Kelamin</td>
                                        <td>
                                            @if ($owner->gender === 'male')
                                                Laki-laki
                                            @elseif ($owner->gender === 'female')
                                                Wanita
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jabatan</td>
                                        <td>
                                            @if ($owner->hasRole(\App\Models\Role::ADMIN))
                                                <span class="badge badge-rounded bg-primary">Admin Sistem</span>
                                            @elseif ($owner->hasRole(\App\Models\Role::RESELLER_OWNER))
                                                <span class="badge badge-rounded bg-primary">Pemilik Instansi</span>
                                            @elseif ($owner->hasRole(\App\Models\Role::RESELLER_TECHNICIAN))
                                                <span class="badge badge-rounded bg-primary">Teknisi Reseller</span>
                                            @elseif ($owner->hasRole(\App\Models\Role::RESELLER_ADMIN))
                                                <span class="badge badge-rounded bg-primary">Admin Reseller</span>
                                            @elseif ($owner->hasRole(\App\Models\Role::CLIENT))
                                                <span class="badge badge-rounded bg-primary">Klien</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Aktivitas terakhir</td>
                                        <td>
                                            {{ $owner->sessions[0]->last_activity ?? '-' }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
