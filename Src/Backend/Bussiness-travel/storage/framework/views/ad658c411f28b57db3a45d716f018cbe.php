

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Naima Sustainability</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
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

        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 0.375rem;
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
    </style>
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-800">
    <div class="flex flex-col min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow">
            <div class="container mx-auto flex items-center justify-between py-3 px-4 md:px-6">
                <div class="flex items-center justify-between w-full md:w-auto">
                    <img src="/images/ns-longl-color.png" alt="Naima Sustainability" class="logo" />
                    <!-- Mobile menu toggle -->
                    <button id="menu-toggle" class="md:hidden ml-3">
                        <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
                <nav class="hidden md:flex ml-10 space-x-6" data-auth="<?php echo e(Auth::check() ? 'true' : 'false'); ?>">
                    <a href="#" class="nav-link">Beranda</a>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link">Dashboard</a>
                    <a href="#" class="nav-link">Perhitungan</a>
                    <a href="#" class="nav-link">Konsultasi</a>
                    <a href="#" class="nav-link">Tentang Kami</a>
                    <a href="#" class="nav-link">Panduan</a>
                </nav>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const nav = document.querySelector("nav[data-auth]");
                        const isAuthenticated = nav.dataset.auth === "true";

                        const links = nav.querySelectorAll("a.nav-link");
                        links.forEach(link => {
                            link.addEventListener("click", function(e) {
                                if (!isAuthenticated) {
                                    e.preventDefault();
                                    window.location.href = "http://localhost:8000/login";
                                }
                            });
                        });
                    });
                </script>
                <div class="hidden md:flex items-center space-x-3">
                    <?php if(auth()->guard()->check()): ?>
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center dropdown-toggle gap-2"
                                data-bs-toggle="dropdown">
                                <span class="text-sm text-black-800"><?php echo e(Auth::user()->name); ?></span>
                                <img src="<?php echo e(Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('/images/default-avatar.png')); ?>"
                                    alt="profile" class="rounded-circle" style="width: 36px; height: 36px;">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?php echo e(route('profile.edit')); ?>">Edit Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-primary">Login</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden bg-white px-4 pb-4">
                <nav class="flex flex-col space-y-2">
                    <a href="#" class="nav-link">Beranda</a>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link">Dashboard</a>
                    <a href="#" class="nav-link">Perhitungan</a>
                    <a href="#" class="nav-link">Konsultasi</a>
                    <a href="#" class="nav-link">Tentang Kami</a>
                    <a href="#" class="nav-link">Panduan</a>
                    <?php if(auth()->guard()->check()): ?>
                        <form action="<?php echo e(route('logout')); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-secondary">Logout</button>
                        </form>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-primary">Login</a>
                    <?php endif; ?>
                </nav>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="relative bg-cover bg-center"
            style="background-image: url('/images/home-page.png'); height: 450px;">
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
            <div
                class="container mx-auto relative z-10 flex flex-col items-center justify-center h-full text-center text-white px-4">
                <h1 class="text-3xl md:text-4xl font-bold">Ketahui Jejak Karbon dari Perjalanan Bisnis Anda</h1>
                <p class="mt-4 text-sm md:text-base">Lacak Emisi, Laporkan dengan Mudah, dan Mulai Perubahan Sekarang!
                </p>
                <a href="#" class="btn btn-primary mt-6">Hitung Jejak karbon kamu</a>
            </div>
        </section>

        <!-- Content -->
        <main class="flex-grow container mx-auto px-4 mt-10">
            <div class="grid md:grid-cols-2 gap-6 items-center mb-16">
                <div>
                    <h2 class="text-2xl font-bold mb-4">Menghitung Jejak Karbon adalah Langkah Awal untuk Berkontribusi
                    </h2>
                    <p class="text-gray-600">Perubahan iklim adalah tantangan global... menuju operasional yang lebih
                        berkelanjutan.</p>
                </div>
                <div class="text-center md:text-right">
                    <img src="https://lindungihutan.com/public/carbon-calculator/img/section2.svg" alt="Eco City"
                        class="mx-auto md:ml-auto w-full max-w-md">
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6 items-center mb-16">
                <div class="text-center md:text-left">
                    <img src="https://lindungihutan.com/public/carbon-calculator/img/section2.svg" alt="Eco City"
                        class="mx-auto md:mr-auto w-full max-w-md">
                </div>
                <div>
                    <h2 class="text-2xl font-bold mb-4">Langkah Awal untuk Berkontribusi</h2>
                    <p class="text-gray-600">Naima hadir sebagai solusi digital... operasional yang lebih
                        berkelanjutan.</p>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-green-100 mt-auto">
            <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 px-4 py-10">
                <div>
                    <img src="/images/ns-longl-color.png" alt="Naima Sustainability" class="logo mb-4">
                    <p class="text-sm text-gray-700">Naima Sustainability menawarkan empat kategori layanan...</p>
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
                        <a href="#" class="text-gray-700 hover:text-green-600">LinkedIn</a>
                        <a href="#" class="text-gray-700 hover:text-green-600">Instagram</a>
                        <a href="#" class="text-gray-700 hover:text-green-600">Facebook</a>
                    </div>
                </div>
            </div>
            <div class="text-center text-sm text-gray-600 pb-4">© 2025 Naima. All Rights Reserved</div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const toggle = document.getElementById('menu-toggle');
        const menu = document.getElementById('mobile-menu');
        toggle.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>
</body>

</html>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Project\Agile_D4\Src\Backend\Bussiness-travel\resources\views/home.blade.php ENDPATH**/ ?>