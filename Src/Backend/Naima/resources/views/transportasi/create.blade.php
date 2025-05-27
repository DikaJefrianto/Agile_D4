@extends('layouts.main')

@section('title', 'Tambah Transportasi')

@section('content')
<style>
    .card-custom {
        max-width: 600px;
        margin: 50px auto;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        background: linear-gradient(180deg, #ffffff 0%, #f9f9f9 100%);
        overflow: hidden;
    }

    .card-header-custom {
        background: #0d6efd;
        color: #fff;
        padding: 24px;
        font-size: 1.5rem;
        font-weight: bold;
        text-align: center;
    }

    .form-label {
        font-weight: 600;
        color: #333;
    }

    .form-control,
    .form-select {
        border-radius: 8px;
        border: 1px solid #ced4da;
        padding: 10px 14px;
        transition: 0.3s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.25);
    }

    .btn-custom {
        background-color: #198754;
        border: none;
        font-weight: 600;
        padding: 10px 24px;
        border-radius: 8px;
        transition: background 0.3s ease;
    }

    .btn-custom:hover {
        background-color: #157347;
    }

    .btn-secondary-custom {
        background-color: #6c757d;
        border: none;
        font-weight: 600;
        padding: 10px 24px;
        border-radius: 8px;
        transition: background 0.3s ease;
    }

    .btn-secondary-custom:hover {
        background-color: #565e64;
    }

    .form-icon {
        margin-right: 8px;
    }
</style>

<div class="card card-custom">
    <div class="card-header card-header-custom">
        Tambah Transportasi
    </div>
    <div class="card-body p-4">
        <form action="{{ route('transportasi.store') }}" method="POST">
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
                <label for="jenis" class="form-label">Jenis Kendaraan</label>
                <input type="text" name="jenis" id="jenis" class="form-control" placeholder="Contoh: Mobil, Kapal, Pesawat" required>
            </div>

            <div class="mb-3">
                <label for="factor_emisi" class="form-label">Faktor Emisi (kg CO₂e)</label>
                <input type="number" name="factor_emisi" id="factor_emisi" class="form-control" step="0.0001" placeholder="Contoh: 0.000015" required>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('transportasi.index') }}" class="btn btn-secondary-custom">
                    ← Kembali
                </a>
                <button type="submit" class="btn btn-custom">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
