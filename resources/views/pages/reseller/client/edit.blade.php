@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Tambah Pelanggan' }}
@endsection

@section('content')
    <div class="container-lg">
        <div class="row g-0">
            <div class="card">
                <div class="card-header">
                    <strong>Pelanggan</strong>
                </div>
                <form action="{{ route('business.clientMenu.update', ['id' => $client->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body p-4">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Galat!</strong> {{ $error }}
                                    <button type="button" class="btn-close" data-coreui-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endforeach
                        @endif
                        <fieldset class="border row p-3 mb-4 rounded-2">
                            <legend class="float-none w-auto px-4">Data Diri Pelanggan</legend>
                            <div class="col-md-6 mb-3">
                                <label for="fullname" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="fullname" id="fullname"
                                    autocomplete="false" autofocus value="{{ old('fullname') ?? $client->user->fullname }}"
                                    placeholder="Masukan nama lengkap (wajib)">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Nama Pengguna</label>
                                <input type="text" class="form-control" name="username" id="username"
                                    autocomplete="false" autofocus value="{{ old('username') ?? $client->user->username }}"
                                    placeholder="Masukan nama pengguna (wajib)">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    autocomplete="false" autofocus value="{{ old('email') ?? $client->user->email }}"
                                    placeholder="Masukan alamat email (opsional)">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="phone_number">Nomor Telepon</label>
                                <input type="text" name="phone_number" id="phone_number" class="form-control"
                                    value="{{ old('phone_number') ?? $client->user->phone_number }}"
                                    placeholder="Masukan nomor telepon (opsional)">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="birth" class="form-label">Tanggal Lahir</label>
                                <input type="text" name="birth" id="birth" class="form-control"
                                    value="{{ old('birth') ?? $client->user->birth?->format('Y-m-d') }}"
                                    placeholder="Pilih tanggal lahir (opsional)">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select name="gender" id="gender" class="form-control select2">
                                    <option value="">--- Pilih Jenis Kelamin (Opsional) ---</option>
                                    <option value="male" @selected(old('gender') ?? $client->user->gender == 'male')>Lelaki</option>
                                    <option value="female @selected(old('gender') ?? $client->user->gender == 'female')">Wanita</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="province">Provinsi</label>
                                <select name="province" id="province" class="form-control" required>
                                    <option value="{{ old('province') ?? $client->user->address->province->code }}"
                                        selected>
                                        {{ old('province_name') ?? $client->user->address->province->name }}</option>
                                </select>
                                <input type="hidden" name="province_name" id="province_name"
                                    value="{{ $client->user->address->province->name }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="city">Kabupaten/Kota</label>
                                <select name="city" id="city" class="form-control" required>
                                    <option value="{{ old('city') ?? $client->user->address->city->code }}" selected>
                                        {{ old('city_name') ?? $client->user->address->city->name }}</option>
                                </select>
                                <input type="hidden" name="city_name" id="city_name"
                                    value="{{ $client->user->address->city->name }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="district" for="district">Kecamatan</label>
                                <select name="district" id="district" class="form-control" required>
                                    <option value="{{ old('district') ?? $client->user->address->district->code }}"
                                        selected>
                                        {{ old('district_name') ?? $client->user->address->district->name }}</option>
                                </select>
                                <input type="hidden" name="district_name" id="district_name"
                                    value="{{ $client->user->address->district->name }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="village">Desa/Kelurahan</label>
                                <select name="village" id="village" class="form-control" required>
                                    <option value="{{ old('village') ?? $client->user->address->village->code }}"
                                        selected>
                                        {{ old('village_name') ?? $client->user->address->village->name }}</option>
                                </select>
                                <input type="hidden" name="village_name" id="village_name"
                                    value="{{ $client->user->address->village->name }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="address_line" class="form-label">Alamat Jalan/Gedung</label>
                                <textarea name="address_line" id="address_line" class="form-control" rows="5">{{ old('address_line') ?? $client->user->address->address_line }}</textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div id='map' style='width: 100%; height: 500px;'></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="latitude">Garis Lintang</label>
                                <input type="text" id="latitude" name="latitude" class="form-control" readonly
                                    placeholder="Garis Lintang (Terisi Otomatis Sesuai Peta)"
                                    value="{{ old('latitude') ?? $client->user->address->coordinates->latitude }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="longitude">Garis Bujur</label>
                                <input type="text" id="longitude" name="longitude" class="form-control" readonly
                                    placeholder="Garis Bujur (Terisi Otomatis Sesuai Peta)"
                                    value="{{ old('longitude') ?? $client->user->address->coordinates->longitude }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="photo" class="form-label">Foto</label>
                                <input type="file" accept="image/*" name="photo" id="photo"
                                    class="form-control" onchange="preview(event, 'imgOwner')">
                            </div>
                            <div class="col-md-6 mb-3">
                                <span class="mb-2 d-block">Pratinjau Gambar</span>
                                <img id="imgOwner"
                                    src="{{ asset($client->user->photo) ?? 'https://via.placeholder.com/200?text=Pratinjau Gambar' }}"
                                    class="img-fluid img-thumbnail" />
                            </div>
                        </fieldset>

                        <fieldset class="border row p-3 mb-4 rounded-2">
                            <legend class="float-none w-auto px-4">Data Layanan</legend>
                            <div class="col-md-6 mb-3">
                                <label for="plan" class="form-label">Paket Internet</label>
                                <select name="plan" id="plan" class="form-control">
                                    <option value="">--- Pilih Paket Internet ---</option>
                                    @foreach ($plans as $plan)
                                        <option value="{{ $plan->id }}" @selected(old('plan') ?? $client->plan->id == $plan->id)>
                                            {{ $plan->name }} - {{ $plan->plan }}Mbps</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3"> {{-- todo --}}
                                <label class="mb-2">Apakah User PPN ?</label>
                                <div class="form-check form-switch form-switch-lg">
                                    <input class="form-check-input" type="checkbox" name="is_ppn" id="is_ppn"
                                        @checked(old('is_ppn') ?? $client->is_ppn)>
                                    <label class="form-check-label" for="is_ppn">PPN</label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </div>
                    </div>
                    <input type="hidden" name="village_id" id="village_id"
                        value="{{ old('village_id') ?? $client->user->address->village->id }}" />
                </form>
            </div>
        </div>
    </div>
@endsection

@php
    $latitude = $client->user->address->coordinates->latitude;
    $longitude = $client->user->address->coordinates->longitude;
@endphp

@section('script')
    @include('js.previewImg')
    @include('js.address')
    @include('js.mapbox')

    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>

    <script>
        $('#birth').flatpickr({
            altInput: true,
            dateFormat: "Y-m-d",
            altFormat: "j F Y",
        });
    </script>
@endsection

@section('stylesheet')
    @include('stylesheet.address')
    @include('stylesheet.mapbox')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">
@endsection
