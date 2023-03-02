<table class="table table-hover align-middle custom-table">
    <thead>
        <tr>
            <th scope="col">Nama Pelanggan</th>
            <th scope="col">Reseller</th>
            <th scope="col">No.Telp</th>
            <th scope="col">Status PPN</th>
            <th scope="col">Paket </th>
        </tr>
    </thead>
    <tbody class="table-group-divider">
        @foreach ($clients as $client)
            <tr>
                <th>
                    <a href="{{ route('admin.clientMenu.detail', ['id' => $client->id]) }}">
                        <img alt="{{ $client->user->fullname }}"
                            src="{{ asset($client->user->photo ?? 'assets/brand/GMDP_100x100.png') }}"
                            class="img-thumbnail rounded-circle" style="width: 60px">
                        <span class="ms-2">{{ $client->user->fullname }}</span>
                    </a>
                </th>
                <td>
                    <a href="{{ route('admin.resellerMenu.detail', ['id' => $client->reseller->id]) }}">
                        {{ $client->reseller->name }}
                    </a>
                </td>
                <td>
                    {{ $client->user->phone_number }}
                </td>
                <td>
                    @if ($client->is_ppn)
                        <span class="badge rounded-pill bg-primary">Ya</span>
                    @else
                        <span class="badge rounded-pill bg-danger">Tidak</span>
                    @endif
                </td>
                <td>
                    {{ $client->plan->name }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
