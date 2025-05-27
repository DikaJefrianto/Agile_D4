@extends('layouts.main')
@section('title')
Edit Data Transportasi
@endsection
@section('content')

<style>
    .form-container {
        max-width: 500px;
        margin: 50px auto;
        padding: 20px;
        background: #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .form-container h1 {
        text-align: center;
        color: #333;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    .form-group input:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    button {
        width: 100%;
        padding: 10px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s;
    }

    button:hover {
        background: #0056b3;
    }

    .back-link {
        display: block;
        text-align: center;
        margin-top: 15px;
        text-decoration: none;
        color: #007bff;
    }

    .back-link:hover {
        text-decoration: underline;
    }
</style>

<div class="form-container">
    <h1>Edit Data Transportasi</h1>

    @if(session('error'))
        <p style="color: red; text-align: center;">{{ session('error') }}</p>
    @endif

    <form action="{{ route('transportasi.update', $transportasi->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="kategori">Kategori Transportasi:</label>
            <input type="text" id="kategori" name="kategori" value="{{ $transportasi->kategori }}" required>
        </div>

        <div class="form-group">
            <label for="jenis">Jenis Kendaraan:</label>
            <input type="text" id="jenis" name="jenis" value="{{ $transportasi->jenis }}" required>
        </div>

        <div class="form-group">
            <label for="factor_emisi">Faktor Emisi (kg CO₂e):</label>
            <input type="number" step="0.0001" id="factor_emisi" name="factor_emisi" value="{{ $transportasi->factor_emisi }}" required>
        </div>

        <button type="submit">Simpan Perubahan</button>
    </form>

    <a href="{{ route('transportasi.index') }}" class="back-link">Kembali ke Daftar Transportasi</a>
</div>

@endsection
