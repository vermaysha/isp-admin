@extends('layouts.pages')

@section('pageTitle')
    {{ $pageTitle ?? 'SignUp' }}
@endsection

@section('content')
    <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card-group d-block d-md-flex row">
                        <div class="card col-md-7 p-4 mb-0">
                            <div class="card-body">
                                <form action="" method="POST">
                                    <h1>Daftar Akun Sistem eBilling GMDP</h1>
                                    <div class="my-4">
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong> </strong>
                                            <button type="button" class="btn-close" data-coreui-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    </div>

                                    <fieldset class="border row p-3 mb-4 rounded-2">
                                        <legend class="float-none w-auto px-4">Informasi Reseller</legend>
                                        <div class="col-md-12 mb-2">
                                            <label class="form-label" for="email">Nama Usaha Reseller</label>
                                            <input type="text" name="name" id="name" class="form-control"
                                                placeholder="PT. Global Media Data Prima" value="">
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <label class="form-label" for="email">Email Reseller</label>
                                            <input type="email" name="email" id="email" class="form-control"
                                                placeholder="info@gmdp.net.id" value="">
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <label class="form-label" for="email">Alamat Reseller</label>
                                            <textarea name="address" id="address" class="form-control"
                                                placeholder="Kawasan Bisnis Terpadu The Park, Office Park, Jl. Ir. Soekarno No.25, Dusun II, Madegondo, Kec. Grogol, Kabupaten Sukoharjo, Jawa Tengah 57552"
                                                rows="3"></textarea>
                                        </div>
                                        <div class="col-md-12 mb-4"> {{-- edit lagi --}}
                                            <label for="owner_photo" class="form-label">Upload Bukti Dokumen
                                                Registrasi</label>
                                            <input type="file" accept="all/*" name="registration" id="registration"
                                                class="form-control" onchange="preview(event, 'imgRegistration')">
                                        </div>
                                    </fieldset>

                                    <fieldset class="border row p-3 mb-4 rounded-2">
                                        <legend class="float-none w-auto px-4">Informasi Owner</legend>
                                        <div class="col-md-12 mb-2">
                                            <label class="form-label" for="email">Nama Owner Reseller</label>
                                            <input type="text" name="owner_name" id="owner_name" class="form-control"
                                                placeholder="Nama Owner" value="">
                                        </div>
                                    </fieldset>

                                    <fieldset class="border row p-3 mb-4 rounded-2">
                                        <legend class="float-none w-auto px-4">Informasi Akun Sistem</legend>
                                        <div class="input-group mb-4">
                                            <span class="input-group-text">
                                                <i class="icon cil cil-user"></i>
                                            </span>
                                            <input class="form-control" type="text" placeholder="Username"
                                                name="username">
                                        </div>
                                        <div class="input-group mb-4">
                                            <span class="input-group-text">
                                                <i class="icon cil cil-lock-locked"></i>
                                            </span>
                                            <input class="form-control" type="password" placeholder="Password"
                                                name="password">
                                        </div>
                                    </fieldset>
                                    <div class="row">
                                        <div class="col-12 d-grid gap-2 mb-2">
                                            <button class="btn btn-info rounded-pill px-4" type="submit">Daftar</button>
                                        </div>
                                    </div>
                                </form>
                                <p class="text-medium-emphasis font-monospace mb-0" style="font-size: 75%">* Pendaftaran
                                    Akun Hanya Untuk Reseller</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
