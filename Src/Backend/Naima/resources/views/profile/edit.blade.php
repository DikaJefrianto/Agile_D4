@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="container mt-4">
    <h1>Edit Profil</h1>

    @if (session('status') === 'profile-updated')
        <div class="alert alert-success">
            Profil berhasil diperbarui.
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form untuk mengedit informasi profil -->
    <form action="{{ route('profile.update') }}" method="POST" class="mb-4" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto Profil</label>
            <input type="file" name="foto" id="foto" class="form-control">
            @if ($user->foto)
                <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil" class="mt-3" style="width: 100px; height: 100px; object-fit: cover;">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>

    <!-- Form untuk mengedit password -->
    <form action="{{ route('profile.update-password') }}" method="POST">
        @csrf
        @method('PATCH')

        <h2 class="mb-3">Ubah Password</h2>

        <div class="mb-3">
            <label for="current_password" class="form-label">Password Saat Ini</label>
            <input type="password" name="current_password" id="current_password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password Baru</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Ubah Password</button>
    </form>
</div>
@endsection
