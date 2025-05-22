@extends('layouts.app')

@section('title', 'Manajemen Strategi')
@section('page_title', 'Manajemen Strategi')

@section('content')

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Daftar Strategi</h3>
        <a href="{{ route('strategi.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Strategi
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-success text-center">
                <tr>
                    <th>No</th>
                    <th>Nama Program</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Dokumen</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($strategis as $index => $strategi)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $strategi->nama_program }}</td>
                        <td>{{ $strategi->deskripsi }}</td>
                        <td class="text-center">{{ ucfirst($strategi->status) }}</td>
                        <td class="text-center">
                            @if($strategi->dokumen)
                                <a href="{{ asset('storage/' . $strategi->dokumen) }}" target="_blank">Lihat</a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('strategi.edit', $strategi->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('strategi.destroy', $strategi->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus strategi ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada strategi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
