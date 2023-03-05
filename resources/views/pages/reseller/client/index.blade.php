@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Pelanggan' }}
@endsection

@section('content')
    <div class="container-lg">
        <div class="row g-0">
            <div class="card">
                <div class="card-header">
                    <strong>Pelanggan</strong>
                </div>
                <div class="card-body py-4">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="px-3">
                            <a href=""> </a>
                        </div>
                        <div class="px-3">
                            <a href="{{ route('business.clientMenu.create') }}" class="btn btn-primary btn-outline">Tambah
                                Pelanggan</a>
                        </div>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Berhasil!</strong> {{ session('status') }}
                            <button type="button" class="btn-close" data-coreui-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="table-responsive p-2">
                        <table class="table table-hover align-middle custom-table" id="clientTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">#</th>
                                    <th scope="col">Nama Pelanggan</th>
                                    <th scope="col">Paket</th>
                                    <th scope="col">No.Telp</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">PPN</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                            </tbody>
                        </table>
                        {{-- <table class="table table-hover align-middle custom-table">
                            <thead>
                                <tr>
                                    <th scope="col">Nama Pelanggan</th>
                                    <th scope="col">Paket</th>
                                    <th scope="col">No.Telp</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">PPN</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @foreach ($clients as $client)

                                <tr>
                                    <th>
                                        <a href="{{ route('business.clientMenu.detail', ['id' => $client->id]) }}">
                                            <img alt="{{ $client->user->fullname }}" src="{{ asset($client->user->photo ?? 'assets/brand/GMDP_100x100.png') }}" class="img-thumbnail rounded-circle" style="width: 60px">
                                            <span class="ms-2">{{ $client->user->fullname }}</span>
                                        </a>
                                    </th>
                                    <td>
                                        <a href="{{ route('business.planMenu.detail', ['id' => $client->plan->id]) }}">
                                            {{ $client->plan->name }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $client->user->phone_number }}
                                    </td>
                                    <td>
                                        {{ $client->user->address->full_address }}
                                    </td>
                                    <td class="text-center">
                                        @if ($client->is_ppn)
                                        <span class="badge rounded-pill bg-primary">Ya</span>
                                        @else
                                        <span class="badge rounded-pill bg-danger">Tidak</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $clients->links('components.pagination') }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            const table = $('#clientTable').DataTable({
                serverSide: true,
                processing: true,
                ajax: '',
                info: true,
                language: {
                    url: '{{ asset('/js/datatable-id.json') }}',
                },
                order: [
                    [0, 'desc']
                ],
                stateSave: true,
                pagingType: 'simple_numbers',
                columns: [{
                        data: 'id',
                        name: 'id',
                        searchable: false,
                        orderable: true,
                        className: 'dt-center',
                    },
                    {
                        data: 'user',
                        name: 'user.fullname',
                        searchable: true,
                        orderable: true,
                        className: 'align-middle',
                        render: (data, type, row, meta) => {
                            const photoUrl = row.user.photo ?? 'assets/brand/GMDP_100x100.png'
                            return `<a href="{{ route('business.clientMenu.detail') }}/${row.id}">
                                <img alt="${row.user.fullname}"
                                    src="{{ asset('') }}${photoUrl}"
                                    class="img-thumbnail rounded-circle" style="width: 60px">
                                <span class="ms-2">${row.user.fullname}</span>
                            </a>`;
                        }
                    },
                    {
                        data: 'plan',
                        name: 'plan.name',
                        searchable: true,
                        orderable: true,
                        render: (data, type, row, meta) => {
                            return `<a href="{{ route('business.planMenu.detail') }}/${row.plan_id}">
                                ${row.plan.name}
                            </a>`;
                        }
                    },
                    {
                        data: 'user.phone_number',
                        name: 'user.phone_number',
                        className: 'text-left',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'user.address',
                        name: 'user.address',
                        className: 'text-left',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'is_ppn',
                        name: 'is_ppn',
                        className: 'text-center',
                        searchable: false,
                        orderable: true,
                        render: (data, type, row, meta) => {
                            if (data) {
                                return `<span class="badge rounded-pill bg-primary">Ya</span>`
                            }
                            return `<span class="badge rounded-pill bg-danger">Tidak</span>`
                        }
                    },
                    // {
                    //     data: 'accepted_at',
                    //     name: 'accepted_at',
                    // }
                ],
            })

            table.on('draw.dt', function() {
                var info = table.page.info();
                table.column(0, {
                    search: 'applied',
                    order: 'applied',
                    page: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1 + info.start;
                });
            });
        })
    </script>
@endsection
