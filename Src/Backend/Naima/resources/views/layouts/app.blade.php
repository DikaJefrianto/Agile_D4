<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Naima Sustainability')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            overflow: hidden;
            /* Menyembunyikan scroll pada body */
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background-color: #069460;
            color: white;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 70px;
            overflow-y: auto;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: 240px;
            right: 0;
            height: 70px;
            background-color: #ffffff;
            color: black;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .profile-pic {
            width: 35px;
            height: 35px;
            object-fit: cover;
        }

        .dropdown-toggle::after {
            display: none;
        }

        /* Main Content */
        .main-content {
            margin-left: 240px;
            padding: 100px 20px 20px;
            height: calc(100vh - 70px);
            /* Mengatur tinggi konten utama */
            overflow-y: auto;
            /* Mengaktifkan scroll vertikal */
        }

        /* Tabel */
        table {
            table-layout: fixed;
            /* Membuat kolom tabel memiliki lebar tetap */
            width: 100%;
            /* Lebar tabel selalu 100% dari kontainer */
            word-wrap: break-word;
            /* Membungkus teks jika terlalu panjang */
        }

        th,
        td {
            text-align: center;
            /* Menyelaraskan teks di tengah */
            vertical-align: middle;
            /* Menyelaraskan teks secara vertikal di tengah */
        }

        /* Input dan Select */
        input,
        select,
        textarea {
            width: 100%;
            /* Lebar input tetap 100% dari kontainer */
            padding: 10px;
            /* Tambahkan padding */
            margin: 10px 0;
            /* Tambahkan margin */
            box-sizing: border-box;
            /* Agar padding tidak mempengaruhi ukuran total */
            font-size: 16px;
            /* Ukuran font tetap */
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                padding-top: 0;
            }

            .header {
                left: 0;
            }

            .main-content {
                margin-left: 0;
                padding-top: 90px;
                height: calc(100vh - 90px);
                /* Mengatur tinggi konten utama pada mobile */
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column p-3">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <img src="/images/ns-white-color.png" alt="NAIMA Logo" style="width: 200px; height: auto;" class="me-2">
        </a>
        <hr class="text-white">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="/dashboard" class="nav-link text-white">
                    <i class="bi bi-house me-2"></i> Dashboard
                </a>
            </li>
            @if (auth()->user()->role == 'admin')
                <li>
                    <a href="{{ route('perusahaans.index') }}" class="nav-link text-white">
                        <i class="bi bi-buildings me-2"></i> Manajemen Perusahaan
                    </a>
                </li>
            @endif
            @if (auth()->user()->role == 'perusahaan')
                <li>
                    <a href="{{ route('karyawans.index') }}" class="nav-link text-white">
                        <i class="bi bi-person me-2"></i> Karyawan
                    </a>
                </li>
            @endif
            <li>
                <a href="#" class="nav-link text-white">
                    <i class="bi bi-calculator me-2"></i> Perhitungan
                </a>
            </li>
            <li>
                <a class="nav-link text-white dropdown-toggle" data-bs-toggle="collapse" href="#submenuPerhitungan"
                    role="button" aria-expanded="false" aria-controls="submenuPerhitungan">
                    <i class="bi bi-list-ul me-2"></i> Tabel
                </a>
                <div class="collapse ps-2" id="submenuPerhitungan">
                    <ul class="nav flex-column">
                        <li>
                            <a href="#" class="nav-link text-white">
                                <i class="bi bi-calculator me-2"></i> Hasil Perhitungan
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link text-white">
                                <i class="bi bi-truck me-2"></i> Jenis Transportasi
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link text-white">
                                <i class="bi bi-fuel-pump me-2"></i> Bahan Bakar
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="#" class="nav-link text-white">
                    <i class="bi bi-chat-left-dots me-2"></i> Konsultasi
                </a>
            </li>
            <li>
                <a href="#" class="nav-link text-white">
                    <i class="bi bi-cash-coin me-2"></i> Manajemen Biaya
                </a>
            </li>
            <li>
                <a href="{{ route('strategi.index') }}" class="nav-link text-white">
                    <i class="bi bi-lightbulb me-2"></i> Strategi
                </a>
            </li>
            <li>
                <a href="#" class="nav-link text-white">
                    <i class="bi bi-journal-text me-2"></i> Panduan
                </a>
            </li>
            <li>
                <a href="#" class="nav-link text-white">
                    <i class="bi bi-chat-square-quote me-2"></i> Feedback
                </a>
            </li>
        </ul>
    </div>
    <!-- Header -->
    <div class="header shadow-sm">
        <h2 class="mb-0">
            <span class="text-black">
                @yield('page_title', 'Dashboard')
            </span>
        </h2>
        <div class="d-flex align-items-center gap-3">
            {{-- <div class="input-group input-group-sm me-3 d-none d-md-flex">
                <input type="text" class="form-control" placeholder="Cari..." aria-label="Cari">
                <button class="btn btn-light" type="button"><i class="bi bi-search"></i></button>
            </div> --}}
            <div class="dropdown d-flex align-items-center">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle gap-2"
                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="me-2 text-black">Hi, {{ Auth::user()->name }}</span>
                    <img src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('/images/default-avatar.png') }}"
                        class="rounded-circle profile-pic" alt="profile">
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="{{ route('profile.update') }}">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form id="logout-form-dropdown" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                        <a class="dropdown-item text-danger" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form-dropdown').submit();">
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Main Content -->
    <div class="main-content">
        @yield('content') <!-- Isi konten -->
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
