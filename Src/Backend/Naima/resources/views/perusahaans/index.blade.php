@extends('layouts.app') <!-- Pastikan ini sesuai dengan file layout utamamu -->

@section('title', 'Manajemen Perusahaan')

@section('page_title', 'Manajemen Perusahaan')

@section('content')

<div class="container-fluid mt-2">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Daftar Perusahaan</h3>
        <a href="{{ route('perusahaans.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Perusahaan
        </a>
    </div>

    <form method="GET" action="{{ route('perusahaans.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari Karyawan...">
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
    </form>

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
                        <td>
                            <a href="{{ route('perusahaans.edit', $perusahaan->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('perusahaans.destroy', $perusahaan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
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
{{ $perusahaans->links('pagination::bootstrap-5') }}


@endsection
