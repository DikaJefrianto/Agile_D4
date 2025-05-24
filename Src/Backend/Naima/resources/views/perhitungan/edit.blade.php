@extends('layouts.main')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Perhitungan Emisi</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan!</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('perhitungan.update', $perhitungan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="transportasi" class="form-label">Jenis Transportasi</label>
            <input
                type="text"
                id="transportasi"
                name="transportasi"
                class="form-control @error('transportasi') is-invalid @enderror"
                value="{{ old('transportasi', $perhitungan->transportasi) }}"
                required
            >
            @error('transportasi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="bahan_bakar" class="form-label">Jenis Bahan Bakar</label>
            <input
                type="text"
                id="bahan_bakar"
                name="bahan_bakar"
                class="form-control @error('bahan_bakar') is-invalid @enderror"
                value="{{ old('bahan_bakar', $perhitungan->bahan_bakar) }}"
                required
            >
            @error('bahan_bakar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="jarak_tempuh" class="form-label">Jarak Tempuh (km)</label>
            <input
                type="number"
                step="0.01"
                id="jarak_tempuh"
                name="jarak_tempuh"
                class="form-control @error('jarak_tempuh') is-invalid @enderror"
                value="{{ old('jarak_tempuh', $perhitungan->jarak_tempuh) }}"
                required
            >
            @error('jarak_tempuh')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tanggal_perjalanan" class="form-label">Tanggal Perjalanan</label>
            <input
                type="date"
                id="tanggal_perjalanan"
                name="tanggal_perjalanan"
                class="form-control @error('tanggal_perjalanan') is-invalid @enderror"
                value="{{ old('tanggal_perjalanan', $perhitungan->tanggal_perjalanan->format('Y-m-d')) }}"
                required
            >
            @error('tanggal_perjalanan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('perhitungan.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
