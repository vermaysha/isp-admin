@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Paket' }}
@endsection

@section('content')
    <div class="container-lg">
        <div class="row g-0 mb-4">
            <div class="card">
                <div class="card-header">
                    <strong>Paket Internet</strong>
                </div>
                <div class="card-body py-4">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="px-3">
                            <input type="text" class="form-control" placeholder="Search ..">
                        </div>
                        <div class="px-3">
                            <a href="{{ route('reseller_owner.bandwidth.create') }}"
                                class="btn btn-primary btn-outline">Tambah Paket</a>
                        </div>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Berhasil!</strong> {{ session('status') }}
                            <button type="button" class="btn-close" data-coreui-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="table-responsive px-3">
                        <table class="table table-hover align-middle custom-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th scope="col">Nama Paket</th>
                                    <th scope="col">Bandwidth</th>
                                    <th scope="col">Harga</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @foreach ($bandwidths as $bandwidth)
                                    <tr>
                                        <th scope="col">{{ $loop->iteration }}</th>
                                        <td scope="col">
                                            <a
                                                href="{{ route('reseller_owner.bandwidth.detail', ['id' => $bandwidth->id]) }}">{{ $bandwidth->name }}</a>
                                        </td>
                                        <td scope="col">{{ $bandwidth->bandwidth }} Mbps</td>
                                        <td scope="col">Rp{{ number_format($bandwidth->price, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $bandwidths->links('components.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
