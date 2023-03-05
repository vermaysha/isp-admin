@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Paket' }}
@endsection

@section('content')
    <div class="container-lg">
        <div class="row g-0">
            <div class="card">
                <div class="card-header">
                    <strong>Pelanggan Direct</strong>
                </div>
                <div class="card-body py-4">
                    <div class="table-responsive px-3">
                        <table class="table table-hover align-middle custom-table">
                            <thead>
                                <tr>
                                    <th scope="col">Kantor</th>
                                    <th scope="col">Admin</th>
                                    <th scope="col">Pelanggan</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
