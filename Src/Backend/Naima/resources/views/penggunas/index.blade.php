@extends('layouts.main')

@section('title', 'Manajemen Pengguna')

@section('page_title', 'Manajemen Pengguna')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Daftar Pengguna</h3>
        <a href="{{ route('penggunas.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Pengguna
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle text-center" style="min-width: 1000px;">
            <thead class="table-success">
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>No Telp</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($penggunas as $index => $pengguna)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        @if($pengguna->foto)
                            <img src="{{ asset('storage/' . $pengguna->foto) }}" alt="Foto" width="60" height="60" class="rounded-circle">
                        @else
                            <span class="text-muted">Tidak Ada</span>
                        @endif
                    </td>
                    <td class="text-break">{{ $pengguna->nama_lengkap }}</td>
                    <td class="text-break">{{ $pengguna->email }}</td>
                    <td>{{ ucfirst($pengguna->role) }}</td>
                    <td>{{ $pengguna->no_telp ?? '-' }}</td>
                    <td>
                        <a href="{{ route('penggunas.edit', $pengguna->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('penggunas.destroy', $pengguna->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Tidak ada data pengguna.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
