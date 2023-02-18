@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Tagihan' }}
@endsection

@section('content')
    <div class="container-lg">
        <div class="row g-0 mb-4">
            <div class="card">
                <div class="card-header">
                    <strong>{{ $title }}</strong>
                </div>
                <div class="card-body py-4">
                    <div class="table-responsive p-2">
                        <table class="table table-hover align-middle custom-table" id="billTable">
                            <thead class="align-middle">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Invoice</th>
                                    <th scope="col">Paket</th>
                                    <th scope="col">Nilai</th>
                                    <th scope="col" class="text-center">Pembayaran Bulan</th>
                                    @if ($type !== 'outstanding')
                                        <th scope="col" class="text-center">Dibayar Tanggal</th>
                                        <th scope="col">Status</th>
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
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            const table = $('#billTable').DataTable({
                serverSide: true,
                processing: true,
                ajax: '',
                info: true,
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
                            return `<a href="{{ route('client.billMenu.detail') }}/${row.id}">
                                ${row.invoice_id}
                            </a>`;
                        }
                    },
                    // {
                    //     data: 'client',
                    //     name: 'client.user.fullname',
                    //     searchable: true,
                    //     orderable: true,
                    //     className: 'align-middle',
                    //     render: (data, type, row, meta) => {
                    //         const photoUrl = row.client.user.photo ?? 'assets/brand/GMDP_100x100.png'
                    //         return `<a href="{{ route('business.clientMenu.detail') }}/${row.client_id}">
                //             <img alt="${row.client.user.fullname ?? row.client_name}"
                //                 src="{{ asset('') }}${photoUrl}"
                //                 class="img-thumbnail rounded-circle" style="width: 60px">
                //             <span class="ms-2">${row.client.user.fullname}</span>
                //         </a>`;
                    //     }
                    // },
                    {
                        data: 'plan_name',
                        name: 'plan_name',
                        searchable: true,
                        orderable: true,
                        render: (data, type, row, meta) => {
                            return data
                            // return `<a href="{{ route('business.planMenu.detail') }}/${row.plan_id}">
                        //     ${row.plan_name}
                        // </a>`;
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
                        orderable: true,
                        render: (data, type, row, meta) => {
                            return `<span class="badge badge-pills bg-info">
                                ${data}
                            </span>`;
                        }
                    },
                    @if ($type !== 'outstanding')
                        {
                            data: 'payed_at_formated',
                            name: 'payed_at',
                            className: 'text-center',
                            searchable: false,
                            orderable: true,
                            render: (data, type, row, meta) => {
                                return `<span class="badge badge-pills bg-success">
                                ${data}
                            </span>`;
                            }
                        }, {
                            data: null,
                            name: null,
                            className: 'text-center',
                            searchable: false,
                            orderable: false,
                            render: (data, type, row, meta) => {
                                if (row.payed_at == null && row.accepted_at == null) {
                                    return `<span class="badge badge-pills bg-danger">
                                    Belum Dibayar
                                </span>`;
                                } else if (row.payed_at != null && row.accepted_at == null) {
                                    return `<span class="badge badge-pills bg-warning">
                                    Belum Dikonfirmasi
                                </span>`;
                                } else {
                                    return `<span class="badge badge-pills bg-success">
                                    Selesai
                                </span>`;
                                }
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
        })
    </script>
@endsection
