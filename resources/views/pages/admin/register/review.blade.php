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
                    <div class="table-responsive px-3">
                        <fieldset class="border row p-3 mb-4 rounded-2">
                            <legend class="float-none w-auto px-4">Informasi Reseller</legend>
                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="email">Nama Usaha Reseller</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="PT. Global Media Data Prima" value="">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="email">Email Reseller</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="admin@gmdp.net.id" value="">
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="form-label" for="email">Alamat Reseller</label>
                                <textarea name="address" id="address" class="form-control"
                                    placeholder="Kawasan Bisnis Terpadu The Park, Office Park, Jl. Ir. Soekarno No.25, Dusun II, Madegondo, Kec. Grogol, Kabupaten Sukoharjo, Jawa Tengah 57552"
                                    rows="3"></textarea>
                            </div>
                        </fieldset>
                        <fieldset class="border row p-3 mb-4 rounded-2">
                            <legend class="float-none w-auto px-4">Informasi Dokumen</legend>
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="register_doc">Dokumen Registrasi Reseller</label>
                                <button type="button" class="btn btn-sm btn-primary" data-coreui-toggle="modal"
                                    data-coreui-target="">
                                    Tampilkan Bukti Dokumen
                                </button>
                            </div>
                        </fieldset>
                        <fieldset class="border row p-3 mb-4 rounded-2">
                            <legend class="float-none w-auto px-4">Informasi Owner</legend>
                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="owner_name">Nama Owner Reseller</label>
                                <input type="text" name="owner_name" id="owner_name" class="form-control"
                                    placeholder="Nama Owner" value="">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="number">No. Telp</label>
                                <input type="number" name="number" id="number" class="form-control"
                                    placeholder="+62812345678" value="">
                            </div>
                        </fieldset>

                        <fieldset class="border row p-3 mb-4 rounded-2">
                            <legend class="float-none w-auto px-4">Informasi Akun Sistem</legend>
                            <div class="input-group mb-4">
                                <span class="input-group-text">
                                    <i class="icon cil cil-user"></i>
                                </span>
                                <input class="form-control" type="text" placeholder="Username" name="username">
                            </div>
                            <div class="input-group mb-4">
                                <span class="input-group-text">
                                    <i class="icon cil cil-lock-locked"></i>
                                </span>
                                <input class="form-control" type="password" placeholder="Password" name="password">
                            </div>
                        </fieldset>
                        <div class="d-flex justify-content-between mb-3">
                            <div class="px-3">
                                <a href="" class="btn btn-danger btn-outline">Tolak Pendaftaran</a>
                            </div>
                            <div class="px-3">
                                <a href="{{ route('admin.registerMenu.register') }}"
                                    class="btn btn-primary btn-outline">Lanjutkan Pendaftaran</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
