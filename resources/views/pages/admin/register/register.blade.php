@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Pendaftaran Reseller' }}
@endsection

@section('content')
    <div class="container-lg">
        <div class="row g-0 mb-4">
            <div class="card">
                <div class="card-header">
                    <strong>Pendaftaran Reseller</strong>
                </div>
                <div class="card-body py-4">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Galat!</strong>
                        <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <form action="" method="post" class="px-4" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <fieldset class="border row p-3 mb-4 rounded-2">
                            <legend class="float-none w-auto px-4">Informasi Reseller</legend>
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label">Nama Usaha Reseller</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    autocomplete="false" autofocus value="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="email">Email Reseller</label>
                                <input type="email" name="email" id="email" class="form-control" value="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="phoneNumber">Nomor Telepon Reseller</label>
                                <input type="text" name="phoneNumber" id="phoneNumber" class="form-control"
                                    value="">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="address" class="form-label">Alamat Lengkap Reseller</label>
                                <textarea name="address" id="address" class="form-control" rows="5"></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contractStartDate" class="form-label">Tanggal Mulai Kontrak</label>
                                <input type="date" name="contractStartDate" id="contractStartDate" class="form-control"
                                    value="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contractEndDate" class="form-label">Tanggal Berakhir Kontrak</label>
                                <input type="date" name="contractEndDate" id="contractEndDate" class="form-control"
                                    value="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="logo" class="form-label">Logo</label>
                                <input type="file" name="logo" id="logo" class="form-control" accept="image/*"
                                    onchange="preview(event, 'imgMitra')">
                            </div>
                            <div class="col-md-6 mb-3">
                                <span class="mb-2 d-block">Pratinjau Gambar</span>
                                <img id="imgMitra" src="https://via.placeholder.com/250?text=Pratinjau Gambar"
                                    class="img-fluid img-thumbnail" />
                            </div>
                        </fieldset>
                        <fieldset class="border rounded-2 row p-3">
                            <legend class="float-none w-auto px-4">Informasi Owner</legend>
                            <div class="col-md-12 mb-3">
                                <label for="owner_fullname" class="form-label">Nama Lengkap</label>
                                <input type="text" name="owner_fullname" id="owner_fullname" class="form-control"
                                    value="{{ old('owner_fullname') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="owner_username" class="form-label">Username Sistem</label>
                                <div class="input-group">
                                    <span class="input-group-text">@</span>
                                    <input type="text" name="owner_username" id="owner_username" class="form-control"
                                        value="{{ old('owner_username') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="owner_email" class="form-label">Email Owner</label>
                                <input type="email" name="owner_email" id="owner_email" class="form-control"
                                    value="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="owner_password" class="form-label">Kata Sandi Sistem</label>
                                <input type="password" name="owner_password" id="owner_password" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="owner_password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                                <input type="password" name="owner_password_confirmation"
                                    id="owner_password_confirmation" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="owner_birth" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="owner_birth" id="owner_birth" class="form-control"
                                    value="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="owner_gender" class="form-label">Jenis Kelamin</label>
                                <select name="owner_gender" id="owner_gender" class="form-control">
                                    <option value="">--- Pilih Jenis Kelamin ---</option>
                                    <option value="male">Lelaki</option>
                                    <option value="female">Wanita</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="owner_address" class="form-label">Alamat Lengkap Owner</label>
                                <textarea name="owner_address" id="owner_address" class="form-control" rows="5"></textarea>
                            </div>
                            <div class="col-md-12 mb-3"> {{-- edit lagi --}}
                                <label for="owner_photo" class="form-label">Dokumen Registrasi</label>
                                <input type="file" accept="all/*" name="owner_photo" id="owner_photo"
                                    class="form-control" onchange="preview(event, 'imgOwner')">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="owner_photo" class="form-label">Foto Reseller</label>
                                <input type="file" accept="image/*" name="owner_photo" id="owner_photo"
                                    class="form-control" onchange="preview(event, 'imgOwner')">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="owner_photo_ktp" class="form-label">Foto KTP</label>
                                <input type="file" accept="image/*" name="owner_photo_ktp" id="owner_photo_ktp"
                                    class="form-control" onchange="preview(event, 'imgOwnerKTP')">
                            </div>
                            <div class="col-md-6 mb-3">
                                <span class="mb-2 d-block">Pratinjau Gambar</span>
                                <img id="imgOwner" src="https://via.placeholder.com/200?text=Pratinjau Gambar"
                                    class="img-fluid img-thumbnail" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <span class="mb-2 d-block">Pratinjau Gambar</span>
                                <img id="imgOwnerKTP" src="https://via.placeholder.com/200?text=Pratinjau Gambar"
                                    class="img-fluid img-thumbnail" />
                            </div>
                        </fieldset>
                        <div class="d-flex justify-content-end my-4">
                            <button class="btn btn-primary" type="submit">Daftarkan Reseller</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
