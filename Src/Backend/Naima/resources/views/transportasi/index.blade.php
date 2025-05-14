@extends('layouts.dashboard')

@section('title', 'Data Transportasi')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Daftar Transportasi</h3>

    <a href="{{ route('transportasi.create') }}" class="btn btn-success mb-3">
        Tambah Transportasi
    </a>
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Jenis</th>
                        <th>Faktor Emisi (kg CO₂e)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transportasis as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-capitalize">{{ $item->kategori }}</td>
                            <td>{{ $item->jenis }}</td>
                            <td>{{ $item->factor_emisi }}</td>
                            <td>
                                <a href="{{ route('transportasi.edit', $item->id) }}" class="btn btn-sm btn-warning me-2">Edit</a>
                                <form action="{{ route('transportasi.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-muted">Belum ada data transportasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
