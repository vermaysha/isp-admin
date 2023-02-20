@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Admin' }}
@endsection

@section('content')
    <div class="container-lg">
        <div class="row g-0">
            <div class="card">
                <div class="card-header">
                    <strong>ADMIN GMDP</strong>
                </div>
                <div class="card-body py-4">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="px-3">
                            <input type="text" class="form-control" placeholder="Search ..">
                        </div>
                        <div class="px-3">
                            <a href="" class="btn btn-primary btn-outline">Tambah Admin</a>
                        </div>
                    </div>
                    <div class="table-responsive px-3">
                        <table class="table table-hover align-middle custom-table">
                            <thead>
                                <tr>
                                    <th scope="col">Nama Admin</th>
                                    <th scope="col">Kantor</th>
                                    <th scope="col">No. Telp</th>
                                    <th scope="col">Terdaftar Sejak</th>
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
