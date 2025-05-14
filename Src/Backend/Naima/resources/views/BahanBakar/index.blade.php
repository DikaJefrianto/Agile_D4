@extends('layouts.dashboard')

@section('title', 'Data Bahan Bakar')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Daftar Bahan Bakar</h3>

    <a href="{{ route('BahanBakar.create') }}" class="btn btn-success mb-3">
        Tambah Bahan Bakar
    </a>
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Jenis Bahan Bakar</th>
                        <th>Faktor Emisi (kg CO₂e)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bahan_bakars as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-capitalize">{{ $item->kategori }}</td>
                            <td>{{ $item->Bahan_bakar }}</td>
                            <td>{{ $item->factorEmisi }}</td>
                            <td>
                                <a href="{{ route('BahanBakar.edit', $item->id) }}" class="btn btn-sm btn-warning me-2">Edit</a>
                                <form action="{{ route('BahanBakar.destroy', $item->id) }}" method="POST" style="display:inline;">
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
