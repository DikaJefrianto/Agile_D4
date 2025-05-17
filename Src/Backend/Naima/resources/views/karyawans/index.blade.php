@extends('layouts.app') <!-- Pastikan ini sesuai dengan file layout utamamu -->

@section('title', 'Manajemen Karyawan')

@section('page_title', 'Manajemen Karyawan')

@section('content')

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Daftar Karyawan</h3>
        <a href="{{ route('karyawans.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Karyawan
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-success text-center">
                <tr>
                    <th>No</th>
                    <th>Foto</th> <!-- Tambahkan kolom Foto -->
                    <th>Nama Karyawan</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>No. Telepon</th>
                    <th>Perusahaan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($karyawans as $index => $karyawan)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center">
                            @if ($karyawan->foto)
                                <img src="{{ asset('storage/' . $karyawan->foto) }}" alt="Foto Karyawan" class="img-thumbnail" style="width: 50px; height: 50px;">
                            @else
                                <span>-</span>
                            @endif
                        </td>
                        <td>{{ $karyawan->nama_lengkap }}</td>
                        <td>{{ $karyawan->email }}</td>
                        <td>{{ ucfirst($karyawan->role) }}</td>
                        <td>{{ $karyawan->no_telp }}</td>
                        <td>{{ $karyawan->perusahaan->nama ?? '-' }}</td> <!-- Menampilkan nama perusahaan -->
                        <td>
                            <a href="{{ route('karyawans.edit', $karyawan->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('karyawans.destroy', $karyawan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data karyawan ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada data karyawan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
