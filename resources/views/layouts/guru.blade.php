<!doctype html>
<html lang="en">

<head>
    <title>@yield('title') | Guru</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link href="{{ asset('assets/vendor/fonts/circular-std/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/libs/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome/css/fontawesome-all.css') }}">
</head>

<body>
    <div class="dashboard-main-wrapper">

        <!-- NAVBAR -->
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top px-4 custom-navbar">

                <!-- BRAND -->
                <a class="navbar-brand" href="#">Pengaduan Sarana Sekolah</a>

                <!-- RIGHT SIDE WRAPPER -->
                <div class="ml-auto d-flex align-items-center">

                    <!-- SEARCH -->
                    <form class="form-inline mr-3">
                        <input class="form-control" type="search" placeholder="Search..">
                    </form>

                    <!-- MENU -->
                    <ul class="navbar-nav d-flex align-items-center mb-0">

                        <!-- NOTIF -->
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="#">
                                <i class="fas fa-bell"></i>
                            </a>
                        </li>

                        <!-- GRID -->
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="#">
                                <i class="fas fa-th"></i>
                            </a>
                        </li>

                        <!-- USER -->
                        <li class="nav-item dropdown nav-user ml-2">
                            <a class="nav-link nav-user-img" href="#" data-toggle="dropdown">
                                <img src="{{ asset('assets/images/avatar-1.jpg') }}"
                                    class="rounded-circle" width="40">
                            </a>

                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown">

                                <!-- HEADER -->
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white">
                                        {{ auth()->user()->name ?? 'User' }}
                                    </h5>
                                    <span class="status"></span>
                                    <span class="ml-2">Available</span>
                                </div>

                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user mr-2"></i> Account
                                </a>

                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cog mr-2"></i> Setting
                                </a>

                                <a href="#" class="dropdown-item"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-power-off mr-2"></i> Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                                    @csrf
                                </form>
                            </div>
                        </li>

                    </ul>
                </div>
            </nav>
        </div>

        <!-- SIDEBAR BARU -->
        <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">

                <!-- HEADER / BRAND -->
                <div class="d-flex align-items-center">
                    <div class="mr-2">
                        <i class="fa fa-school text-primary" style="font-size: 24px;"></i>
                    </div>
                </div>x`

                <!-- USER INFO -->
                <!-- FOTO / INISIAL -->
                @php
                $user = Auth::user();
                @endphp

                <!-- MENU -->
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="collapse navbar-collapse show">

                        <ul class="navbar-nav flex-column w-100">

                            <!-- NAVIGASI -->
                            <li class="nav-divider text-white px-3 mt-3">
                                Navigasi Utama
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('guru.dashboard') }}">
                                    <i class="fa fa-home"></i> Dashboard Guru
                                </a>
                            </li>

                            <!-- MANAJEMEN -->
                            <li class="nav-divider text-white px-3 mt-3">
                                Manajemen
                            </li>

                            <!-- BUAT ASPIRASI -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('guru.aspirasi.create') }}">
                                    <i class="fa fa-plus"></i> Buat Aspirasi
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('guru.aspirasi.index') }}">
                                    <i class="fa fa-database"></i> Data Aspirasi
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('guru.aspirasi.history') }}">
                                    <i class="fa fa-history"></i> Review Aspirasi Siswa
                                </a>
                            </li>

                        </ul>

                    </div>
                </nav>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content">

                @yield('content')

            </div>
        </div>

    </div>

    <!-- JS -->
    <script src="{{ asset('assets/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('assets/libs/js/main-js.js') }}"></script>

</body>

</html>