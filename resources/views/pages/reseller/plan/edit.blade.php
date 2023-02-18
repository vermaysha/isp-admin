@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Ubah Paket' }}
@endsection

@section('content')
    <div class="container-lg">
        <div class="row g-0 mb-4">
            <div class="card">
                <div class="card-header">
                    <strong>Tambah Paket Internet</strong>
                </div>
                <form action="{{ route('business.planMenu.update', ['id' => $plan->id]) }}" method="post">
                    @csrf
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
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label">Nama Paket Internet</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    autocomplete="false" autofocus value="{{ old('name') ?? $plan->name }}"
                                    placeholder="Masukan nama paket internet (wajib)">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="bandwidth" class="form-label">Bandwidth Paket Internet</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="formatedBandwidth"
                                        id="formatedBandwidth" autocomplete="false" autofocus
                                        value="{{ old('formatedBandwidth') ?? number_format($plan->bandwidth, 0, '', '.') }}"
                                        placeholder="Masukan bandwidth paket internet (wajib)"
                                        onkeyup="updateTextView('formatedBandwidth', 'bandwidth')">
                                    <span class="input-group-text">Mbps</span>
                                    <input type="hidden" name="bandwidth" id="bandwidth"
                                        value="{{ old('bandwidth') ?? $plan->bandwidth }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Harga Paket Internet</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="string" class="form-control" name="formatedPrice" id="formatedPrice"
                                        autocomplete="false" autofocus
                                        value="{{ old('formatedPrice') ?? number_format($plan->price, 0, '', '.') }}"
                                        placeholder="Masukan harga paket internet (wajib)"
                                        onkeyup="updateTextView('formatedPrice', 'price')">
                                    <input type="hidden" name="price" id="price"
                                        value="{{ old('price') ?? $plan->price }}">
                                    <span class="input-group-text">,00</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pajak</label>
                                <br>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" @checked($plan->tax_type === App\Models\Plan::TAX_INCLUDED)
                                            name="tax_type" value="{{ App\Models\Plan::TAX_INCLUDED }}">
                                        Sudah termasuk
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" @checked($plan->tax_type === App\Models\Plan::TAX_EXCLUDED)
                                            name="tax_type" value="{{ App\Models\Plan::TAX_EXCLUDED }}">
                                        Belum termasuk
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Langganan</label>
                                <br>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" checked name="subscription"
                                            value="{{ App\Models\Plan::SUBSCRIPTION_POSTPAID }}">
                                        Pascabayar
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="subscription" disabled
                                            value="{{ App\Models\Plan::SUBSCRIPTION_POSTPAID }}">
                                        Prabayar
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Deskripsi Paket Internet</label>
                                <textarea name="description" id="description" cols="30" rows="5" class="form-control"
                                    placeholder="Masukan detail paket internet (Opsional)">{{ old('description') ?? $plan->description }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('business.planMenu.detail', ['id' => $plan->id]) }}"
                                class="btn btn-danger text-white">Batalkan perubahan</a>
                            <button class="btn btn-primary text-white" type="submit">Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('js.priceFormat')
@endsection
