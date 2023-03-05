@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Tambah Reseller' }}
@endsection

@section('content')
    <div class="container-lg">
        <div class="row g-0 mb-4">
            <div class="card">
                <div class="card-header">
                    <strong>Tambah Reseller</strong>
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
                    <form action="" method="post" class="px-4" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <fieldset class="border row p-3 mb-4 rounded-2">
                            <legend class="float-none w-auto px-4">Informasi Reseller</legend>
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label">Nama Usaha Reseller</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    autocomplete="false" autofocus value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="email">Email Reseller</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="phoneNumber">Nomor Telepon Reseller</label>
                                <input type="text" name="phoneNumber" id="phoneNumber" class="form-control"
                                    value="{{ old('phoneNumber') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="province" class="form-label">Provinsi</label>
                                <select name="province" id="province" class="form-control" required>
                                    <option value="{{ old('province') }}" selected>
                                        {{ old('province_name') }}</option>
                                </select>
                                <input type="hidden" name="province_name" id="province_name" value="">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="city" class="form-label">Kabupaten/Kota</label>
                                <select name="city" id="city" class="form-control" required>
                                    <option value="{{ old('city') }}" selected>
                                        {{ old('city_name') }}</option>
                                </select>
                                <input type="hidden" name="city_name" id="city_name" value="">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="district" class="form-label">Kecamatan</label>
                                <select name="district" id="district" class="form-control" required>
                                    <option value="{{ old('district') }}" selected>
                                        {{ old('district_name') }}</option>
                                </select>
                                <input type="hidden" name="district_name" id="district_name" value="">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="village" class="form-label">Desa/Kelurahan</label>
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
                                <div id='map' style='width: 100%; height: 500px;' data-latitude-id="latitude"
                                    data-longitude-id="longitude"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="latitude" class="form-label">Garis Lintang</label>
                                <input type="text" id="latitude" name="latitude" class="form-control" readonly
                                    placeholder="Garis Lintang (Terisi Otomatis Sesuai Peta)"
                                    value="{{ old('latitude') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="longitude" class="form-label">Garis Bujur</label>
                                <input type="text" id="longitude" name="longitude" class="form-control" readonly
                                    placeholder="Garis Bujur (Terisi Otomatis Sesuai Peta)"
                                    value="{{ old('longitude') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contractRangeDate" class="form-label">Tanggal Kontrak</label>
                                <input type="string" name="contractRangeDate" id="contractRangeDate"
                                    class="form-control" value="{{ old('contractRangeDate') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="npwp" class="form-label">Nomor NPWP</label>
                                <input type="text" name="npwp" id="npwp" class="form-control" required
                                    value="{{ old('npwp') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contract_file" class="form-label">Dokumen Kontrak</label>
                                <input type="file" accept="image/jpeg,image/gif,image/png,application/pdf"
                                    name="contract_file" id="contract_file" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="pks" class="form-label">Nomor PKS</label>
                                <input type="text" name="pks" id="pks" class="form-control" required
                                    value="{{ old('pks') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="logo" class="form-label">Logo</label>
                                <input type="file" name="logo" id="logo" class="form-control"
                                    accept="image/*" onchange="preview(event, 'imgMitra')">
                            </div>
                            <div class="col-md-6 mb-3">
                                <span class="mb-2 d-block">Pratinjau Gambar</span>
                                <img id="imgMitra" src="https://via.placeholder.com/250?text=Pratinjau Gambar"
                                    class="img-fluid img-thumbnail" />
                            </div>
                        </fieldset>
                        <fieldset class="border rounded-2 row p-3">
                            <legend class="float-none w-auto px-4">Informasi Pemilik</legend>
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
                                        value="{{ old('owner_username') }}" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="owner_email" class="form-label">Email Owner</label>
                                <input type="email" name="owner_email" id="owner_email" class="form-control"
                                    value="{{ old('owner_email') }}" autocomplete="off">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="owner_password" class="form-label">Kata Sandi Sistem</label>
                                <input type="password" name="owner_password" id="owner_password" class="form-control"
                                    autocomplete="new-password" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="owner_password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                                <input type="password" name="owner_password_confirmation"
                                    id="owner_password_confirmation" class="form-control" autocomplete="new-password"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="owner_birth" class="form-label">Tanggal Lahir</label>
                                <input type="string" name="owner_birth" id="owner_birth" class="form-control"
                                    value="{{ old('owner_birth') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="owner_gender" class="form-label">Jenis Kelamin</label>
                                <select name="owner_gender" id="owner_gender" class="form-control">
                                    <option value="">--- Pilih Jenis Kelamin ---</option>
                                    <option value="male" @selected(old('owner_gender') == 'male')>Lelaki</option>
                                    <option value="female @selected(old('owner_gender') == 'female')">Wanita</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="owner_province" class="form-label">Provinsi</label>
                                <select name="owner_province" id="owner_province" class="form-control" required>
                                    <option value="{{ old('owner_province') }}" selected>
                                        {{ old('owner_province_name') }}</option>
                                </select>
                                <input type="hidden" name="owner_province_name" id="owner_province_name"
                                    value="">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="owner_city" class="form-label">Kabupaten/Kota</label>
                                <select name="owner_city" id="owner_city" class="form-control" required>
                                    <option value="{{ old('owner_city') }}" selected>
                                        {{ old('owner_city_name') }}</option>
                                </select>
                                <input type="hidden" name="owner_city_name" id="owner_city_name" value="">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="owner_district" class="form-label">Kecamatan</label>
                                <select name="owner_district" id="owner_district" class="form-control" required>
                                    <option value="{{ old('owner_district') }}" selected>
                                        {{ old('owner_district_name') }}</option>
                                </select>
                                <input type="hidden" name="owner_district_name" id="owner_district_name"
                                    value="">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="owner_village" class="form-label">Desa/Kelurahan</label>
                                <select name="owner_village" id="owner_village" class="form-control" required>
                                    <option value="{{ old('owner_village') }}" selected>
                                        {{ old('owner_village_name') }}</option>
                                </select>
                                <input type="hidden" name="owner_village_name" id="owner_village_name" value="">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="owner_address_line" class="form-label">Alamat Jalan/Gedung</label>
                                <textarea name="owner_address_line" id="owner_address_line" class="form-control" rows="5">{{ old('owner_address_line') }}</textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div id='owner_map' style='width: 100%; height: 500px;'></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="owner_latitude" class="form-label">Garis Lintang</label>
                                <input type="text" id="owner_latitude" name="owner_latitude" class="form-control"
                                    readonly placeholder="Garis Lintang (Terisi Otomatis Sesuai Peta)"
                                    value="{{ old('owner_latitude') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="owner_longitude" class="form-label">Garis Bujur</label>
                                <input type="text" id="owner_longitude" name="owner_longitude" class="form-control"
                                    readonly placeholder="Garis Bujur (Terisi Otomatis Sesuai Peta)"
                                    value="{{ old('owner_longitude') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="owner_photo_profile" class="form-label">Foto Profil</label>
                                <input type="file" accept="image/*" name="owner_photo_profile"
                                    id="owner_photo_profile" class="form-control" onchange="preview(event, 'imgOwner')">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="owner_photo_ktp" class="form-label">Foto KTP</label>
                                <input type="file" accept="image/*" name="owner_photo_ktp" id="owner_photo_ktp"
                                    class="form-control" onchange="preview(event, 'imgOwnerKTP')">
                            </div>
                            <div class="col-md-6 mb-3">
                                <span class="mb-2 d-block">Pratinjau Foto Profil</span>
                                <img id="imgOwner" src="https://via.placeholder.com/200?text=Pratinjau Gambar"
                                    class="img-fluid img-thumbnail" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <span class="mb-2 d-block">Pratinjau Foto KTP</span>
                                <img id="imgOwnerKTP" src="https://via.placeholder.com/200?text=Pratinjau Gambar"
                                    class="img-fluid img-thumbnail" />
                            </div>
                        </fieldset>
                        <div class="d-flex justify-content-end my-4">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </div>
                        <input type="hidden" name="village_id" id="village_id" value="{{ old('village_id') }}" />
                        <input type="hidden" name="owner_village_id" id="owner_village_id"
                            value="{{ old('owner_village_id') }}" />
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@php
    $latitude = old('latitude');
    $longitude = old('longitude');
    
    $owner_latitude = old('owner_latitude');
    $owner_longitude = old('owner_longitude');
@endphp

@section('script')
    @include('js.previewImg')
    @include('js.address')
    @include('js.mapbox')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/plugins/monthSelect/index.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>

    <script>
        $('#contractRangeDate').flatpickr({
            mode: 'range',
            altInput: true,
            dateFormat: "Y-m-d",
            altFormat: "j F Y",
        });

        $('#owner_birth').flatpickr({
            altInput: true,
            dateFormat: "Y-m-d",
            altFormat: "j F Y",
        });
    </script>

    <script>
        function provinceOwnerSelect() {
            return $('#owner_province').select2(select2Conf('{{ route('address.provinces') }}', 'Pilih Provinsi'))
                .on('select2:select', (e) => {
                    $('#owner_province_name').val(e.params.data.name)
                    // Reset City, District, Village
                    $('#owner_city').val(null).trigger('change')
                    $('#owner_district').val(null).trigger('change')
                    $('#owner_village').val(null).trigger('change')
                    $('#owner_village_id').val(null)
                })
        }

        function cityOwnerSelect(provinceCode) {
            return $('#owner_city')
                .select2(select2Conf('{{ route('address.cities') }}/' + provinceCode, 'Pilih Kabupaten/Kota'))
                .prop('disabled', false)
                .on('select2:select', (e) => {
                    $('#owner_city_name').val(e.params.data.name)
                })
        }

        function districtOwnerSelect(cityCode) {
            return $('#owner_district')
                .select2(select2Conf('{{ route('address.districts') }}/' + cityCode, 'Pilih Kecamatan'))
                .prop('disabled', false).on('select2:select', (e) => {
                    $('#owner_district_name').val(e.params.data.name)
                })
        }

        function villageOwnerSelect(districtCode) {
            return $('#owner_village')
                .select2(select2Conf('{{ route('address.villages') }}/' + districtCode, 'Pilih Desa/Kelurahan'))
                .prop('disabled', false).on('select2:select', (e) => {
                    $('#owner_village_name').val(e.params.data.name)
                })
        }

        $(document).ready(() => {
            provinceOwnerSelect()
                .on('select2:select', (e) => {
                    // City Select
                    cityOwnerSelect(e.params.data.code)
                        .on('select2:select', (e) => {
                            // District Select
                            districtOwnerSelect(e.params.data.code)
                                .on('select2:select', (e) => {
                                    // Village select
                                    villageOwnerSelect(e.params.data.code)
                                        .on('select2:select', (e) => {
                                            $('#owner_village_id').val(e.params.data.id_original)
                                        })
                                })
                        })

                })

            // Default value when data has been selected
            var provinceCode = $('#owner_province').find(':selected').val()
            cityOwnerSelect(provinceCode)

            var cityCode = $('#owner_city').find(':selected').val()
            districtOwnerSelect(cityCode)

            var districtCode = $('#owner_district').find(':selected').val()
            villageOwnerSelect(districtCode)
        })
    </script>

    <script>
        $(document).ready(() => {
            mapboxgl.accessToken = '{{ config('services.mapbox.token') }}';
            if (!mapboxgl.supported()) {
                alert('Your browser does not support Mapbox GL');
            } else {
                const map = new mapboxgl.Map({
                    container: 'owner_map',
                    style: 'mapbox://styles/mapbox/streets-v11',
                    cooperativeGestures: true,
                    center: {{ Js::from([$owner_longitude ?? 117.8888, $owner_latitude ?? -2.44565]) }},
                    zoom: {{ isset($owner_latitude) && isset($owner_longitude) ? 14 : 4 }}
                });

                const geocoder = new MapboxGeocoder({
                    accessToken: mapboxgl.accessToken,
                    mapboxgl: mapboxgl,
                    country: 'ID',
                    language: 'id',
                    marker: false
                });

                const marker = new mapboxgl.Marker({
                    draggable: true
                })

                @if (isset($owner_latitude) && isset($owner_longitude))
                    marker.setLngLat({{ Js::from([$owner_longitude, $owner_latitude]) }})
                        .addTo(map)
                @endif

                marker.on('dragend', function(e) {
                    var coords = e.target.getLngLat();
                    setLatitudeLongitude(coords['lng'], coords['lat'])
                })

                geocoder.on('result', e => {
                    setLatitudeLongitude(e.result.center[0], e.result.center[1])
                    marker.setLngLat(e.result.center)
                        .addTo(map)
                })

                const geolocate = new mapboxgl.GeolocateControl({
                    positionOptions: {
                        enableHighAccuracy: true
                    },
                    trackUserLocation: false,
                    showUserHeading: false,
                    showUserLocation: false,
                });

                geolocate.on('geolocate', (e) => {
                    setLatitudeLongitude(e.coords.longitude, e.coords.latitude)
                    marker.setLngLat([
                            e.coords.longitude,
                            e.coords.latitude,
                        ])
                        .addTo(map)
                })

                map.addControl(geocoder);
                map.addControl(new mapboxgl.FullscreenControl());
                map.addControl(new mapboxgl.NavigationControl());
                map.addControl(geolocate);

                function setLatitudeLongitude(longitude, latitude) {
                    $('#owner_longitude').val(longitude)
                    $('#owner_latitude').val(latitude)
                }
            }
        })
    </script>
@endsection

@section('stylesheet')
    @include('stylesheet.address')
    @include('stylesheet.mapbox')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">
@endsection
