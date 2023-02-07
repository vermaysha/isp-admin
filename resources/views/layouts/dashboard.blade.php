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
            <img src="{{ mix('assets/brand/GMDP_35x35.png') }}"  style="width: 35px">
        </div>
        <div class="nav-title mx-2">GMDP eBILLING</div>
      </div>
      <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item"><a class="nav-link {{ Request::route()->getName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
            <i class="nav-icon cil cil-speedometer"></i> Dashboard</a></li>
        <li class="nav-title">Data Master</li>

        {{-- Admin --}}
        {{-- reference: https://spatie.be/docs/laravel-permission/v5/basic-usage/blade-directives --}}
        @hasanyrole('Admin')
        <li class="nav-item">
            <a class="nav-link {{ Request::route()->getName() == 'admin.reseller' ? 'active' : '' }}" href="{{ route('admin.reseller') }}">
            <i class="nav-icon cil cil-user"></i> Reseller</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::route()->getName() == 'admin.client' ? 'active' : '' }}" href="{{ route('admin.client') }}">
            <i class="nav-icon cil cil-people"></i> Pelanggan </a>
        </li>
        @endhasanyrole

        {{-- Reseller_Owner --}}
        {{-- reference: https://spatie.be/docs/laravel-permission/v5/basic-usage/blade-directives --}}
        @hasanyrole('Reseller_Owner')
        <li class="nav-item">
            <a class="nav-link {{ Request::route()->getName() == 'reseller_owner.client' ? 'active' : '' }}" href="{{ route('reseller_owner.client') }}">
            <i class="nav-icon cil cil-user"></i> Pelanggan </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::route()->getName() == 'reseller_owner.paket' ? 'active' : '' }}" href="{{ route('reseller_owner.bandwidth') }}">
            <i class="nav-icon cil cil-globe-alt"></i> Paket </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::route()->getName() == 'reseller_owner.bill' ? 'active' : '' }}" href="{{ route('reseller_owner.bill') }}">
            <i class="nav-icon cil cil-chart"></i> Tagihan </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::route()->getName() == 'reseller_owner.transaction' ? 'active' : '' }}" href="{{ route('reseller_owner.transaction') }}">
            <i class="nav-icon cil cil-briefcase"></i> Transaksi</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::route()->getName() == 'reseller_owner.employee' ? 'active' : '' }}" href="{{ route('reseller_owner.employee') }}">
            <i class="nav-icon cil cil-badge"></i> Pegawai </a>
        </li>
        @endhasanyrole

        @hasanyrole('Reseller_Admin')
        <li class="nav-item">
            <a class="nav-link {{ Request::route()->getName() == 'reseller_owner.client' ? 'active' : '' }}" href="{{ route('reseller_owner.client') }}">
            <i class="nav-icon cil cil-user"></i> Pelanggan </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::route()->getName() == 'reseller_owner.paket' ? 'active' : '' }}" href="{{ route('reseller_owner.bandwidth') }}">
            <i class="nav-icon cil cil-people"></i> Paket </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::route()->getName() == 'reseller_owner.bill' ? 'active' : '' }}" href="{{ route('reseller_owner.bill') }}">
            <i class="nav-icon cil cil-people"></i> Tagihan </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::route()->getName() == 'reseller_owner.history' ? 'active' : '' }}" href="{{ route('reseller_owner.history') }}">
            <i class="nav-icon cil cil-people"></i> Riwayat </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::route()->getName() == 'reseller_owner.transaction' ? 'active' : '' }}" href="{{ route('reseller_owner.transaction') }}">
            <i class="nav-icon cil cil-gem"></i> Transaksi</a>
        </li>
        @endhasanyrole

        @hasanyrole('Reseller_Teknisi')
        <li class="nav-item">
            <a class="nav-link {{ Request::route()->getName() == 'reseller_owner.client' ? 'active' : '' }}" href="{{ route('reseller_owner.client') }}">
            <i class="nav-icon cil cil-user"></i> Pelanggan </a>
        </li>
        @endhasanyrole

        @hasanyrole('Client')
        <li class="nav-item">
            <a class="nav-link {{ Request::route()->getName() == 'client.invoice' ? 'active' : '' }}" href="{{ route('client.invoice') }}">
            <i class="nav-icon cil cil-user"></i> Tagihan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::route()->getName() == 'client.bill' ? 'active' : '' }}" href="{{ route('client.bill') }}">
            <i class="nav-icon cil cil-gem"></i> Transaksi</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::route()->getName() == 'client.payment' ? 'active' : '' }}" href="{{ route('client.payment') }}">
            <i class="nav-icon cil cil-user"></i> Pembayaran</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::route()->getName() == 'client.profile' ? 'active' : '' }}" href="{{ route('client.profile') }}">
            <i class="nav-icon cil cil-user"></i> Profile</a>
        </li>
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
          <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
            <svg class="icon icon-lg">
              <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-menu"></use>
            </svg>
          </button><a class="header-brand d-md-none">
              <img src="{{ mix('assets/brand/GMDP_name.jpg') }}"  style="width: 200px">
          <ul class="header-nav d-none d-md-flex">
            @hasanyrole('Admin')
            <li class="nav-item"><a class="nav-link {{ Request::route()->getName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::route()->getName() == 'admin.reseller' ? 'active' : '' }}" href="{{ route('admin.reseller') }}">Reseller</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::route()->getName() == 'admin.client' ? 'active' : '' }}" href="{{ route('admin.client') }}">Pelanggan</a></li>
            @endhasanyrole
            @hasanyrole('Client')
            <li class="nav-item"><a class="nav-link {{ Request::route()->getName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::route()->getName() == 'client.invoice' ? 'active' : '' }}" href="{{ route('client.invoice') }}">Tagihan</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::route()->getName() == 'client.bill' ? 'active' : '' }}" href="{{ route('client.bill') }}">Transaksi</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::route()->getName() == 'client.payment' ? 'active' : '' }}" href="{{ route('client.payment') }}">Pembayaran</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::route()->getName() == 'client.profile' ? 'active' : '' }}" href="{{ route('client.profile') }}">Profile</a></li>
            @endhasanyrole
          {{--   <li class="nav-item"><a class="nav-link" href="#">Admin</a></li>   --}}
          </ul>
          <ul class="header-nav ms-auto">
            <li class="nav-item nav-link">{{ Auth::user()->username }}</li>
            {{--<li class="nav-item"><a class="nav-link" href="#">
                <svg class="icon icon-lg">
                  <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-list-rich"></use>
                </svg></a></li>
            <li class="nav-item"><a class="nav-link" href="#">
                <svg class="icon icon-lg">
                  <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-envelope-open"></use>
                </svg></a></li>--}}
          </ul>
          <ul class="header-nav ms-3">
            <li class="nav-item dropdown"><a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <div class="avatar avatar-md"><img class="avatar-img" src="{{ asset('assets/img/avatars/8.jpg') }}" alt="user@email.com"></div>
              </a>
              <div class="dropdown-menu dropdown-menu-end pt-0">
                <div class="dropdown-header bg-light py-2">
                  <div class="fw-semibold">Settings</div>
                </div><a class="dropdown-item" href="#">
                  <svg class="icon me-2">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-user"></use>
                  </svg> Profile</a><a class="dropdown-item" href="#">
                  <svg class="icon me-2">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-settings"></use>
                  </svg> Settings</a><a class="dropdown-item" href="#">
                <div class="dropdown-divider"></div><a class="dropdown-item" href="{{ route('logout') }}">
                  <svg class="icon me-2">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-account-logout"></use>
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
