<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Naima Sustainability</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            overflow-x: hidden;
        }

        .sidebar {
            width: 240px;
            height: 100vh;
            background-color: #2dce89;
            position: fixed;
        }

        .sidebar .nav-link {
            color: #fff;
        }

        .sidebar .nav-link.active {
            background-color: rgba(0, 0, 0, 0.1);
        }

        .content {
            margin-left: 240px;
        }
    </style>
</head>

<body>
    <div class="sidebar d-flex flex-column p-3">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <i class="bi bi-leaf-fill fs-3">
                <img src="/images/ns-white-color.png" alt="NAIMA Logo" style="width: 100%; height: auto;"></i>
            <span class="fs-3 ms-2"></span>
        </a>
        <hr class="text-white">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <i class="bi bi-house me-2"></i> Beranda
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('perhitungan.create') }}" class="nav-link">
                    <i class="bi bi-calculator me-2"></i> Perhitungan
                </a>
            </li>
            {{-- Menu Dropdown Perhitungan --}}
            <li>
                <a class="nav-link text-white dropdown-toggle" data-bs-toggle="collapse" href="#submenuPerhitungan"
                    role="button" aria-expanded="false" aria-controls="submenuPerhitungan">
                    <i class="bi bi-list-ul me-2"></i> Tabel
                </a>
                <div class="collapse ps-2 @if (request()->routeIs('perhitungan.*') || request()->routeIs('transportasi.*') || request()->routeIs('bahanbakar.*')) show @endif" id="submenuPerhitungan">
                    <ul class="nav flex-column">
                        <li>
                            <a href="{{ route('perhitungan.index') }}" class="nav-link text-white">
                                <i class="bi bi-calculator me-2"></i> Hasil Perhitungan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('transportasi.index') }}" class="nav-link text-white">
                                <i class="bi bi-truck me-2"></i>  Jenis Transportasi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('BahanBakar.index') }}" class="nav-link text-white ">
                                <i class="bi bi-fuel-pump me-2"></i>  Bahan Bakar
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link @if (request()->routeIs('biaya.*')) active @endif">
                                <i class="bi bi-cash-coin me-2"></i> Manajemen Biaya
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li>
                <a href="" class="nav-link @if (request()->routeIs('konsultasi.*')) active @endif">
                    <i class="bi bi-chat-left-dots me-2"></i> Konsultasi
                </a>
            </li>
            <!-- Tambahkan setelah Konsultasi -->
            
            <li>
                <a href="#"
                    class="nav-link @if (request()->routeIs('strategi.*')) active @endif">
                    <i class="bi bi-lightbulb me-2"></i> Strategi
                </a>
            </li>
            <li>
                <a href="#" class="nav-link @if (request()->routeIs('panduan.*')) active @endif">
                    <i class="bi bi-journal-text me-2"></i> Panduan
                </a>
            </li>
            <li>
                <a href="#"
                    class="nav-link @if (request()->routeIs('feedback.*')) active @endif">
                    <i class="bi bi-chat-square-quote me-2"></i> Feedback
                </a>
            </li>

        </ul>
    </div>

    <div class="content">
        {{-- Topbar Optional --}}
        <nav class="navbar navbar-expand navbar-light bg-white shadow-sm mb-4">
            <div class="container-fluid">
                <form class="d-flex ms-auto me-3">
                    <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                </form>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                        id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('avatar.png') }}" alt="user" width="32" height="32"
                            class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="/logout">Log out</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        {{-- Main Content --}}
        <main class="p-4">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
