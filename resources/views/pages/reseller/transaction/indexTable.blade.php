<table class="table table-hover align-middle custom-table">
    <thead class="align-middle">
        <tr>
            <th scope="col">Invoice</th>
            <th scope="col">Pelanggan</th>
            <th scope="col">Paket</th>
            <th scope="col">Nilai</th>
            <th scope="col" class="text-center">Pembayaran Bulan</th>
            <th scope="col" class="text-center">Dibayar Tanggal</th>
            <th scope="col" class="text-center">Dikonfirmasi</th>
        </tr>
    </thead>
    <tbody class="align-middle">
        @foreach ($bills as $bill)
            <tr>
                <th>
                    <a href="{{ route('business.billMenu.detail', ['id' => $bill->id]) }}">
                        {{ $bill->invoice_id }}
                    </a>
                </th>
                <td>
                    <a href="{{ route('business.clientMenu.detail', ['id' => $bill->client_id]) }}">
                        <img alt="{{ $bill->client->user->fullname ?? $bill->client_name }}"
                            src="{{ asset($bill->client->user->photo ?? ($bill->client_name ?? 'assets/brand/GMDP_100x100.png')) }}"
                            class="img-thumbnail rounded-circle" style="width: 60px">
                        <span class="ms-2">{{ $bill->client->user->fullname }}</span>
                    </a>
                </td>
                <td>
                    <a href="{{ route('business.planMenu.detail', ['id' => $bill->plan_id]) }}">
                        {{ $bill->plan_name }}
                    </a>
                </td>
                <td>
                    {{ $transaction->grand_total_formated }}
                </td>
                <td class="text-center">
                    <span
                        class="badge badge-pills bg-info">{{ $bill->created_at->subMonth()->isoFormat('MMMM g') }}</span>
                </td>
                <td>
                    {{ $bill->created_at->isoFormat('dddd, D MMMM g') }}
                </td>
                <td class="text-center">
                    @if ($bill->accepted_at)
                        <span class="badge rounded-pills bg-primary">Ya</span>
                    @else
                        <span class="badge rounded-pills bg-danger">Tidak</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
