@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title }}
@endsection

@section('content')
    <div class="container-lg">
        <div class="row g-0 mb-4">
            <div class="card">
                <div class="card-header">
                    <strong>Informasi Pribadi</strong>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4">
                                <img class="img-thumbnail mx-auto d-block img-fluid"
                                    src="{{ asset($admin->user->photo ?? 'assets/brand/GMDP_100x100.png') }}"
                                    alt="{{ $admin->user->fullname }}" />
                            </div>
                            <div class="col-md-8">
                                <div class="table-responsive px-3">
                                    <table class="table table-hover">
                                        <tr>
                                            <td scope="col"><strong>Nama Lengkap</strong></td>
                                            <td>:</td>
                                            <td>{{ $admin->user->fullname }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="col"><strong>Nama Pengguna</strong></td>
                                            <td>:</td>
                                            <td>{{ '@' . $admin->user->username }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="col"><strong>Alamat Email</strong></td>
                                            <td>:</td>
                                            <td>{{ $admin->user->email ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="col"><strong>Nomor Telepon</strong></td>
                                            <td>:</td>
                                            <td>{{ $admin->user->phone_number ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="col"><strong>Jenis Kelamin</strong></td>
                                            <td>:</td>
                                            <td>
                                                @if ($admin->user->gender == 'male')
                                                    Laki-Laki
                                                @else
                                                    Wanita
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="col"><strong>Tanggal Lahir</strong></td>
                                            <td>:</td>
                                            <td>{{ $admin->user->birth?->isoFormat('dddd, D MMMM g') ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="col"><strong>Alamat</strong></td>
                                            <td>:</td>
                                            <td>{{ $admin->user->address->full_address ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="col"><strong>Tanggal Pendaftaran</strong></td>
                                            <td>:</td>
                                            <td>{{ $admin->user->created_at->isoFormat('dddd, D MMMM g / HH:MM:ss') . ' WIB' ?? '-' }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{ route('admin.adminMenu.edit', ['id' => $admin->id]) }}"
                        class="text-white btn btn-info">Edit</a>
                </div>
            </div>
        </div>
    </div>
@endsection
