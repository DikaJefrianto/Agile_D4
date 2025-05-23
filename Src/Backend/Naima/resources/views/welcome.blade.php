{{-- filepath: f:\Project\Agile_D4\Src\Backend\Naima\resources\views\welcome.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Naima Sustainability</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Header */
        .header {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(255, 254, 254, 0.1);
        }

        .logo {
            height: 50px;
        }

        .nav-link {
            color: #4a5568;
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #319c63;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 0.375rem;
            text-align: center;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn-primary {
            background-color: #38a169;
            color: #ffffff;
        }

        .btn-primary:hover {
            background-color: #2f855a;
        }

        .btn-secondary {
            background-color: #e2e8f0;
            color: #4a5568;
        }

        .btn-secondary:hover {
            background-color: #cbd5e0;
        }

        /* Mobile Menu */
        .menu-toggle .icon {
            height: 24px;
            width: 24px;
        }

        .profile-img {
            height: 40px;
            width: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-800">
    <!-- Header -->
    <header class="header bg-white shadow">
        <div class="container mx-auto flex items-center justify-between py-3 px-6">
            <div class="flex items-center">
                <img src="/images/ns-longl-color.png" alt="Naima Sustainability" class="logo">
                <nav class="hidden md:flex ml-10 space-x-6">
                    <a href="#" class="nav-link">Beranda</a>
                    <a href="#" class="nav-link">Perhitungan</a>
                    <a href="#" class="nav-link">Konsultasi</a>
                    <a href="#" class="nav-link">Tentang Kami</a>
                    <a href="#" class="nav-link">Panduan</a>
                </nav>
            </div>
            <div class="flex items-center space-x-3">
                @auth
                    <div class="dropdown">
                        <a href="#"
                            class="d-flex align-items-center justify-content-end text-decoration-none dropdown-toggle gap-2"
                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="text-sm text-black-800">{{ Auth::user()->name }}</span>
                            <img src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('/images/default-avatar.png') }}"
                                alt="profile" class="rounded-circle object-cover" style="width: 36px; height: 36px;">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Edit Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <!-- Jika pengguna belum login -->
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
                @endauth
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white shadow-lg">
            <nav class="flex flex-col space-y-2 p-4">
                <a href="#" class="nav-link">Beranda</a>
                <a href="#" class="nav-link">Perhitungan</a>
                <a href="#" class="nav-link">Konsultasi</a>
                <a href="#" class="nav-link">Tentang Kami</a>
                <a href="#" class="nav-link">Panduan</a>
                @auth
                    <!-- Jika pengguna sudah login -->
                    <div class="flex items-center space-x-3">
                        <img src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : 'https://i.pravatar.cc/35' }}"
                            alt="Foto Profil" class="profile-img">
                        <span class="text-gray-800 font-medium">{{ Auth::user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="btn btn-secondary">Logout</button>
                        </form>
                    </div>
                @else
                    <!-- Jika pengguna belum login -->
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
                @endauth
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative bg-cover bg-center"
        style="background-image: url('/images/home-page.png'); height: 450px; width: 100%;">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div
            class="container mx-auto relative z-10 flex flex-col items-center justify-center h-full text-center text-white px-4">
            <h1 class="text-3xl md:text-4xl font-bold">Ketahui Jejak Karbon dari Perjalanan Bisnis Anda</h1>
            <p class="mt-4 text-sm md:text-base">Lacak Emisi, Laporkan dengan Mudah, dan Mulai Perubahan Sekarang!</p>
            <a href="#" class="btn btn-primary mt-6">Hitung Jejak karbon kamu</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-green-100 py-10">
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 px-4">
            <div>
                <img src="/images/ns-longl-color.png" alt="Naima Sustainability" class="logo mb-4">
                <p class="text-sm text-gray-700">
                    Naima Sustainability menawarkan empat kategori layanan utama yang disesuaikan dengan kebutuhan
                    spesifik perusahaan dalam perjalanan keberlanjutan mereka: Penilaian, Kalkulasi dan Sertifikasi,
                    Transformasi Bisnis dan Digital, dan Solusi yang disesuaikan.
                </p>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800">Alamat Kantor</h3>
                <p class="text-sm text-gray-700 mt-2">Jl. Ilmu Manis</p>
                <p class="text-sm text-gray-700">Email Marketing: contactnaima@gmail.com</p>
                <p class="text-sm text-gray-700">+62 870-8381-7392</p>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800">Follow Us</h3>
                <div class="flex space-x-4 mt-4">
                    <a href="#" class="text-gray-700 hover:text-green-600"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="text-gray-700 hover:text-green-600"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-700 hover:text-green-600"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-gray-700 hover:text-green-600"><i class="fab fa-google"></i></a>
                    <a href="#" class="text-gray-700 hover:text-green-600"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
        <div class="mt-10 text-center text-sm text-gray-600">
            © 2024 Naima. All Rights Reserved
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Tailwind JS -->
    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>

</html>
