@extends('layouts.dashboard')

@section('title', 'Tambah Bahan Bakar')

@section('content')
<style>
    .card-custom {
        max-width: 600px;
        margin: 40px auto;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        background: #ffffff;
    }

    .card-header-custom {
        background-color: #007bff;
        color: white;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        padding: 20px;
        text-align: center;
    }

    .form-label {
        font-weight: 600;
    }

    .btn-custom {
        background-color: #28a745;
        color: white;
        font-weight: bold;
        transition: 0.3s ease;
    }

    .btn-custom:hover {
        background-color: #218838;
    }

    .btn-secondary-custom {
        background-color: #6c757d;
        color: white;
        transition: 0.3s ease;
    }

    .btn-secondary-custom:hover {
        background-color: #5a6268;
    }

</style>

<div class="card card-custom">
    <div class="card-header card-header-custom">
        <h4>Form Tambah Bahan Bakar</h4>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('BahanBakar.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori Transportasi</label>
                <select name="kategori" id="kategori" class="form-select" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="darat">Darat</option>
                    <option value="laut">Laut</option>
                    <option value="udara">Udara</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="jenis" class="form-label">Jenis Bahan Bakar</label>
                <input type="text" name="Bahan_bakar" id="Bahan_bakar" class="form-control" placeholder="Contoh: bensin,avtur,batu bara" required>
            </div>

            <div class="mb-3">
                <label for="factor_emisi" class="form-label">Faktor Emisi (kg CO₂e)</label>
                <input type="number" name="factorEmisi" id="factorEmisi" class="form-control" step="0.0001" placeholder="Contoh: 0,45" required>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('BahanBakar.index') }}" class="btn btn-secondary-custom">← Kembali</a>
                <button type="submit" class="btn btn-custom">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
