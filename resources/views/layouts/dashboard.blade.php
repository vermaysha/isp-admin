<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>@yield('pageTitle') | {{ config('app.name') }}</title>

    <!-- Vendors styles-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simplebar@5.3.9/dist/simplebar.min.css">
    <link rel="stylesheet" href="{{ mix('css/simplebar.css') }}">
    <!-- Main styles for this application-->
    <link href="{{ mix('css/style.css') }}" rel="stylesheet">
    @yield('stylesheet')
</head>

<body>
    <div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
        <div class="sidebar-brand d-none d-md-flex">
            <div class="sidebar-brand-full">
                <img src="{{ mix('assets/brand/GMDP_35x35.png') }}" style="width: 35px">
            </div>
            <div class="nav-title mx-2">GMDP eBILLING</div>
        </div>
        <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
            <li class="nav-item"><a class="nav-link {{ Request::route()->getName() == 'home' ? 'active' : '' }}"
                    href="{{ route('home') }}">
                    <i class="nav-icon cil cil-speedometer"></i> Dashboard</a></li>
            {{-- Admin --}}
            {{-- reference: https://spatie.be/docs/laravel-permission/v5/basic-usage/blade-directives --}}
            @hasanyrole(\App\Models\Role::ADMIN)
                <li class="nav-title">Data Master</li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::route()->getName() == 'admin.reseller' ? 'active' : '' }}"
                        href="{{ route('admin.resellerMenu.index') }}">
                        <i class="nav-icon cil cil-vector"></i> Reseller</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::route()->getName() == 'admin.client' ? 'active' : '' }}"
                        href="{{ route('admin.clientMenu.index') }}">
                        <i class="nav-icon cil cil-people"></i> Pelanggan </a>
                </li>

                {{-- <li class="nav-title">Data Sistem</li> --}}
                <li class="nav-item">
                    <a class="nav-link {{ Request::route()->getName() == 'admin.admin' ? 'active' : '' }}"
                        href="{{ route('admin.adminMenu.index') }}">
                        <i class="nav-icon cil cil-featured-playlist"></i> Admin </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::route()->getName() == 'admin.register' ? 'active' : '' }}"
                        href="{{ route('admin.registerMenu.index') }}">
                        <i class="nav-icon cil cil-people"></i> Pendaftaran Reseller </a>
                </li>
            @endhasanyrole

            {{-- Reseller_Owner --}}
            {{-- reference: https://spatie.be/docs/laravel-permission/v5/basic-usage/blade-directives --}}
            @hasanyrole(\App\Models\Role::RESELLER_OWNER)
                <li class="nav-title">Data Master</li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::route()->getName() == 'business.clientMenu.index' ? 'active' : '' }}"
                        href="{{ route('business.clientMenu.index') }}">
                        <i class="nav-icon cil cil-user"></i> Pelanggan </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::route()->getName() == 'business.planMenu.index' ? 'active' : '' }}"
                        href="{{ route('business.planMenu.index') }}">
                        <i class="nav-icon cil cil-globe-alt"></i> Paket </a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link {{ Request::route()->getName() == 'business.billMenu.index' ? 'active' : '' }}"
                        href="{{ route('business.billMenu.index') }}">
                        <i class="nav-icon cil cil-chart"></i> Tagihan </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::route()->getName() == 'business.billMenu.history' ? 'active' : '' }}"
                        href="{{ route('business.billMenu.history') }}">
                        <i class="nav-icon cil cil-briefcase"></i> Transaksi</a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link {{ Request::route()->getName() == 'business.employeeMenu.index' ? 'active' : '' }}"
                        href="{{ route('business.employeeMenu.index') }}">
                        <i class="nav-icon cil cil-badge"></i> Pegawai </a>
                </li>
                {{-- <li class="nav-group" aria-expanded="true">
                    <a class="nav-link nav-group-toggle {{ Request::route()->getName() == 'business.billMenu.index' ? 'show' : '' }}"
                        href="#">
                        <i class="nav-icon cil cil-briefcase"></i> Tagihan </a>
                    <ul class="nav-group-items" style="height: auto;">
                        <li class="nav-item"><a class="nav-link" href="forms/form-control.html"> Tagihan belum dibayar</a></li>
                        <li class="nav-item"><a class="nav-link" href="forms/select.html"> Tagihan sudah dibayar</a></li>
                        <li class="nav-item"><a class="nav-link" href="forms/checks-radios.html"> Tagihan selesai</a></li>
                    </ul>
                </li> --}}


                <li class="nav-title">Data Tagihan</li>

                <li
                    class="nav-item {{ Str::contains(Request::route()->getName(), ['business.billMenu.paidOff', 'business.billMenu.paid', 'business.billMenu.outstanding']) ? 'show' : '' }}">
                    <a class="nav-link" href="{{ route('business.billMenu.outstanding') }}">
                        <i class="nav-icon cil cil-chart"></i>
                        Tagihan Terhutang
                        @if ($totalOutstandingBill)
                            <span class="badge badge-pills bg-danger ms-auto badge-sm">{{ $totalOutstandingBill }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('business.billMenu.paid') }}">
                        <i class="nav-icon cil cil-chart-line"></i>
                        Tagihan dibayar
                        @if ($totalPaidBill)
                            <span class="badge badge-pills bg-info ms-auto badge-sm">{{ $totalPaidBill }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('business.billMenu.paidOff') }}">
                        <i class="nav-icon cil cil-chart-pie"></i> Tagihan Selesai</a>
                </li>
            @endhasanyrole

            @hasanyrole(\App\Models\Role::RESELLER_ADMIN)
                <li class="nav-title">Data Master</li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::route()->getName() == 'business.clientMenu.index' ? 'active' : '' }}"
                        href="{{ route('business.clientMenu.index') }}">
                        <i class="nav-icon cil cil-user"></i> Pelanggan </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::route()->getName() == 'business.planMenu.index' ? 'active' : '' }}"
                        href="{{ route('business.planMenu.index') }}">
                        <i class="nav-icon cil cil-globe-alt"></i> Paket </a>
                </li>

                <li class="nav-title">Data Tagihan</li>

                <li
                    class="nav-item {{ Str::contains(Request::route()->getName(), ['business.billMenu.paidOff', 'business.billMenu.paid', 'business.billMenu.outstanding']) ? 'show' : '' }}">
                    <a class="nav-link" href="{{ route('business.billMenu.outstanding') }}">
                        <i class="nav-icon cil cil-chart"></i>
                        Tagihan Terhutang
                        @if ($totalOutstandingBill)
                            <span class="badge badge-pills bg-danger ms-auto badge-sm">{{ $totalOutstandingBill }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('business.billMenu.paid') }}">
                        <i class="nav-icon cil cil-chart-line"></i>
                        Tagihan dibayar
                        @if ($totalPaidBill)
                            <span class="badge badge-pills bg-info ms-auto badge-sm">{{ $totalPaidBill }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('business.billMenu.paidOff') }}">
                        <i class="nav-icon cil cil-chart-pie"></i> Tagihan Selesai</a>
                </li>
            @endhasanyrole

            @hasanyrole(\App\Models\Role::RESELLER_TECHNICIAN)
                <li class="nav-title">Data Master</li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::route()->getName() == 'business.client' ? 'active' : '' }}"
                        href="{{ route('business.clientMenu.index') }}">
                        <i class="nav-icon cil cil-user"></i> Pelanggan </a>
                </li>
            @endhasanyrole

            @hasanyrole(\App\Models\Role::CLIENT)
                <li class="nav-title">Data Tagihan</li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::route()->getName() == 'client.billMenu.outstanding' ? 'active' : '' }}"
                        href="{{ route('client.billMenu.outstanding') }}">
                        <i class="nav-icon cil cil-user"></i>
                        Tagihan Terhutang
                        @if ($totalOutstandingBill)
                            <span class="badge badge-pills bg-danger ms-auto badge-sm">{{ $totalOutstandingBill }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::route()->getName() == 'client.billMenu.history' ? 'active' : '' }}"
                        href="{{ route('client.billMenu.history') }}">
                        <i class="nav-icon cil cil-user"></i>
                        Riwayat Tagihan
                        @if ($totalPaidBill)
                            <span class="badge badge-pills bg-warning ms-auto badge-sm">{{ $totalPaidBill }}</span>
                        @endif
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link {{ Request::route()->getName() == 'client.invoiceMenu.index' ? 'active' : '' }}"
                        href="{{ route('client.invoiceMenu.index') }}">
                        <i class="nav-icon cil cil-user"></i> Tagihan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::route()->getName() == 'client.billMenu.index' ? 'active' : '' }}"
                        href="{{ route('client.billMenu.index') }}">
                        <i class="nav-icon cil cil-gem"></i> Transaksi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::route()->getName() == 'client.paymentMenu.index' ? 'active' : '' }}"
                        href="{{ route('client.paymentMenu.index') }}">
                        <i class="nav-icon cil cil-user"></i> Pembayaran</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::route()->getName() == 'client.profileMenu.index' ? 'active' : '' }}"
                        href="{{ route('client.profileMenu.index') }}">
                        <i class="nav-icon cil cil-user"></i> Profile</a>
                </li> --}}
            @endhasanyrole

            {{-- /Admin --}}
            {{-- <li class="nav-divider"></li>
        <li class="nav-title">Administrative Tools</li>
        <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
              <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-user-female"></use>
            </svg> ADMIN </a>
          <ul class="nav-group-items">
            <li class="nav-item"><a class="nav-link" href="login.html" target="_top">
                <svg class="nav-icon">
                  <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-id-card"></use>
                </svg> Daftar Admin</a></li>
            <li class="nav-item"><a class="nav-link" href="register.html" target="_top">
                <svg class="nav-icon">
                  <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-user-female-plus"></use>
                </svg> Tambah Admin</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link" href="https://coreui.io/docs/templates/installation/" target="_blank">
            <svg class="nav-icon">
              <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-settings"></use>
            </svg> SETTINGS </a></li>
        <li class="nav-item"><a class="nav-link nav-link-danger" href="https://coreui.io/pro/" target="_top"> --}}
            {{-- <svg class="nav-icon">
              <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-account-logout"></use>
            </svg> LOGOUT
          </a></li> --}}
            {{-- </ul> --}}
            {{-- <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button> --}}
    </div>
    <div class="wrapper d-flex flex-column min-vh-100 bg-light">
        <header class="header header-sticky mb-4">
            <div class="container-fluid">
                <button class="header-toggler px-md-0 me-md-3" type="button"
                    onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
                    <svg class="icon icon-lg">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-menu"></use>
                    </svg>
                </button>
                <a class="header-brand d-md-none">
                    <img src="{{ mix('assets/brand/GMDP_name.jpg') }}" style="width: 130px">
                </a>
                {{-- <ul class="header-nav">
                    @hasanyrole(\App\Models\Role::ADMIN)
                        <li class="nav-item"><a
                                class="nav-link {{ Request::route()->getName() == 'home' ? 'active' : '' }}"
                                href="{{ route('home') }}">Dashboard</a></li>
                        <li class="nav-item"><a
                                class="nav-link {{ Request::route()->getName() == 'admin.reseller' ? 'active' : '' }}"
                                href="{{ route('admin.resellerMenu.index') }}">Reseller</a></li>
                        <li class="nav-item"><a
                                class="nav-link {{ Request::route()->getName() == 'admin.client' ? 'active' : '' }}"
                                href="{{ route('admin.clientMenu.index') }}">Pelanggan</a></li>
                    @endhasanyrole
                    @hasanyrole(\App\Models\Role::CLIENT)
                        <li class="nav-item"><a
                                class="nav-link {{ Request::route()->getName() == 'home' ? 'active' : '' }}"
                                href="{{ route('home') }}">Dashboard</a></li>
                        <li class="nav-item"><a
                                class="nav-link {{ Request::route()->getName() == 'client.invoice' ? 'active' : '' }}"
                                href="{{ route('client.invoice') }}">Tagihan</a></li>
                        <li class="nav-item"><a
                                class="nav-link {{ Request::route()->getName() == 'client.bill' ? 'active' : '' }}"
                                href="{{ route('client.bill') }}">Transaksi</a></li>
                        <li class="nav-item"><a
                                class="nav-link {{ Request::route()->getName() == 'client.payment' ? 'active' : '' }}"
                                href="{{ route('client.payment') }}">Pembayaran</a></li>
                        <li class="nav-item"><a
                                class="nav-link {{ Request::route()->getName() == 'client.profile' ? 'active' : '' }}"
                                href="{{ route('client.profile') }}">Profile</a></li>
                    @endhasanyrole
                    <li class="nav-item"><a class="nav-link" href="#">Admin</a></li>
                </ul> --}}
                {{-- <ul class="header-nav ms-auto">
            <li class="nav-item nav-link">{{ Auth::user()->fullname }}</li>
            <li class="nav-item"><a class="nav-link" href="#">
                <svg class="icon icon-lg">
                  <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-list-rich"></use>
                </svg></a></li>
            <li class="nav-item"><a class="nav-link" href="#">
                <svg class="icon icon-lg">
                  <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-envelope-open"></use>
                </svg></a></li>
          </ul> --}}
                <ul class="header-nav ms-3">
                    {{-- <li class="nav-item nav-link">{{ Auth::user()->fullname }}</li> --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button"
                            aria-haspopup="true" aria-expanded="false">
                            <span class="mx-2">
                                {{ Auth::user()->fullname }}
                            </span>
                            <div class="avatar avatar-md">
                                <img class="avatar-img" src="{{ asset('assets/img/avatars/8.jpg') }}"
                                    alt="{{ Auth::user()->fullname }}">
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end pt-0">
                            <div class="dropdown-header bg-light py-2">
                                <div class="fw-semibold">Menu</div>
                            </div><a class="dropdown-item" href="#">
                                <svg class="icon me-2">
                                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-user">
                                    </use>
                                </svg> Profile</a><a class="dropdown-item" href="">

                                @hasanyrole(\App\Models\Role::RESELLER_OWNER)
                                    <svg class="icon me-2">
                                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-home">
                                        </use>
                                    </svg> Bisnis</a><a class="dropdown-item" href="#">
                                @endhasanyrole

                                <div class="dropdown-divider"></div><a class="dropdown-item"
                                    href="{{ route('logout') }}">
                                    <svg class="icon me-2">
                                        <use
                                            xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-account-logout">
                                        </use>
                                    </svg> Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="header-divider"></div>
            <div class="container-fluid">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb my-0 ms-2">
                        <li class="breadcrumb-item">
                            <!-- if breadcrumb is single--><span>Home</span>
                        </li>
                        <li class="breadcrumb-item active"><span>@yield('pageTitle')</span></li>
                    </ol>
                </nav>
            </div>
        </header>
        <div class="body flex-grow-1 px-3">
            @yield('content')
        </div>
        <footer class="footer">
            <div><a href="https://gmdp.net.id/">eBilling</a> © 2023 Global Media Data Prima.</div>
        </footer>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@4.2.6/dist/js/coreui.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simplebar@5.3.9/dist/simplebar.min.js"></script>
    <!-- Plugins and scripts required by this view-->
    @yield('script')

</body>

</html>
