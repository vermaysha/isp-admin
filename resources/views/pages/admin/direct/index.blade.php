@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Kantor' }}
@endsection

@section('content')
    <div class="container-lg">
        <div class="row g-0">
            <div class="card">
                <div class="card-header">
                    <strong>Kantor</strong>
                </div>
                <div class="card-body py-4">
                    <div class="table-responsive px-3">
                        <table class="table table-hover align-middle custom-table">
                            <thead>
                                <tr>
                                    <th scope="col">Kantor</th>
                                    <th scope="col">Akun Pemilik</th>
                                    <th scope="col">Pelanggan</th>
                                    <th scope="col">Kota</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @foreach ($offices as $office)
                                    <tr>
                                        <th>
                                            <a href="{{ route('admin.officeMenu.detail', ['id' => $office->id]) }}">
                                                <img alt="Logo GMDP" src="{{ mix('assets/brand/GMDP_full.png') }}"
                                                    class="img-thumbnail rounded-circle" style="width: 60px">
                                                <span class="ms-2">{{ $office->name }}</span>
                                            </a>
                                        </th>
                                        <th>
                                            @foreach ($office->reseller->employees as $employee)
                                                @if ($employee->hasRole('Reseller_Owner'))
                                                    <a
                                                        href="{{ route('admin.userMenu.detail', ['id' => $employee->id]) }}">{{ $employee->fullname }}</a>
                                                @else
                                                    -
                                                @endif
                                            @endforeach
                                        </th>
                                        <th>
                                            <span
                                                class="badge rounded-pill bg-info">{{ $office->reseller->clients_count ?? '0' }}
                                                Pelanggan</span>
                                        </th>
                                        <th>
                                            {{ $office->address->city->name }}
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
