@extends('layouts.main')

@section('content')
    <div class="container">
        <h2 class="mb-4">Perhitungan Emisi</h2>

        {{-- Pilihan metode --}}
        <form action="{{ route('perhitungan.create') }}" method="GET" class="mb-4">
            <div class="mb-3">
                <label for="metode" class="form-label">Pilih Metode Perhitungan Emisi</label>
                <select name="metode" id="metode" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Pilih Metode --</option>
                    <option value="bahan_bakar" {{ request('metode') == 'bahan_bakar' ? 'selected' : '' }}>Bahan Bakar
                    </option>
                    <option value="jarak_tempuh" {{ request('metode') == 'jarak_tempuh' ? 'selected' : '' }}>Jarak Tempuh
                    </option>
                    <option value="biaya" {{ request('metode') == 'biaya' ? 'selected' : '' }}>Biaya</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori Transportasi</label>
                <select name="kategori" id="kategori" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Darat" {{ request('kategori') == 'Darat' ? 'selected' : '' }}>Darat</option>
                    <option value="Laut" {{ request('kategori') == 'Laut' ? 'selected' : '' }}>Laut</option>
                    <option value="Udara" {{ request('kategori') == 'Udara' ? 'selected' : '' }}>Udara</option>
                </select>
            </div>
        </form>


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

        <form action="{{ route('perhitungan.store') }}" method="POST">
            @csrf
            <input type="hidden" name="kategori" value="{{ $kategori }}">
            <input type="hidden" name="metode" value="{{ $metode }}">

            @if ($metode == 'bahan_bakar')
                @include('perhitungan.partials.form_bahan_bakar', ['bahanBakar' => $bahanBakar])
            @elseif($metode == 'jarak_tempuh')
                @include('perhitungan.partials.form_jarak', ['transportasi' => $jenis])
            @elseif($metode == 'biaya')
                @include('perhitungan.partials.form_biaya', ['biaya' => $jenisKendaraan])
            @else
                <p class="text-muted">Silakan pilih metode dan kategori terlebih dahulu.</p>
            @endif

            @if ($metode)
                <div class="mb-3">
                    <label for="jumlah_orang" class="form-label">Jumlah Orang</label>
                    <input type="number" name="jumlah_orang" class="form-control" min="1" value="1">
                </div>

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control">
                </div>

                <button type="submit" class="btn btn-success">Hitung & Simpan</button>
            @endif
        </form>

    </div>
@endsection
