@extends('layouts.main')

@section('title')
Tambah Perusahaan
@endsection

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Tambah Data Perusahaan</h1>

    {{-- Menampilkan notifikasi jika ada error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Ada kesalahan dalam input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Tambah Perusahaan --}}
    <form action="{{ route('perusahaans.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Perusahaan</label>
            <input type="text" name="nama" class="form-control" placeholder="Nama perusahaan" value="{{ old('nama') }}">
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Username" value="{{ old('username') }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Perusahaan</label>
            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Password">
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" placeholder="Alamat">{{ old('alamat') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control" placeholder="Keterangan">{{ old('keterangan') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('perusahaans.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
