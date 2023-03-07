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
                                        <th scope="col">#</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Nomor Telepon</th>
                                        <th scope="col">Tanggal Pendaftaran</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    <tr>
                                        <th> <img src="{{ mix('assets/brand/GMDP_full.png') }}" style="width: 45px"> </th>
                                        <th scope="col">Agus</th>
                                        <th scope="col">+6288</th>
                                        <th scope="col">1 Januari 2023</th>
                                    </tr>
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
                                <center><img src="{{ mix('assets/brand/GMDP_full.png') }}" style="width: 200px"></center>
                                <table class="table table-hover align-middle custom-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Office</th>
                                            <td scope="col">:</td>
                                            <td scope="col"><strong> GMDP SOLO </strong></td>
                                        </tr>
                                        <tr>
                                            <th scope="col">Pelanggan</th>
                                            <td scope="col">:</td>
                                            <td scope="col">
                                                <span class="badge rounded-pill bg-primary">5 Pelanggan</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="col">Pelanggan PPN</th>
                                            <td scope="col">:</td>
                                            <td scope="col">
                                                <span class="badge rounded-pill bg-success">5 Pelanggan</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="col">Pelanggan Non PPN</th>
                                            <td scope="col">:</td>
                                            <td scope="col">
                                                <span class="badge rounded-pill bg-danger">5 Pelanggan</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="col">Pelanggan Sudah Bayar</th>
                                            <td scope="col">:</td>
                                            <td scope="col">
                                                <span class="badge rounded-pill bg-success">5 Pelanggan</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="col">Pelanggan Belum Bayar</th>
                                            <td scope="col">:</td>
                                            <td scope="col">
                                                <span class="badge rounded-pill bg-danger">5 Pelanggan</span>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                        <tr>
                                            <th scope="col">Username </th>
                                            <td scope="col">:</td>
                                            <td scope="col"> gmdp_solo</td>
                                        </tr>
                                        <tr>
                                            <th scope="col">Password </th>
                                            <td scope="col">:</td>
                                            <td scope="col"> gmdp_solo</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
