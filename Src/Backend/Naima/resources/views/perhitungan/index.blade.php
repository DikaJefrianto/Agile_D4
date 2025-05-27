@extends('layouts.app')

@section('title', 'Perhitungan')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-success mb-0">
            <i class="bi bi-graph-up-arrow me-2"></i>Perhitungan Jejak Karbon
        </h3>
        <a href="{{ route('perhitungan.create') }}" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Data
        </a>
    </div>

    {{-- Tabel --}}
    <div class="card border-0 shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-success text-center">
                        <tr>
                            <th>No</th>
                            <th>Metode</th>
                            <th>Kategori</th>
                            <th>Jenis</th>
                            <th>Nilai Input</th>
                            <th>Jumlah Orang</th>
                            <th>Hasil Emisi <small>(kg CO₂e)</small></th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($perhitungan as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">
                                    @switch($item->metode)
                                        @case('bahan_bakar')
                                            <span >Bahan Bakar</span>
                                            @break
                                        @case('jarak')
                                        @case('jarak_tempuh')
                                            <span >Jarak Tempuh</span>
                                            @break
                                        @case('biaya')
                                            <span >Biaya</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ ucfirst($item->metode) }}</span>
                                    @endswitch
                                </td>
                                <td class="text-center">{{ ucfirst($item->kategori) }}</td>
                                <td class="text-center">
                                    @if ($item->metode === 'bahan_bakar' && $item->bahanBakar)
                                        {{ $item->bahanBakar->Bahan_bakar }}
                                    @elseif ($item->metode === 'jarak' || $item->metode === 'jarak_tempuh')
                                        {{ $item->transportasi->jenis ?? '-' }}
                                    @elseif ($item->metode === 'biaya')
                                        {{ $item->biaya->jenisKendaraan ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center">{{ $item->nilai_input ?? '-' }}</td>
                                <td class="text-center">{{ $item->jumlah_orang ?? '-' }}</td>
                                <td class="text-center text-success fw-bold">
                                    {{ number_format($item->hasil_emisi, 2) }}
                                </td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}
                                </td>
                                <td class="text-center">
                                    {{-- <a href="{{ route('perhitungan.edit', $item->id) }}" class="btn btn-warning btn-sm me-1" title="Edit">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a> --}}
                                    <form action="{{ route('perhitungan.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    <em>Belum ada data perhitungan yang tersedia.</em>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3 d-flex justify-content-center">
                {{ $perhitungan->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
