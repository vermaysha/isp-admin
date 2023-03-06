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
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="col-12">
                                <label class="visually-hidden" for="search">Search</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm" id="searchTable"
                                        placeholder="Cari ...">
                                    <div class="input-group-text">
                                        <i class="cil-magnifying-glass"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <form action="{{ route('business.clientMenu.index') }}" method="get">
                                <div class="col-12">
                                    <label class="visually-hidden" for="yearRange">Status</label>
                                    <div class="input-group">
                                        <select name="status" id="status" class="form-control select2">
                                            <option value="all">Semua</option>
                                            <option value="not_installed" @selected(request()->get('status') === 'not_installed')>Belum Terpasang
                                            </option>
                                            <option value="installed" @selected(request()->get('status') === 'installed')>Terpasang</option>
                                            <option value="blocked" @selected(request()->get('status') === 'blocked')>Diblokir</option>
                                            <option value="inactive" @selected(request()->get('status') === 'inactive')>Berhenti Sementara
                                            </option>
                                        </select>
                                        <button class="btn btn-primary btn-sm" type="submit">
                                            Kirim
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3 text-right">
                            <a id="resetFilter" href="{{ route('business.clientMenu.index') }}"
                                class="btn btn-danger btn-sm text-white">Reset</a>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex justify-content-end mb-3">
                                <div class="px-3">
                                    <a href="{{ route('business.clientMenu.create') }}"
                                        class="btn btn-primary btn-outline">Tambah
                                        Pelanggan</a>
                                </div>
                            </div>
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
                                    <th scope="col">Kecamatan</th>
                                    <th scope="col">Desa</th>
                                    <th scope="col">PPN</th>
                                    <th scope="col">Status Pemasangan</th>
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: "bootstrap-5",
            })
            const table = $('#clientTable').DataTable({
                serverSide: true,
                processing: true,
                ajax: '',
                info: false,
                lengthChange: false,
                dom: 'trip',
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
                        data: 'user.address.district.name',
                        name: 'user.address.district.name',
                        className: 'text-left',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'user.address.village.name',
                        name: 'user.address.village.name',
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
                                return `<span class="badge rounded-pill bg-success">Ya</span>`
                            }
                            return `<span class="badge rounded-pill bg-danger">Tidak</span>`
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-left',
                        searchable: false,
                        orderable: false,
                        render: (data) => {
                            if (data === 1) {
                                return `<span class="badge rounded-pill bg-info">Terpasang</span>`
                            } else if (data === 2) {
                                return `<span class="badge rounded-pill bg-danger">Terblokir</span>`
                            } else if (data === 3) {
                                return `<span class="badge rounded-pill bg-warning">Berhenti</span>`
                            } else {
                                return `<span class="badge rounded-pill bg-secondary">Belum Terpasang</span>`
                            }
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

            $('#searchTable').on('keyup', function() {
                table.search(this.value).draw();
            });

            var state = table.state.loaded();

            $('#searchTable').val(state.search.search)

            $('#resetFilter').on('click', async function(e) {
                e.preventDefault();

                table.state.clear();
                setTimeout(() => {
                    window.location.assign($(this).attr('href'))
                }, 250);
            })
        })
    </script>
@endsection
