@extends('layouts.pages')

@section('pageTitle')
    {{ $pageTitle ?? 'Login' }}
@endsection

@section('content')
    <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card-group d-block d-md-flex row">
                        <div class="card col-md-7 p-4 mb-0">
                            <div class="card-body">
                                <form action="" method="POST">
                                    @csrf
                                    <h1>Login</h1>
                                    @if ($errors->any())
                                        <div class="my-4">

                                            @foreach ($errors->all() as $error)
                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    <strong>{{ $error }}</strong>
                                                    <button type="button" class="btn-close" data-coreui-dismiss="alert"
                                                        aria-label="Close"></button>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    <p class="text-medium-emphasis mb-4">Masukkan Username dan Password</p>
                                    <div class="input-group mb-4">
                                        <span class="input-group-text">
                                            <i class="icon cil cil-user"></i>
                                        </span>
                                        <input class="form-control" type="text" placeholder="Username" name="username"
                                            required value="{{ old('username') }}" autocomplete="username">
                                    </div>
                                    <div class="input-group mb-4">
                                        <span class="input-group-text">
                                            <i class="icon cil cil-lock-locked"></i>
                                        </span>
                                        <input class="form-control" type="password" placeholder="Password" name="password"
                                            required autocomplete="current-password">
                                    </div>
                                    <div class="row">
                                        <div class="col-12 d-grid gap-2">
                                            <button class="btn rounded-pill btn-outline-info px-4"
                                                type="submit">Login</button>
                                        </div>
                                        <div class="mb-4"> </div>
                                        <div class="col-6">
                                            <button class="btn btn-link btn-sm px-0" type="button">Lupa Password?</button>
                                        </div>
                                        <div class="col-6 text-end">
                                            <a href="{{ route('signup') }}"><button class="btn btn-link btn-sm px-0"
                                                    type="button">Daftar Akun</button></a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <p class="text-medium-emphasis font-monospace mb-0" style="font-size: 75%">* Pendaftaran Akun
                                Hanya Untuk Reseller</p>
                        </div>
                        <div class="card col-md-5 text-white bg-gradient bg-dark py-5">
                            <div class="card-body text-center">
                                <div>
                                    <img src="{{ mix('assets/brand/GMDP_full.png') }}" style="width: 150px">
                                    {{-- edit --}}
                                </div>
                                <div class="mb-4"> </div>
                                <h4 class="fs-2">GMDP eBILLING</h4>
                                <p>Sistem Administrasi dan Pembayaran</p>
                            </div>
                            <p class="text-center fs-5 fw-light">PT.Global Media Data Prima</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
