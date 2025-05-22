@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Strategi</h2>

    <form action="{{ route('strategi.update', $strategi->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-2">
            <label>Nama Program</label>
            <input name="nama_program" class="form-control" value="{{ old('nama_program', $strategi->nama_program) }}" required>
        </div>

        <div class="mb-2">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi', $strategi->deskripsi) }}</textarea>
        </div>

        <div class="mb-2">
            <label>Dokumen Saat Ini</label><br>
            @if ($strategi->dokumen)
                <a href="{{ asset('storage/' . $strategi->dokumen) }}" target="_blank">Lihat Dokumen</a>
            @else
                <span class="text-muted">Tidak ada dokumen</span>
            @endif
        </div>

        <div class="mb-2">
            <label>Ganti Dokumen (Opsional)</label>
            <input type="file" name="dokumen" class="form-control">
        </div>

        <div class="mb-2">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="draf" {{ $strategi->status == 'draf' ? 'selected' : '' }}>Draf</option>
                <option value="aktif" {{ $strategi->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="selesai" {{ $strategi->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>

        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
