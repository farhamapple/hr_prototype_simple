<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Manajemen HR') | {{ config('app.name', 'Sistem HR') }}</title>

    @vite(['resources/js/adminlte.js'])
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

    <div class="app-wrapper">

        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="fa-solid fa-bars"></i>
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#" role="button">
                            <i class="fa-regular fa-bell"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-user me-1"></i>
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <span class="dropdown-header">{{ Auth::user()->email }}</span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <div class="sidebar-brand">
                <a href="{{ route('dashboard') }}" class="brand-link">
                    <span class="brand-text fw-light">Sistem Manajemen HR</span>
                </a>
            </div>
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu">

                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-house"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                href="{{ route('employees.index') }}"
                                class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}"
                            >
                                <i class="nav-icon fa-solid fa-users"></i>
                                <p>Data Karyawan</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa-solid fa-building"></i>
                                <p>Data Departemen</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('jobs.index') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-briefcase"></i>
                                <p>Data Pekerjaan</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                href="{{ route('job-history.index') }}"
                                class="nav-link {{ request()->routeIs('job-history.*') ? 'active' : '' }}"
                            >
                                <i class="nav-icon fa-solid fa-clock-rotate-left"></i>
                                <p>Riwayat Pekerjaan</p>
                            </a>
                        </li>

                        <li class="nav-item {{ request()->routeIs('locations.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('locations.*') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-location-dot"></i>
                                <p>
                                    Lokasi & Wilayah
                                    <i class="nav-arrow fa-solid fa-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a
                                        href="{{ route('locations.index') }}"
                                        class="nav-link {{ request()->routeIs('locations.*') ? 'active' : '' }}"
                                    >
                                        <i class="nav-icon fa-regular fa-circle"></i>
                                        <p>Daftar Lokasi</p>
                                    </a>
                                </li>
                                <li class="nav-item"><a href="#" class="nav-link"><p>Daftar Negara</p></a></li>
                                <li class="nav-item"><a href="#" class="nav-link"><p>Daftar Wilayah</p></a></li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa-solid fa-chart-pie"></i>
                                <p>
                                    Laporan
                                    <i class="nav-arrow fa-solid fa-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"><a href="#" class="nav-link"><p>Karyawan per Departemen</p></a></li>
                                <li class="nav-item"><a href="#" class="nav-link"><p>Laporan Gaji</p></a></li>
                                <li class="nav-item"><a href="#" class="nav-link"><p>Riwayat Pekerjaan</p></a></li>
                                <li class="nav-item"><a href="#" class="nav-link"><p>Lokasi Kerja</p></a></li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa-solid fa-gear"></i>
                                <p>
                                    Pengaturan
                                    <i class="nav-arrow fa-solid fa-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"><a href="#" class="nav-link"><p>Profil Admin</p></a></li>
                                <li class="nav-item"><a href="#" class="nav-link"><p>Ganti Password</p></a></li>
                                <li class="nav-item">
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start"><p>Logout</p></button>
                                    </form>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>

        <main class="app-main">
            @yield('content')
        </main>

        <footer class="app-footer">
            <div class="float-end d-none d-sm-inline">Versi 1.0</div>
            <strong>Sistem Manajemen HR</strong> &copy; {{ date('Y') }}
        </footer>

    </div>

    @stack('scripts')

</body>
</html>
