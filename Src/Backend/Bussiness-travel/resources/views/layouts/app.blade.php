<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    {{-- Favicon --}}
    <link rel="icon" href="{{ config('settings.site_favicon') ?? asset('favicon.ico') }}" type="image/x-icon">

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Bootstrap CSS CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    {{-- Font Awesome CSS CDN (Untuk ikon-ikon) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    {{-- AOS (Animate On Scroll) CSS CDN --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- Vite Assets (jika Anda menggunakan Vite) --}}
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    {{-- STACK UNTUK CUSTOM STYLES DARI CHILD VIEWS --}}
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">

    @yield('content')

    {{-- Bootstrap JS Bundle CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- AOS (Animate On Scroll) JS CDN --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000, // Durasi animasi dalam ms
            once: true,    // Animasi hanya terjadi sekali saat elemen masuk viewport
        });
    </script>

    {{-- STACK UNTUK CUSTOM SCRIPTS DARI CHILD VIEWS --}}
    @stack('scripts')
</body>
</html>
