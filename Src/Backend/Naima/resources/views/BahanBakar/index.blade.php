@extends('layouts.main')

@section('title', 'Data Bahan Bakar')

@section('content')
    <div class="container py-4">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-primary mb-0">
                <i class="bi bi-fuel-pump me-2"></i>Data Bahan Bakar
            </h3>
            <a href="{{ route('BahanBakar.create') }}" class="btn btn-success shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Tambah Data
            </a>
        </div>
        {{-- Filter Kategori --}}
        <div class="mb-3">
            <div class="btn-group" role="group">
                <a href="{{ route('BahanBakar.index') }}"
                    class="btn btn-outline-primary {{ request('kategori') == '' ? 'active' : '' }}">All</a>
                <a href="{{ route('BahanBakar.index', ['kategori' => 'Darat']) }}"
                    class="btn btn-outline-primary {{ request('kategori') == 'Darat' ? 'active' : '' }}">Darat</a>
                <a href="{{ route('BahanBakar.index', ['kategori' => 'Laut']) }}"
                    class="btn btn-outline-primary {{ request('kategori') == 'Laut' ? 'active' : '' }}">Laut</a>
                <a href="{{ route('BahanBakar.index', ['kategori' => 'Udara']) }}"
                    class="btn btn-outline-primary {{ request('kategori') == 'Udara' ? 'active' : '' }}">Udara</a>
            </div>
        </div>

        {{-- Table --}}
        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Jenis Bahan Bakar</th>
                            <th>Faktor Emisi <small>(kg CO₂e)</small></th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bahan_bakars as $item)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span class="badge bg-info text-dark text-capitalize">
                                        {{ $item->kategori }}
                                    </span>
                                </td>
                                <td>{{ $item->Bahan_bakar }}</td>
                                <td class="text-success fw-semibold">{{ number_format($item->factorEmisi, 4) }}</td>
                                <td>
                                    <a href="{{ route('BahanBakar.edit', $item->id) }}" class="btn btn-sm btn-warning me-1"
                                        title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('BahanBakar.destroy', $item->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <em>Belum ada data bahan bakar.</em>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
