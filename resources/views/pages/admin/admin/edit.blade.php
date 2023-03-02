@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Edit Admin' }}
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
                    <form action="{{ route('admin.adminMenu.update', ['id' => $admin->id]) }}" method="post" class="px-4"
                        autocomplete="off" enctype="multipart/form-data">
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
                                        value="{{ old('username') ?? $admin->user->username }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Admin</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email') ?? $admin->user->email }}">
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
                            <div class="col-md-12 mb-3">
                                <label for="address" class="form-label">Alamat Lengkap</label>
                                <textarea name="address" id="address" class="form-control" rows="5">{{ old('address') ?? $admin->user->address }}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="photo" class="form-label">Foto</label>
                                <input type="file" accept="image/*" name="photo" id="photo" class="form-control"
                                    onchange="preview(event, 'imgOwner')">
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
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('js.previewImg')
@endsection
