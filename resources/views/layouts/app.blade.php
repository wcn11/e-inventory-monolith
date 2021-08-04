<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->user()->id }}">

    <title>Sistem Elektronik Stock Beliayam.com</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="shortcut icon" href="{{ asset('images/icon-bac.png') }}" type="image/x-icon">
        <link
            rel="stylesheet"
            href="{{ asset('css/animate.min.css') }}"
        />

    <!-- Styles -->
{{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}

{{--    plugins admin lte--}}
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

    <!-- Scripts VueJS -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<style>
    .accurate-reconnect{
        position: fixed;
        top: 0;
        z-index: 10000;
        width: 100%;
        height: 10%;
        text-align: center;
    }
</style>
@stack('css')
<body class="hold-transition sidebar-mini">


    <div class="wrapper" id="app">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('dashboard') }}" class="brand-link">
            <img src="{{ asset('images/icon-bac.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">E-Stock BAC</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('images/icon-bac.png') }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ auth()->user()->name }}</a>
                    <span class="text-center text-white">
                        {{ auth()->user()->getRoleNames()[0]}}
                    </span>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                    @can('Dashboard')
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-fastest"></i>
                                <p>
                                    Dashboard
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('dashboard') }}" class="nav-link">
                                        <i class="fas fa-tachometer-alt-fastest nav-icon"></i>
                                        <p>Dashboard</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('accurate.connect') }}" class="nav-link">
                                        <i class="fas fa-tachometer-alt-fastest nav-icon"></i>
                                        <p>Hubungkan Accurate</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan

                    @hasanyrole('Administrator')
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-inventory"></i>
                            <p>
                                Stock RPA
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('stock.control') }}" class="nav-link link-stock">
                                    <i class="fas fa-pallet nav-icon"></i>
                                    <p>Stock</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('stock.request') }}" class="nav-link link-stock">
                                    <i class="fad fa-people-carry nav-icon"></i>
                                    <p>Request Stock</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('stock.request.history') }}" class="nav-link link-stock">
                                    <i class="fad fa-clipboard-list-check nav-icon"></i>
                                    <p>Riwayat Request Stock</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                        @endhasanyrole

                    @hasanyrole('RPA')
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-inventory"></i>
                            <p>
                                Stock
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
{{--                            <li class="nav-item">--}}
{{--                                <a href="{{ route('stok') }}" class="nav-link link-stock">--}}
{{--                                    <i class="fas fa-pallet nav-icon"></i>--}}
{{--                                    <p>Stock</p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="{{ route('stok.opname') }}" class="nav-link link-stock-trip">--}}
{{--                                    <i class="fad fa-box-check nav-icon"></i>--}}
{{--                                    <p>Stock Opname</p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
                            <li class="nav-item">
                                <a href="{{ route('stok.trip') }}" class="nav-link link-stock-trip">
                                    <i class="fad fa-hand-holding-box nav-icon"></i>
                                    <p>Permintaan Stock</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('stok.request.history') }}" class="nav-link link-stock-history">
                                    <i class="fas fa-clipboard-list-check nav-icon"></i>
                                    <p>Riwayat Permintaan</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                        @endhasanyrole

                        @hasanyrole('Administrator')
                    @can('Kategori Barang')
                        <li class="nav-item menu-open">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-boxes"></i>
                            <p>
                                Data Barang
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('kategori') }}" class="nav-link">
                                    <i class="fas fa-code-branch nav-icon"></i>
                                    <p>Kategori Barang</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('barang') }}" class="nav-link">
                                    <i class="fas fa-box nav-icon"></i>
                                    <p>Barang</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('limit') }}" class="nav-link">
                                    <i class="fad fa-abacus nav-icon"></i>
                                    <p>Ambang Batas</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endcan
                        @endhasanyrole


                        @hasanyrole('Administrator')
                        <li class="nav-item menu-open">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                Pengguna & Otoritas
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('roles') }}" class="nav-link">
                                    <i class="fas fa-user-tag nav-icon"></i>
                                    <p>Peran</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user') }}" class="nav-link">
                                    <i class="fad fa-users-class nav-icon"></i>
                                    <p>Pengguna</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                        @endhasanyrole

                    @can('admin')
                        <li class="nav-item menu-open">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-sliders-h"></i>
                            <p>
                                Manual
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('manual.price') }}" class="nav-link">
                                    <i class="fas fa-list-ol nav-icon"></i>
                                    <p>Produk Manual</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:void(0)" class="nav-link">
                                    <i class="fas fa-dollar-sign nav-icon"></i>
                                    <p>Stock Manual</p>
                                    <span class="badge badge-pill badge-warning">Segera</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endcan

                        <li class="nav-header">Pengaturan</li>

                    @can('admin')
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link">
                                <i class="fas fa-cogs nav-icon"></i>
                                <p>Pengaturan</p>
                            </a>
                        </li>
                    @endcan
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link">
                            <i class="fas fa-sign-out-alt nav-icon"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

        @yield('content')

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2019-2021 <a href="https://adminlte.io">Sistem Inventaris Beliayam.Com</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0-BETA-VERSION
        </div>
    </footer>

        <div class="alert alert-danger accurate-reconnect" role="alert">
            <form action="{{ env("ACCURATE_HOST") }}" method="post">
            Accurate Tidak Terhubung! Data Persediaan Tidak Akan Di Update.  <button type="submit" class="btn btn-outline-secondary alert-link">HUBUNGKAN SEKARANG</button>.
                <input type="hidden" name="client_id" value="{{ env('ACCURATE_CLIENT_ID') }}" />
                <input type="hidden" name="response_type" value="{{ env('ACCURATE_RESPONSE_TYPE') }}" />
                <input type="hidden" name="redirect_uri" value="{{ env('ACCURATE_URL_CALLBACK') }}" />
                <input type="hidden" name="scope" value="receive_item_save receive_item_delete receive_item_view " />
            </form>
        </div>
</div>

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <script>
        window.BAC = {!! json_encode([
                "apiToken" => auth()->user()->api_token ?? null
        ]) !!};
    </script>

    @stack('scripts')
</body>
</html>
