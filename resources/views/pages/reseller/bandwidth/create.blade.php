@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Paket' }}
@endsection

@section('content')
    <div class="container-lg">
        <div class="row g-0 mb-4">
            <div class="card">
                <div class="card-header">
                    <strong>Tambah Paket Internet</strong>
                </div>
                <form action="{{ route('reseller_owner.bandwidth.store') }}" method="post">
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
                                    autocomplete="false" autofocus value="{{ old('name') }}"
                                    placeholder="Masukan nama paket internet (wajib)">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="bandwidth" class="form-label">Bandwidth Paket Internet</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="formatedBandwidth" id="formatedBandwidth"
                                        autocomplete="false" autofocus value="{{ old('formatedBandwidth') }}"
                                        placeholder="Masukan bandwidth paket internet (wajib)" onkeyup="updateTextView('formatedBandwidth', 'bandwidth')">
                                    <span class="input-group-text">Mbps</span>
                                    <input type="hidden" name="bandwidth" id="bandwidth" value="{{ old('bandwidth') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Harga Paket Internet</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="string" class="form-control" name="formatedPrice" id="formatedPrice"
                                        autocomplete="false" autofocus value="{{ old('formatedPrice') }}"
                                        placeholder="Masukan harga paket internet (wajib)" onkeyup="updateTextView('formatedPrice', 'price')">
                                    <input type="hidden" name="price" id="price" value="{{ old('price') }}">
                                    <span class="input-group-text">,00</span>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Deskripsi Paket Internet</label>
                                <textarea name="description" id="description" cols="30" rows="5" class="form-control"
                                    placeholder="Masukan detail paket internet (Opsional)">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        /**
         * @param {string} HTML ID
         */
        function updateTextView(formatedId, realId) {
            const formated = document.getElementById(formatedId)
            const real = document.getElementById(realId)

            formated.value = formatNumber(formated.value)
            real.value = getNumber(formated.value)
        }

        function formatNumber(n) {
            // format number 1000000 to 1,234,567
            return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        }

        function getNumber(_str) {
            var arr = _str.split('');
            var out = new Array();
            for (var cnt = 0; cnt < arr.length; cnt++) {
                if (isNaN(arr[cnt]) == false) {
                    out.push(arr[cnt]);
                }
            }
            return Number(out.join(''));
        }
    </script>
@endsection
