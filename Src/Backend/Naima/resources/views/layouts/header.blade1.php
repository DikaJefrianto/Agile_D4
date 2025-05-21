<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Naima Sustainbility')</title>

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
            /* Biar ngga ketiban header */
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
            color: white;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 1000;
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
            /* Atas lebih gede biar konten di bawah header */
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
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Header -->
    <div class="header shadow-sm">
        <h2 class="mb-0">
            <span class="text-black">
                @yield('page_title', 'Dashboard')
            </span>

        </h2>

        <div class="d-flex align-items-center gap-3">
            <div class="input-group input-group-sm me-3 d-none d-md-flex">
                <input type="text" class="form-control" placeholder="Cari..." aria-label="Cari">
                <button class="btn btn-light" type="button"><i class="bi bi-search"></i></button>
            </div>
            <button class="btn btn-danger btn-sm" onclick="logout()">Logout</button>
            <div class="dropdown">
                <img src="https://i.pravatar.cc/35" class="rounded-circle profile-pic dropdown-toggle"
                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" alt="profile">
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="#">Pengaturan</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item text-danger" href="#">Logout</a></li>
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
