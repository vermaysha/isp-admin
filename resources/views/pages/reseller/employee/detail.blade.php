@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Paket' }}
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
                                    src="{{ asset($staff->photo ?? 'assets/brand/GMDP_100x100.png') }}"
                                    alt="{{ $staff->fullname }}" />
                            </div>
                            <div class="col-md-8">
                                <div class="table-responsive px-3">
                                    <table class="table table-hover">
                                        <tr>
                                            <td scope="col"><strong>Nama Lengkap</strong></td>
                                            <td>:</td>
                                            <td>{{ $staff->fullname }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="col"><strong>Jabatan</strong></td>
                                            <td>:</td>
                                            <td>
                                                @if ($staff->hasRole(App\Models\Role::RESELLER_OWNER))
                                                    <span class="badge badge-pills bg-primary">Pemilik Usaha</span>
                                                @elseif ($staff->hasRole(App\Models\Role::RESELLER_ADMIN))
                                                    <span class="badge badge-pills bg-info">Admin Usaha</span>
                                                @elseif ($staff->hasRole(App\Models\Role::RESELLER_TECHNICIAN))
                                                    <span class="badge badge-pills bg-warning">Teknisi Usaha</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="col"><strong>Nama Pengguna</strong></td>
                                            <td>:</td>
                                            <td>{{ '@' . $staff->username }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="col"><strong>Alamat Email</strong></td>
                                            <td>:</td>
                                            <td>{{ $staff->email ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="col"><strong>Nomor Telepon</strong></td>
                                            <td>:</td>
                                            <td>{{ $staff->phone_number ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="col"><strong>Jenis Kelamin</strong></td>
                                            <td>:</td>
                                            <td>
                                                @if ($staff->gender == 'female')
                                                    Laki-Laki
                                                @else
                                                    Wanita
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td scope="col"><strong>Tanggal Lahir</strong></td>
                                            <td>:</td>
                                            <td>{{ $staff->birth?->isoFormat('dddd, D MMMM g') ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="col"><strong>Alamat</strong></td>
                                            <td>:</td>
                                            <td>{{ $staff->address ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td scope="col"><strong>Tanggal Pendaftaran</strong></td>
                                            <td>:</td>
                                            <td>{{ $staff->created_at->isoFormat('dddd, D MMMM g / HH:MM:ss') . ' WIB' ?? '-' }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="card-footer d-flex {{ $staff->id !== Auth::id() ? 'justify-content-between' : 'justify-content-end' }}">
                    @if ($staff->id !== Auth::id())
                        <button type="button" class="btn btn-danger text-white" data-coreui-toggle="modal"
                            data-coreui-target="#deleteModal">
                            Hapus Pegawai
                        </button>
                    @endif
                    <a href="{{ route('business.employeeMenu.edit', ['id' => $staff->id]) }}"
                        class="text-white btn btn-info">Edit Pegawai</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="deleteModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1"
        aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Hapus "{{ $staff->fullname }}" ?</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah kamu yakin untuk menghapus data "{{ $staff->fullname }}" ?
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-success text-white" data-coreui-dismiss="modal">TIDAK</button>
                    <a href="{{ route('business.employeeMenu.delete', ['id' => $staff->id]) }}"
                        class="btn btn-danger text-white">YA</a>
                </div>
            </div>
        </div>
    </div>
@endsection
