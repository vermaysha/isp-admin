@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Office' }}
@endsection

@section('content')
    <div class="container-lg">
        <div class="row mb-4">
            <div class="col-md-7">
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>Admin</strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle custom-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Nama Pengguna</th>
                                        <th scope="col">Nomor Telepon</th>
                                        <th scope="col">Tanggal Pendaftaran</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    @foreach ($office->reseller->employees as $employee)
                                        <tr>
                                            <th>
                                                <img alt="Logo GMDP"
                                                    src="{{ asset($employee->photo ?? 'assets/brand/GMDP_full.png') }}"
                                                    class="img-thumbnail rounded-circle" style="width: 60px">
                                                <span class="ms-2">{{ '@' . $employee->username }}</span>
                                            </th>
                                            <th scope="col">{{ $employee->phone_number }}</th>
                                            <th scope="col">{{ $employee->created_at->isoFormat('dddd, D MMMM g') }}</th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <strong>Office</strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <div class="text-center">
                                    <img src="{{ mix('assets/brand/GMDP_full.png') }}" style="width: 200px">
                                </div>
                                <table class="table table-hover align-middle custom-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Office</th>
                                            <td scope="col">:</td>
                                            <td scope="col"><strong>{{ $office->name }}</strong></td>
                                        </tr>
                                        <tr>
                                            <th scope="col">Pelanggan</th>
                                            <td scope="col">:</td>
                                            <td scope="col">
                                                <span
                                                    class="badge rounded-pill bg-primary">{{ $office->reseller->clients_count ?? '0' }}
                                                    Pelanggan</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="col">Pelanggan PPN</th>
                                            <td scope="col">:</td>
                                            <td scope="col">
                                                <span class="badge rounded-pill bg-success">{{ $ppnCount ?? '0' }}
                                                    Pelanggan</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="col">Pelanggan Non PPN</th>
                                            <td scope="col">:</td>
                                            <td scope="col">
                                                <span class="badge rounded-pill bg-danger">{{ $nonPpnCount ?? '0' }}
                                                    Pelanggan</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="col">Pelanggan Sudah Bayar</th>
                                            <td scope="col">:</td>
                                            <td scope="col">
                                                <span class="badge rounded-pill bg-success">{{ $paidCustCount ?? '0' }}
                                                    Pelanggan</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="col">Pelanggan Belum Bayar</th>
                                            <td scope="col">:</td>
                                            <td scope="col">
                                                <span
                                                    class="badge rounded-pill bg-danger">{{ $outstandingCustCount ?? '0' }}
                                                    Pelanggan</span>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
