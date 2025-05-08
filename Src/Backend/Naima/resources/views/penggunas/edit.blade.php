@extends('layouts.main')

@section('title', 'Edit Pengguna')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Edit Data Pengguna</h1>

    {{-- Menampilkan notifikasi error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Ada kesalahan dalam input:<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Edit Pengguna --}}
    <form action="{{ route('penggunas.update', $pengguna->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="perusahaan_id" class="form-label">Perusahaan</label>
            <select name="perusahaan_id" class="form-select" required>
                @foreach ($perusahaans as $perusahaan)
                    <option value="{{ $perusahaan->id }}" {{ $pengguna->perusahaan_id == $perusahaan->id ? 'selected' : '' }}>
                        {{ $perusahaan->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $pengguna->nama_lengkap) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $pengguna->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password (Kosongkan jika tidak diubah)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" class="form-select" required>
                <option value="admin" {{ $pengguna->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="manajer" {{ $pengguna->role == 'manajer' ? 'selected' : '' }}>Manajer</option>
                <option value="karyawan" {{ $pengguna->role == 'karyawan' ? 'selected' : '' }}>karyawan</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="no_telp" class="form-label">No. Telepon</label>
            <input type="text" name="no_telp" class="form-control" value="{{ old('no_telp', $pengguna->no_telp) }}">
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto (Opsional)</label><br>
            @if ($pengguna->foto)
                <img src="{{ asset('storage/' . $pengguna->foto) }}" width="100" class="mb-2" alt="Foto Pengguna">
            @endif
            <input type="file" name="foto" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('penggunas.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
