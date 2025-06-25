<<<<<<< HEAD
<!doctype html>
=======
<!DOCTYPE html>
>>>>>>> 50d7a814b63839650b92a2e7431ae57ce34fd844
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<<<<<<< HEAD

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Naima Sustainbility') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
{{-- <body>
    {{-- <div id="app"> --}}
        {{-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm"> --}}
            {{-- <div class="container">
                {{-- <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a> --}}
                {{-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button> --}}

                {{-- <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto"></ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div> --}}
            {{-- </div> --}}
        {{-- </nav> --}}

        {{-- <main class="py-4">
            @yield('content')
        </main> --}}
    {{-- </div> --}}
{{-- </body> --}}
=======
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
>>>>>>> 50d7a814b63839650b92a2e7431ae57ce34fd844
</html>
