@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Reseller' }}
@endsection

@section('content')
    <div class="container-lg">
        <div class="row g-0">
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Reseller</strong>
                </div>
                <div class="card-body py-4">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="px-3">
                            <input type="text" class="form-control" placeholder="Search ..">
                        </div>
                        <div class="px-3">
                            <a href="{{ route('admin.resellerMenu.create') }}" class="btn btn-primary btn-outline">Tambah
                                Reseller</a>
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
                                    <th scope="col">Nama Reseller</th>
                                    <th scope="col">Nama Pemilik</th>
                                    <th scope="col">Jumlah Pelanggan</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Terdaftar Sejak</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @foreach ($resellers as $reseller)
                                    <tr>
                                        <th>
                                            <a href="{{ route('admin.resellerMenu.detail', ['id' => $reseller->id]) }}">
                                                <img alt="{{ $reseller->name }}"
                                                    src="{{ asset($reseller->photo ?? 'assets/brand/GMDP_100x100.png') }}"
                                                    class="img-thumbnail rounded-circle" style="width: 60px">
                                                <span class="ms-2">{{ $reseller->name }}</span>
                                            </a>
                                        </th>
                                        <td>
                                            <a href="{{ route('admin.userMenu.detail', ['id' => $reseller->user->id]) }}">
                                                {{ $reseller->user->fullname }}
                                            </a>
                                        </td>
                                        <td>
                                            <span
                                                class="badge rounded-pill bg-primary">{{ $reseller->clients_count ?? '0' }}
                                                Pelanggan</span>
                                        </td>
                                        <td>
                                            @if ($reseller->inactive_at)
                                                <span class="badge rounded-pill bg-danger">Non-aktif</span>
                                            @else
                                                <span class="badge rounded-pill bg-success">Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $reseller->created_at->isoFormat('dddd, D MMMM g') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $resellers->links('components.pagination') }}
                </div>
            </div>
        </div>
    </div>
@endsection
