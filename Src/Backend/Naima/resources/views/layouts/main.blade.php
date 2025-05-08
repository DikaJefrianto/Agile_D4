<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Naima Sustainbility')</title>

    <!-- Link CSS Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Link CSS Custom (jika ada) -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-white">

    @include('layouts.sidebar')
    <!-- Header -->
    @include('layouts.header')

    {{-- @include('layouts.sidebar') --}} <!-- Uncomment jika ingin sidebar aktif -->

    {{-- <main class="d-flex">
        <div class="container mt-4"> <!-- added margin-top to create space -->
            @yield('content')
        </div>
    </main> --}}


    <!-- Footer (optional) -->
    {{-- @include('layouts.footer') <!-- Jika Anda ingin menambahkan footer --> --}}

    <!-- Script JS Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
