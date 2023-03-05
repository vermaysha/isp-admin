@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Tambah Admin' }}
@endsection

@section('content')
    <div class="container-lg">
        <div class="row g-0 mb-4">
            <div class="card">
                <div class="card-header">
                    <strong>Tambah Admin GMDP</strong>
                </div>
                <div class="card-body py-4">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Galat!</strong> {{ $error }}
                                <button type="button" class="btn-close" data-coreui-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endforeach
                    @endif
                    <form action="{{ route('admin.adminMenu.store') }}" method="post" class="px-4" autocomplete="off"
                        enctype="multipart/form-data">
                        @csrf
                        <fieldset class="border rounded-2 row p-3">
                            <legend class="float-none w-auto px-4">Informasi Admin</legend>
                            <div class="col-md-12 mb-3">
                                <label for="fullname" class="form-label">Nama Lengkap</label>
                                <input type="text" name="fullname" id="fullname" class="form-control"
                                    value="{{ old('fullname') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Username Sistem</label>
                                <div class="input-group">
                                    <span class="input-group-text">@</span>
                                    <input type="text" name="username" id="username" class="form-control"
                                        value="{{ old('username') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Admin</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Kata Sandi Sistem</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="birth" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="birth" id="birth" class="form-control"
                                    value="{{ old('birth') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="">--- Pilih Jenis Kelamin ---</option>
                                    <option value="male" @selected(old('gender') === 'male')>Lelaki</option>
                                    <option value="female @selected(old('gender') === 'female')">Wanita</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="province">Provinsi</label>
                                <select name="province" id="province" class="form-control" required>
                                    <option value="{{ old('province') }}" selected>
                                        {{ old('province_name') }}</option>
                                </select>
                                <input type="hidden" name="province_name" id="province_name" value="">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="city">Kabupaten/Kota</label>
                                <select name="city" id="city" class="form-control" required>
                                    <option value="{{ old('city') }}" selected>
                                        {{ old('city_name') }}</option>
                                </select>
                                <input type="hidden" name="city_name" id="city_name" value="">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="district" for="district">Kecamatan</label>
                                <select name="district" id="district" class="form-control" required>
                                    <option value="{{ old('district') }}" selected>
                                        {{ old('district_name') }}</option>
                                </select>
                                <input type="hidden" name="district_name" id="district_name" value="">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="village">Desa/Kelurahan</label>
                                <select name="village" id="village" class="form-control" required>
                                    <option value="{{ old('village') }}" selected>
                                        {{ old('village_name') }}</option>
                                </select>
                                <input type="hidden" name="village_name" id="village_name" value="">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="address_line" class="form-label">Alamat Jalan/Gedung</label>
                                <textarea name="address_line" id="address_line" class="form-control" rows="5">{{ old('address_line') }}</textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div id='map' style='width: 100%; height: 500px;'></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="latitude">Garis Lintang</label>
                                <input type="text" id="latitude" name="latitude" class="form-control" readonly
                                    placeholder="Garis Lintang (Terisi Otomatis Sesuai Peta)"
                                    value="{{ old('latitude') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="longitude">Garis Bujur</label>
                                <input type="text" id="longitude" name="longitude" class="form-control" readonly
                                    placeholder="Garis Bujur (Terisi Otomatis Sesuai Peta)"
                                    value="{{ old('longitude') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="photo" class="form-label">Foto</label>
                                <input type="file" accept="image/*" name="photo" id="photo"
                                    class="form-control" onchange="preview(event, 'imgOwner')">
                            </div>
                            <div class="col-md-6 mb-3">
                                <span class="mb-2 d-block">Pratinjau Gambar</span>
                                <img id="imgOwner" src="https://via.placeholder.com/200?text=Pratinjau Gambar"
                                    class="img-fluid img-thumbnail" />
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="office_location" class="form-label">Lokasi Kantor</label>
                                <select name="office_location" id="office_location" class="form-control">
                                    <option value="">--- Pilih Lokasi Kantor ---</option>
                                    <option value="Tangerang">Tangerang</option>
                                    <option value="Gresik">Gresik</option>
                                    <option value="Solo">Solo</option>
                                </select>
                            </div>
                        </fieldset>
                        <div class="d-flex justify-content-end my-4">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </div>
                        <input type="hidden" name="village_id" id="village_id" value="{{ old('village_id') }}" />
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('js.previewImg')
    @include('js.address')
    @include('js.mapbox')
@endsection

@section('stylesheet')
    @include('stylesheet.address')
    @include('stylesheet.mapbox')
@endsection
