@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Pendaftaran Akun' }}
@endsection

@section('content')
    <div class="container-lg">
        <div class="row g-0">
            <div class="card">
                <div class="card-header">
                    <strong>Reset Password</strong>
                </div>
                <div class="card-body py-4">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="px-3">
                            <input type="text" class="form-control" placeholder="Cari Nama Pengguna ..">
                        </div>
                    </div>
                    <div class="table-responsive px-3">
                        <table class="table table-hover align-middle custom-table">
                            <thead>
                                <tr>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">No. Telp</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
