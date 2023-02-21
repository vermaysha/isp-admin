@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Transaksi' }}
@endsection

@section('content')
    <div class="container-lg">
        <div class="row g-0 mb-4">
            <div class="card">
                <div class="card-header">
                    <strong>{{ $title }}</strong>
                </div>
                <div class="card-body py-4">
                    <div class="row mb-4">
                        <div class="col-md-4">
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
                        <div class="col-md-4">
                            <form action="" method="get">
                                <div class="col-12">
                                    <label class="visually-hidden" for="yearRange">Pembayaran Bulan</label>
                                    <div class="input-group">
                                        <input type="text" name="yearRange" id="yearRange" placeholder="Pembayaran Bulan"
                                            class="form-control form-control-sm" value="{{ $yearRange ?? '' }}">
                                        <button class="btn btn-primary btn-sm" type="submit">
                                            Kirim
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4 text-right">
                            <a id="resetFilter" href="{{ route('business.billMenu.paidOff') }}"
                                class="btn btn-danger btn-sm text-white">Reset</a>
                        </div>
                    </div>
                    <div class="table-responsive p-2">
                        <table class="table table-hover align-middle custom-table" id="billTable">
                            <thead class="align-middle">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Invoice</th>
                                    <th scope="col">Pelanggan</th>
                                    <th scope="col">Paket</th>
                                    <th scope="col">Nilai</th>
                                    <th scope="col" class="text-center">Pembayaran Bulan</th>
                                    @if ($transaction_type !== 'outstanding')
                                        <th scope="col" class="text-center">Dibayar Tanggal</th>
                                    @endif
                                    {{-- <th scope="col" class="text-center">Dikonfirmasi</th> --}}
                                </tr>
                            </thead>
                        </table>
                        {{-- @include('pages.reseller.transaction.indexTable') --}}
                    </div>
                    {{-- {{ $bills->links('components.pagination') }} --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/plugins/monthSelect/style.min.css">
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/plugins/monthSelect/index.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#yearRange').flatpickr({
                mode: 'range',
                altInput: true,
                plugins: [
                    new monthSelectPlugin({
                        shorthand: true,
                        dateFormat: "Y-m",
                        altFormat: "F Y",
                    })
                ]
            });

            var table = $('#billTable').DataTable({
                serverSide: true,
                processing: true,
                ajax: '',
                info: false,
                lengthChange: false,
                dom: 'trip',
                language: {
                    url: '{{ asset('/js/datatable-id.json') }}',
                },
                stateSave: true,
                pagingType: 'simple_numbers',
                order: [
                    [0, 'desc']
                ],
                columns: [{
                        data: 'id',
                        name: 'id',
                        orderable: true,
                        searchable: false,
                        className: 'text-center',
                    },
                    {
                        data: 'invoice_id',
                        name: 'invoice_id',
                        searchable: false,
                        orderable: true,
                        className: 'dt-center',
                        render: (data, type, row, meta) => {
                            return `<a href="{{ route('business.billMenu.detail') }}/${row.id}">
                                ${row.invoice_id}
                            </a>`;
                        }
                    },
                    {
                        data: 'client',
                        name: 'client.user.fullname',
                        searchable: true,
                        orderable: true,
                        className: 'align-middle',
                        render: (data, type, row, meta) => {
                            const photoUrl = row.client.user.photo ??
                                'assets/brand/GMDP_100x100.png'
                            return `<a href="{{ route('business.clientMenu.detail') }}/${row.client_id}">
                                <img alt="${row.client.user.fullname ?? row.client_name}"
                                    src="{{ asset('') }}${photoUrl}"
                                    class="img-thumbnail rounded-circle" style="width: 60px">
                                <span class="ms-2">${row.client.user.fullname}</span>
                            </a>`;
                        }
                    },
                    {
                        data: 'plan_name',
                        name: 'plan_name',
                        searchable: true,
                        orderable: true,
                        render: (data, type, row, meta) => {
                            return `<a href="{{ route('business.planMenu.detail') }}/${row.plan_id}">
                                ${row.plan_name}
                            </a>`;
                        }
                    },
                    {
                        data: 'grand_total_formated',
                        name: 'grand_total',
                        className: 'text-left',
                        searchable: false,
                        orderable: true,
                    },
                    {
                        data: 'payment_month_formated',
                        name: 'payment_month',
                        className: 'text-center',
                        searchable: false,
                        orderable: false,
                        render: (data, type, row, meta) => {
                            return `<span class="badge badge-pills bg-info">
                                ${data}
                            </span>`;
                        }
                    },
                    @if ($transaction_type !== 'outstanding')
                        {
                            data: 'created_at_formated',
                            name: 'created_at',
                            className: 'text-center',
                            searchable: false,
                            orderable: true,
                            render: (data, type, row, meta) => {
                                return `<span class="badge badge-pills bg-success">
                                ${data}
                            </span>`;
                            }
                        },
                    @endif
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
