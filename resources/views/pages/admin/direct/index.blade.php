@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Paket' }}
@endsection

@section('content')
    <div class="container-lg">
        <div class="row g-0">
            <div class="card">
                <div class="card-header">
                    <strong>Pelanggan Direct</strong>
                </div>
                <div class="card-body py-4">
                    <div class="table-responsive px-3">
                        <table class="table table-hover align-middle custom-table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Kantor</th>
                                    <th scope="col">Admin</th>
                                    <th scope="col">Pelanggan</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <tr>
                                    <th> <img src="{{ mix('assets/brand/GMDP_35x35.png') }}" style="width: 45px"> </th>
                                    <th> <a href="">SOLO</a> </th>
                                    <th>
                                        <span class="badge rounded-pill bg-primary">5 Admin</span>
                                    </th>
                                    <th>
                                        <span class="badge rounded-pill bg-info">700 Pelanggan</span>
                                    </th>
                                </tr>
                                <tr>
                                    <th> <img src="{{ mix('assets/brand/GMDP_35x35.png') }}" style="width: 45px"> </th>
                                    <th> <a href="">TANGGERANG</a> </th>
                                    <th>
                                        <span class="badge rounded-pill bg-primary">5 Admin</span>
                                    </th>
                                    <th>
                                        <span class="badge rounded-pill bg-info">700 Pelanggan</span>
                                    </th>
                                </tr>
                                <tr>
                                    <th> <img src="{{ mix('assets/brand/GMDP_35x35.png') }}" style="width: 45px"> </th>
                                    <th> <a href="">GRESIK</a> </th>
                                    <th>
                                        <span class="badge rounded-pill bg-primary">5 Admin</span>
                                    </th>
                                    <th>
                                        <span class="badge rounded-pill bg-info">700 Pelanggan</span>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
