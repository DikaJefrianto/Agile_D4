{{-- filepath: f:\Project\Agile_D4\Src\Backend\Naima\resources\views\auth\login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Naima Sustainability</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(to bottom, #38a169, #e2e8f0);
            font-family: 'Arial', sans-serif;
        }

        .card {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 100%;
            max-width: 400px;
        }

        .btn-primary {
            background-color: #38a169;
            color: #ffffff;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #2f855a;
        }

        .link {
            color: #319c63;
            text-decoration: none;
            font-size: 0.875rem;
        }

        .link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="card">
        <div class="text-center mb-6">
            <img src="/images/ns-longl-color.png" alt="Naima Sustainability" class="h-12 mx-auto">
            <h1 class="text-2xl font-bold text-gray-700 mt-4">Login</h1>
            <p class="text-sm text-gray-500">Masuk untuk melacak jejak karbon Anda</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                @error('email')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                @error('password')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center mb-4">
                <input id="remember_me" type="checkbox" name="remember"
                    class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                <label for="remember_me" class="ml-2 block text-sm text-gray-700">Ingat saya</label>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="link">Lupa password?</a>
                @endif
                <button type="submit" class="btn-primary">Masuk</button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-500">Belum punya akun? <a href="{{ route('register') }}" class="link">Daftar sekarang</a></p>
        </div>
    </div>
</body>
</html>
