@extends('layouts.dashboard')

@section('title', 'Perhitungan')

@section('content')
<div class="container-fluid py-4">

  {{-- Header --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-success">Perhitungan Jejak Karbon</h3>
  </div>

  {{-- Table --}}
  <div class="card shadow-sm">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
          <thead class="table-light text-center">
            <tr>
              <th>No</th>
              <th>Metode</th>
              <th>Kategori</th>
              <th>Jenis</th>
              <th>Nilai Input</th>
              <th>Jumlah Orang</th>
              <th>Hasil Emisi (kg CO₂e)</th>
              <th>Tanggal</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($perhitungan as $item)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center text-capitalize">
                  @switch($item->metode)
                    @case('bahan_bakar') Fuel-Based @break
                    @case('jarak') Distance-Based @break
                    @case('biaya') Expense-Based @break
                    @default {{ $item->metode }}
                  @endswitch
                </td>
                <td class="text-center">{{ ucfirst($item->kategori) }}</td>
                <td class="text-center">{{ ucfirst($item->jenis) }}</td>
                <td class="text-center">{{ $item->nilai_input }}</td>
                <td class="text-center">{{ $item->jumlah_orang ?? '-' }}</td>
                <td class="text-center">{{ number_format($item->hasil_emisi, 2) }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                <td class="text-center">
                  <a href="{{ route('perhitungan.edit', $item->id) }}" class="btn btn-sm btn-warning">
                    <i class="bi bi-pencil-fill"></i>
                  </a>
                  <form action="{{ route('perhitungan.destroy', $item->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                      <i class="bi bi-trash-fill"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="9" class="text-center text-muted py-4">
                  Belum ada data perhitungan.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      <div class="d-flex justify-content-center">
        {{ $perhitungan->links() }}
      </div>
    </div>
  </div>
</div>
@endsection
