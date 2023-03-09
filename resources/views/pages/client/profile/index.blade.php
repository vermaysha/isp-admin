@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Profile' }}
@endsection

@section('content')
    <div class="container-lg">
        <div class="row g-0 mb-4">
            <div class="card">
                <div class="card-header">
                    <strong>Profile Pelanggan</strong>
                </div>
                <div class="card-body py-4">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Galat!</strong>
                        <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <form action="" method="post" class="px-4" autocomplete="off" enctype="multipart/form-data">
                        <fieldset class="border row p-3 mb-4 rounded-2">
                            <legend class="float-none w-auto px-4">Data Diri Pelanggan</legend>
                            <div class="col-md-6 mb-3">
                                <label for="fullname" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="fullname" id="fullname" autocomplete="off"
                                    autofocus value="{{ old('fullname') }}" placeholder="Masukan nama lengkap (wajib)">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Nama Pengguna</label>
                                <input type="text" class="form-control" name="username" id="username" autocomplete="off"
                                    autofocus value="{{ old('username') }}" placeholder="Masukan nama pengguna (wajib)"
                                    required readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email" autocomplete="off"
                                    autofocus value="{{ old('email') }}" placeholder="Masukan alamat email (wajib)"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="phone_number">Nomor Telepon</label>
                                <input type="text" name="phone_number" id="phone_number" class="form-control"
                                    value="{{ old('phone_number') }}" placeholder="Masukan nomor telepon (opsional)">
                            </div>
                            {{-- <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Kata Sandi</label>
                                <input type="password" class="form-control" name="password" id="password"
                                    autocomplete="new-password" autofocus value="{{ old('password') }}"
                                    placeholder="Masukan kata sandi (wajib)" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                                <input type="password" class="form-control" name="password_confirmation"
                                    id="password_confirmation" autocomplete="new-password" autofocus
                                    value="{{ old('password_confirmation') }}" placeholder="Konfirmasi kata sandi (wajib)">
                            </div> --}}
                            <div class="col-md-6 mb-3">
                                <label for="birth" class="form-label">Tanggal Lahir</label>
                                <input type="text" name="birth" id="birth" class="form-control"
                                    value="{{ old('birth') }}" placeholder="Masukan Tanggal lahir (opsional)" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select name="gender" id="gender" class="form-control select2">
                                    <option value="">--- Pilih Jenis Kelamin (Opsional) ---</option>
                                    <option value="male" @selected(old('gender') == 'male')>Lelaki</option>
                                    <option value="female @selected(old('gender') == 'female')">Wanita</option>
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
                                <textarea name="address_line" id="address_line" class="form-control" rows="5"
                                    placeholder="Masukan alamat jalan/gedung (opsional)">{{ old('address_line') }}</textarea>
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
                                <label for="photo" class="form-label">Foto Profil</label>
                                <input type="file" accept="image/*" name="photo" id="photo"
                                    class="form-control" onchange="preview(event, 'imgOwner')">
                            </div>
                            <div class="col-md-6 mb-3">
                                <span class="mb-2 d-block">Pratinjau Gambar</span>
                                <img id="imgOwner" src="https://via.placeholder.com/200?text=Pratinjau Gambar"
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
