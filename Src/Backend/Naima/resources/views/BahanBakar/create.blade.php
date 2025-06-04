@extends('layouts.main')

@section('title', 'Tambah Bahan Bakar')

@section('content')
<div class="container py-10">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-7">

            {{-- Notifikasi sukses --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Notifikasi error --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li class="small">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Form Tambah Bahan Bakar</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('BahanBakar.store') }}" method="POST">
                        @csrf

                        {{-- Kategori --}}
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori Transportasi</label>
                            <select name="kategori" id="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="darat" {{ old('kategori') == 'darat' ? 'selected' : '' }}>Darat</option>
                                <option value="laut" {{ old('kategori') == 'laut' ? 'selected' : '' }}>Laut</option>
                                <option value="udara" {{ old('kategori') == 'udara' ? 'selected' : '' }}>Udara</option>
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jenis Bahan Bakar --}}
                        <div class="mb-3">
                            <label for="Bahan_bakar" class="form-label">Jenis Bahan Bakar</label>
                            <input type="text" name="Bahan_bakar" id="Bahan_bakar" class="form-control @error('Bahan_bakar') is-invalid @enderror"
                                placeholder="Contoh: bensin, solar, avtur" value="{{ old('Bahan_bakar') }}" required>
                            @error('Bahan_bakar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Faktor Emisi --}}
                        <div class="mb-3">
                            <label for="factorEmisi" class="form-label">Faktor Emisi (kg CO₂e)</label>
                            <input type="number" name="factorEmisi" id="factorEmisi" class="form-control @error('factorEmisi') is-invalid @enderror"
                                placeholder="Contoh: 0.3456" step="0.0001" value="{{ old('factorEmisi') }}" required>
                            @error('factorEmisi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('BahanBakar.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left-circle"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save2"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
