@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Paket' }}
@endsection

@section('content')
    <div class="container-lg">
        <div class="row g-0">
            <div class="card">
                <div class="card-header">
                    <strong>Pagawai</strong>
                </div>
                <div class="card-body py-4">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="px-3">
                            <a href=""> </a>
                        </div>
                        <div class="px-3">
                            <a href="{{ route('business.employeeMenu.create') }}" class="btn btn-primary btn-outline">Tambah
                                Pegawai</a>
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
                        <table class="table table-hover align-middle custom-table" id="staffTable">
                            <thead class="align-middle">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Jabatan</th>
                                    <th scope="col">Nomor Telepon</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">Tanggal Pendaftaran</th>
                                </tr>
                            </thead>
                        </table>
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
            const table = $('#staffTable').DataTable({
                serverSide: true,
                processing: true,
                ajax: '',
                info: true,
                language: {
                    url: '{{ asset('/js/datatable-id.json') }}',
                },
                order: [
                    [0, 'asc']
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
                        data: 'fullname',
                        name: 'fullname',
                        searchable: true,
                        orderable: true,
                        className: 'align-middle',
                        render: (data, type, row, meta) => {
                            const photoUrl = row.photo ?? 'assets/brand/GMDP_100x100.png'
                            return `<a href="{{ route('business.employeeMenu.detail') }}/${row.id}">
                                <img alt="${row.fullname}"
                                    src="{{ asset('') }}${photoUrl}"
                                    class="img-thumbnail rounded-circle" style="width: 60px">
                                <span class="ms-2">${row.fullname}</span>
                            </a>`;
                        }
                    },
                    {
                        data: 'roles',
                        name: 'roles[0].name',
                        searchable: false,
                        orderable: true,
                        render: (data, type, row, meta) => {
                            if (data[0].name == {{ Js::from(App\Models\Role::RESELLER_OWNER) }}) {
                                return `<span class="badge badge-pills bg-primary">Pemilik Usaha</span>`
                            }
                            if (data[0].name == {{ Js::from(App\Models\Role::RESELLER_ADMIN) }}) {
                                return `<span class="badge badge-pills bg-info">Admin Usaha</span>`
                            }
                            if (data[0].name ==
                                {{ Js::from(App\Models\Role::RESELLER_TECHNICIAN) }}) {
                                return `<span class="badge badge-pills bg-warning">Teknisi Usaha</span>`
                            }
                            return data[0].name;
                        }
                    },
                    {
                        data: 'phone_number',
                        name: 'phone_number',
                        className: 'text-left',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'address',
                        name: 'address',
                        className: 'text-left',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'created_at_formated',
                        name: 'created_at',
                        className: 'text-center',
                        searchable: false,
                        orderable: true,
                        render: (data, type, row, meta) => {
                            return `<span class="badge badge-pills bg-info">
                                ${data}
                            </span>`;
                        }
                    }
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
