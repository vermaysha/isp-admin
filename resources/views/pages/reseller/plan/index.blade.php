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
                            <a href=""> </a>
                        </div>
                        <div class="px-3">
                            <a href="{{ route('business.planMenu.create') }}" class="btn btn-primary btn-outline">Tambah
                                Paket</a>
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
                        <table id="planTable" class="table table-hover custom-table">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">#</th>
                                    <th scope="col">Nama Paket</th>
                                    <th scope="col" class="text-center">Bandwidth</th>
                                    <th scope="col" class="text-center">Jumlah Pengguna</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Pajak PPN</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    {{-- <div class="table-responsive px-3">
                        <table class="table table-hover align-middle custom-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th scope="col">Nama Paket</th>
                                    <th scope="col" class="text-center">Bandwidth</th>
                                    <th scope="col" class="text-center">Jumlah Pengguna</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Pajak PPN</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @foreach ($plans as $plan)
                                    <tr>
                                        <th scope="col">{{ $loop->iteration }}</th>
                                        <td scope="col">
                                            <a
                                                href="{{ route('business.planMenu.detail', ['id' => $plan->id]) }}">{{ $plan->name }}</a>
                                        </td>
                                        <td scope="col" class="text-center">
                                            <span class="badge badge-pills bg-info">
                                                {{ $plan->bandwidth }} Mbps
                                            </span>
                                        </td>
                                        <td scope="col" class="text-center">
                                            <span class="badge badge-pills bg-primary">
                                                {{ $plan->clients_count }} Pengguna
                                            </span>
                                        </td>
                                        <td scope="col">{{ rupiah_format($plan->price) }}</td>
                                        <td>
                                            @if ($plan->tax_type === App\Models\Plan::TAX_INCLUDED)
                                                <span class="badge badge-pills bg-success">Sudah Termasuk</span>
                                            @else
                                                <span class="badge badge-pills bg-danger">Belum Termasuk</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $plans->links('components.pagination') }}
                    </div> --}}
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
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            const planTable = $('#planTable').DataTable({
                serverSide: true,
                processing: true,
                ajax: '',
                info: true,
                columnDefs: [{
                    searchable: false,
                    orderable: false,
                    targets: 0,
                }],
                order: [
                    [0, 'desc']
                ],
                language: {
                    url: '{{ asset('/js/datatable-id.json') }}',
                },
                stateSave: true,
                pagingType: 'simple_numbers',
                columns: [{
                        data: 'id',
                        name: 'id',
                        searchable: false,
                        orderable: true,
                        className: 'dt-center',
                    }, {
                        data: 'name',
                        name: 'name',
                        searchable: true,
                        orderable: true,
                        render: (data, type, row, meta) => {
                            return `<a href="{{ route('business.planMenu.detail', ['id' => null]) }}/${row.id}">${row.name}</a>`;
                        }
                    },
                    {
                        data: 'bandwidth',
                        name: 'bandwidth',
                        searchable: false,
                        orderable: true,
                        className: 'dt-center',
                        render: (data, type) => {
                            if (type === 'display') {
                                return `<span class="badge badge-pills bg-info">
                                            ${data} Pengguna
                                        </span>`;
                            }

                            return data
                        }
                    },
                    {
                        data: 'clients_count',
                        name: 'clients_count',
                        searchable: false,
                        orderable: true,
                        className: 'dt-center',
                        render: (data, type) => {
                            if (type === 'display') {
                                return `<span class="badge badge-pills bg-primary">
                                            ${data} Pengguna
                                        </span>`;
                            }

                            return data
                        }
                    },
                    {
                        data: 'price',
                        name: 'price',
                        searchable: false,
                        orderable: true,
                        render: $.fn.dataTable.render.number('.', ',', 2, 'Rp')
                    },
                    {
                        data: 'tax_type',
                        name: 'tax_type',
                        searchable: false,
                        orderable: true,
                        render: (data, type) => {
                            if (data === {{ Js::from(App\Models\Plan::TAX_INCLUDED) }}) {
                                return `<span class="badge badge-pills bg-success">Sudah Termasuk</span>`
                            } else {
                                return `<span class="badge badge-pills bg-danger">Belum Termasuk</span>`
                            }
                        }
                    }
                ],
            });

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
        });
    </script>
@endsection
