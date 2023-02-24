@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Pendaftaran Akun' }}
@endsection

@section('content')
    <div class="container-lg">
        <div class="row g-0">
            <div class="card">
                <div class="card-header">
                    <strong>Pendaftaran Akun Sistem Reseller</strong>
                </div>
                <div class="card-body py-4">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="px-3">
                            <input type="text" class="form-control" placeholder="Search ..">
                        </div>
                    </div>
                    <div class="table-responsive px-3">
                        <table class="table table-hover align-middle custom-table">
                            <thead>
                                <tr>
                                    <th scope="col">Reseller</th>
                                    <th scope="col">Nama Owner</th>
                                    <th scope="col">No. Telp</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <tr>
                                    <th> agusnet </th>
                                    <th> agus </th>
                                    <th> +6234721934 </th>
                                    <th> <a href="{{ route('admin.registerMenu.review') }}"
                                            class="btn btn-primary rounded-pill">Review</a> </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
