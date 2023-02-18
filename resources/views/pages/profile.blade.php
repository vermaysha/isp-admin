@extends('layouts.dashboard')

@section('content')
    <div class="container-lg">
        <div class="row">
            <div class="col-md-5">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                        <strong>My Profile</strong>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <img src="http://localhost/assets/img/avatars/8.jpg" alt="My Profile"
                                class="img-thumbnail rounded-circle mx-auto d-block mb-2">
                            <h3 class="h5">John Doe</h3>
                            <span class="text-muted">(@johndoe)</span>
                        </div>
                        <dl class="row mt-4 text-center">
                            <dt class="col-sm-4">Terdaftar Sejak</dt>
                            <dd class="col-sm-8">Kamis, 20 Januari 2022</dd>

                            <dt class="col-sm-4">Tanggal Lahir</dt>
                            <dd class="col-sm-8">Kamis, 20 Januari 2000</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-coreui-toggle="pill"
                                    data-coreui-target="#pills-home" type="button" role="tab"
                                    aria-controls="pills-home" aria-selected="true">Aktifitas</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-tab" data-coreui-toggle="pill"
                                    data-coreui-target="#pills-profile" type="button" role="tab"
                                    aria-controls="pills-profile" aria-selected="false">Edit Profile</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-contact-tab" data-coreui-toggle="pill"
                                    data-coreui-target="#pills-contact" type="button" role="tab"
                                    aria-controls="pills-contact" aria-selected="false">Riwayat Pembayaran</button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab" tabindex="0">Home</div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                aria-labelledby="pills-profile-tab" tabindex="0">Profile</div>
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                aria-labelledby="pills-contact-tab" tabindex="0">Riwayat Pembayaran</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pageTitle')
    {{ $title ?? 'Profile' }}
@endsection
