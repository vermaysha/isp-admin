@extends('layouts.dashboard')

@section('pageTitle')
    {{ $title ?? 'Admin' }}
@endsection

@section('content')
    <div class="container-lg">
        <div class="row g-0">
            <div class="card">
                <div class="card-header">
                    <strong>Admin GMDP</strong>
                </div>
                <div class="card-body py-4">
                    <div class="d-flex justify-content-end mb-3">
                        <div class="px-3">
                            <a href="{{ route('admin.adminMenu.create') }}" class="btn btn-primary btn-outline">Tambah
                                Admin</a>
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
                        <table class="table table-hover align-middle custom-table" id="adminTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">#</th>
                                    <th scope="col">Nama Lengkap</th>
                                    <th scope="col">Alamat Email</th>
                                    <th scope="col">Jenis Kelamin</th>
                                    <th scope="col">Kantor</th>
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

@section('stylesheet')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            const table = $('#adminTable').DataTable({
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
                            return `<a href="{{ route('admin.adminMenu.detail') }}/${row.id}">
                                <img alt="${row.user.fullname}"
                                    src="{{ asset('') }}${photoUrl}"
                                    class="img-thumbnail rounded-circle" style="width: 60px">
                                <span class="ms-2">${row.user.fullname}</span>
                            </a>`;
                        }
                    },
                    {
                        data: 'user.email',
                        name: 'user.email',
                        className: 'text-left',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'user.gender',
                        name: 'user.gender',
                        className: 'text-left',
                        searchable: false,
                        orderable: false,
                        render: (data, type, row, meta) => {
                            if (row.gender == 'male') {
                                return `<span class="badge badge-pills bg-info">Laki-laki</span>`;
                            } else {
                                return `<span class="badge badge-pills bg-primary">Perempuan</span>`;
                            }
                        }
                    },
                    {
                        data: 'office_location',
                        name: 'office_location',
                        className: 'text-left',
                        searchable: false,
                        orderable: false,
                        render: (data, type, row, meta) => {
                            return `<span class="badge badge-pills bg-success">${data}</span>`;
                        }
                    },
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
