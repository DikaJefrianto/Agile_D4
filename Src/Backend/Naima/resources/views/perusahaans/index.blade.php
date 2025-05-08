@extends('layouts.main') <!-- Pastikan ini sesuai dengan file layout utamamu -->

@section('title', 'Manajemen Perusahaan')

@section('page_title', 'Manajemen Perusahaan')

@section('content')

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Daftar Perusahaan</h3>
        <a href="{{ route('perusahaans.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Perusahaan
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-success text-center">
                <tr>
                    <th>No</th>
                    <th>Nama Perusahaan</th>
                    <th>Alamat</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($perusahaans as $index => $perusahaan)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $perusahaan->nama }}</td>
                        <td>{{ $perusahaan->alamat }}</td>
                        <td>{{ $perusahaan->email }}</td>
                        <td>{{ $perusahaan->alamat }}</td>
                        <td>{{ $perusahaan->keterangan }}</td>
                        <td class="text-center">
                            <a href="{{ route('perusahaans.edit', $perusahaan->id) }}" class="btn btn-sm btn-warning me-1">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('perusahaans.destroy', $perusahaan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data perusahaan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
