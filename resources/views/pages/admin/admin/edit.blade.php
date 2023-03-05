@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Edit Admin' }}
@endsection

@section('content')
    <div class="container-lg">
        <div class="row g-0 mb-4">
            <div class="card">
                <div class="card-header">
                    <strong>Edit Admin GMDP</strong>
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
                    <form action="{{ route('admin.adminMenu.update', ['id' => $admin->id]) }}" method="post" class="px-4"
                        autocomplete="off" enctype="multipart/form-data">
                        <input autocomplete="false" name="hidden" type="text" style="display:none;">
                        @csrf
                        <fieldset class="border rounded-2 row p-3">
                            <legend class="float-none w-auto px-4">Informasi Admin</legend>
                            <div class="col-md-12 mb-3">
                                <label for="fullname" class="form-label">Nama Lengkap</label>
                                <input type="text" name="fullname" id="fullname" class="form-control"
                                    value="{{ old('fullname') ?? $admin->user->fullname }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Username Sistem</label>
                                <div class="input-group">
                                    <span class="input-group-text">@</span>
                                    <input type="text" name="username" id="username" class="form-control"
                                        value="{{ old('username') ?? $admin->user->username }}" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Admin</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email') ?? $admin->user->email }}" autocomplete="email">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Kata Sandi Sistem</label>
                                <input type="password" name="password" id="password" class="form-control"
                                    autocomplete="new-password">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" autocomplete="new-password">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="birth" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="birth" id="birth" class="form-control"
                                    value="{{ old('birth') ?? ($admin->user->birth?->format('Y-m-d') ?? '') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="">--- Pilih Jenis Kelamin ---</option>
                                    <option value="male" @selected(old('gender') ?? $admin->user->gender == 'male')>Lelaki</option>
                                    <option value="female @selected(old('gender') ?? $admin->user->gender == 'female')">Wanita</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="province">Provinsi</label>
                                <select name="province" id="province" class="form-control" required>
                                    <option value="{{ old('province') ?? $admin->user->address->province->code }}" selected>
                                        {{ old('province_name') ?? $admin->user->address->province->name }}</option>
                                </select>
                                <input type="hidden" name="province_name" id="province_name"
                                    value="{{ $admin->user->address->province->name }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="city">Kabupaten/Kota</label>
                                <select name="city" id="city" class="form-control" required>
                                    <option value="{{ old('city') ?? $admin->user->address->city->code }}" selected>
                                        {{ old('city_name') ?? $admin->user->address->city->name }}</option>
                                </select>
                                <input type="hidden" name="city_name" id="city_name"
                                    value="{{ $admin->user->address->city->name }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="district" for="district">Kecamatan</label>
                                <select name="district" id="district" class="form-control" required>
                                    <option value="{{ old('district') ?? $admin->user->address->district->code }}"
                                        selected>
                                        {{ old('district_name') ?? $admin->user->address->district->name }}</option>
                                </select>
                                <input type="hidden" name="district_name" id="district_name"
                                    value="{{ $admin->user->address->district->name }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="village">Desa/Kelurahan</label>
                                <select name="village" id="village" class="form-control" required>
                                    <option value="{{ old('village') ?? $admin->user->address->village->code }}" selected>
                                        {{ old('village_name') ?? $admin->user->address->village->name }}</option>
                                </select>
                                <input type="hidden" name="village_name" id="village_name"
                                    value="{{ $admin->user->address->village->name }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="address_line" class="form-label">Alamat Jalan/Gedung</label>
                                <textarea name="address_line" id="address_line" class="form-control" rows="5">{{ old('address_line') ?? $admin->user->address->address_line }}</textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div id='map' style='width: 100%; height: 500px;'></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="latitude">Garis Lintang</label>
                                <input type="text" id="latitude" name="latitude" class="form-control" readonly
                                    placeholder="Garis Lintang (Terisi Otomatis Sesuai Peta)"
                                    value="{{ old('latitude') ?? $admin->user->address->coordinates->latitude }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="longitude">Garis Bujur</label>
                                <input type="text" id="longitude" name="longitude" class="form-control" readonly
                                    placeholder="Garis Bujur (Terisi Otomatis Sesuai Peta)"
                                    value="{{ old('longitude') ?? $admin->user->address->coordinates->longitude }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="photo" class="form-label">Foto</label>
                                <input type="file" accept="image/*" name="photo" id="photo"
                                    class="form-control" onchange="preview(event, 'imgOwner')">
                            </div>
                            <div class="col-md-6 mb-3">
                                <span class="mb-2 d-block">Pratinjau Gambar</span>
                                <img id="imgOwner"
                                    src="{{ $admin->user->photo ? asset($admin->user->photo) : 'https://via.placeholder.com/200?text=Pratinjau Gambar' }}"
                                    class="img-fluid img-thumbnail" />
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="office_location" class="form-label">Lokasi Kantor</label>
                                <select name="office_location" id="office_location" class="form-control">
                                    <option value="">--- Pilih Lokasi Kantor ---</option>
                                    <option value="Tangerang" @selected(old('office_location') ?? $admin->office_location == 'Tangerang')>Tangerang</option>
                                    <option value="Gresik" @selected(old('office_location') ?? $admin->office_location == 'Gresik')>Gresik</option>
                                    <option value="Solo" @selected(old('office_location') ?? $admin->office_location == 'Solo')>Solo</option>
                                </select>
                            </div>
                        </fieldset>
                        <div class="d-flex justify-content-end my-4">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </div>
                        <input type="hidden" name="village_id" id="village_id"
                            value="{{ old('village_id') ?? $admin->user->address->village->id }}" />
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@php
    $latitude = $admin->user->address->coordinates->latitude;
    $longitude = $admin->user->address->coordinates->longitude;
@endphp

@section('script')
    @include('js.previewImg')
    @include('js.address')
    @include('js.mapbox')
@endsection

@section('stylesheet')
    @include('stylesheet.address')
    @include('stylesheet.mapbox')
@endsection
