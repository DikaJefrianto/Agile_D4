@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Daftar Karyawan</h1>
        <a href="{{ route('karyawans.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Karyawan
        </a>
    </div>

    <form method="GET" action="{{ route('perusahaans.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari perusahaan...">
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-success text-center">
                <tr>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>No Telepon</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($karyawans as $karyawan)
                    <tr>
                        <td>{{ $karyawan->nama_lengkap }}</td>
                        <td>{{ $karyawan->email }}</td>
                        <td>{{ $karyawan->no_telp }}</td>
                        <td>
                            @if ($karyawan->foto)
                                <img src="{{ asset('storage/' . $karyawan->foto) }}" alt="Foto Karyawan" width="50">
                            @else
                                <img src="{{ asset('storage/default.png') }}" alt="Foto Karyawan" width="50">
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('karyawans.edit', $karyawan->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('karyawans.destroy', $karyawan->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $karyawans->links('pagination::bootstrap-5') }}
<!-- Menampilkan pagination -->
</div>
@endsection
