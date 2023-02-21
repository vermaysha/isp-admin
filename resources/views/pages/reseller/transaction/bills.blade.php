@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Tagihan' }}
@endsection

@section('content')
    <div class="container-lg">
        <div class="row g-0 mb-4">
            <div class="card">
                <div class="card-header">
                    <strong>Tagihan</strong>
                </div>
                <div class="card-body py-4">
                    @if ($bills)
                        <div class="d-flex justify-content-between mb-3">
                            <div class="px-3">
                                <input type="text" class="form-control" placeholder="Search ..">
                            </div>
                        </div>
                        <div class="table-responsive px-3">
                            <table class="table table-hover align-middle custom-table">
                                <thead class="align-middle">
                                    <tr>
                                        <th scope="col">Invoice</th>
                                        <th scope="col">Pelanggan</th>
                                        <th scope="col">Paket</th>
                                        <th scope="col">Nilai</th>
                                        <th scope="col" class="text-center">Pembayaran Bulan</th>
                                    </tr>
                                </thead>
                                <tbody class="align-middle">
                                    @foreach ($bills as $transaction)
                                        <tr>
                                            <th>
                                                <a
                                                    href="{{ route('business.billMenu.detail', ['id' => $transaction->id]) }}">
                                                    {{ $transaction->invoice_id }}
                                                </a>
                                            </th>
                                            <td>
                                                <a
                                                    href="{{ route('business.clientMenu.detail', ['id' => $transaction->client_id]) }}">
                                                    <img alt="{{ $transaction->client->user->fullname ?? $transaction->client_name }}"
                                                        src="{{ asset($transaction->client->user->photo ?? ($transaction->client_name ?? 'assets/brand/GMDP_100x100.png')) }}"
                                                        class="img-thumbnail rounded-circle" style="width: 60px">
                                                    <span class="ms-2">{{ $transaction->client->user->fullname }}</span>
                                                </a>
                                            </td>
                                            <td>
                                                <a
                                                    href="{{ route('business.clientMenu.detail', ['id' => $transaction->plan_id]) }}">
                                                    {{ $transaction->plan_name }}
                                                </a>
                                            </td>
                                            <td>
                                                {{ rupiah_format($transaction->grand_total) }}
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="badge badge-pills bg-info">{{ $transaction->created_at->subMonth()->isoFormat('MMMM g') }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                        {{ $bills->links('components.pagination') }}
                    @else
                        <div class="alert alert-info" role="alert">
                            <h4 class="alert-heading">Tagihan Kosong !</h4>
                            <p class="mb-0">Seluruh pelanggan telah membayar tagihan mereka.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
