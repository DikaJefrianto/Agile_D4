@extends('layouts.main')

@section('content')
    <div class="container">
        <h2 class="mb-4">Perhitungan Emisi</h2>

        {{-- FORM PEMILIHAN METODE --}}
        <form action="{{ route('perhitungan.create') }}" method="GET" class="mb-4">
            <h4 class="text-center mb-3">Pilih Metode Perhitungan Emisi</h4>
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <button type="submit" name="metode" value="bahan_bakar"
                        class="card border-success text-center p-3 h-100 {{ request('metode') == 'bahan_bakar' ? 'border-3' : '' }}"
                        style="cursor:pointer;">
                        <div class="card-body">
                            <h5 class="card-title text-success"><i class="bi bi-fuel-pump"></i> Bahan Bakar</h5>
                            <p class="card-text text-muted">Gunakan data konsumsi bahan bakar.</p>
                        </div>
                    </button>
                </div>
                <div class="col-md-3">
                    <button type="submit" name="metode" value="jarak_tempuh"
                        class="card border-primary text-center p-3 h-100 {{ request('metode') == 'jarak_tempuh' ? 'border-3' : '' }}"
                        style="cursor:pointer;">
                        <div class="card-body">
                            <h5 class="card-title text-primary"><i class="bi bi-geo-alt-fill"></i> Jarak Tempuh</h5>
                            <p class="card-text text-muted">Gunakan data jarak perjalanan.</p>
                        </div>
                    </button>
                </div>
                <div class="col-md-3">
                    <button type="submit" name="metode" value="biaya"
                        class="card border-warning text-center p-3 h-100 {{ request('metode') == 'biaya' ? 'border-3' : '' }}"
                        style="cursor:pointer;">
                        <div class="card-body">
                            <h5 class="card-title text-warning"><i class="bi bi-cash-stack"></i> Biaya</h5>
                            <p class="card-text text-muted">Gunakan data biaya perjalanan.</p>
                        </div>
                    </button>
                </div>
            </div>
        </form>

        {{-- FORM PEMILIHAN KATEGORI --}}
        @if ($metode)
        <form action="{{ route('perhitungan.create') }}" method="GET" class="mb-4">
            <input type="hidden" name="metode" value="{{ $metode }}">
            <h4 class="text-center">Pilih Kategori Transportasi</h4>
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <button type="submit" name="kategori" value="Darat"
                        class="card border border-3 text-center p-3 h-100 {{ request('kategori') == 'Darat' ? 'border-success' : 'border-secondary' }}"
                        style="cursor:pointer;">
                        <div class="card-body">
                            <h5 class="card-title text-success"><i class="bi bi-truck"></i> Darat</h5>
                            <p class="card-text text-muted">Mobil, motor, kereta dan sejenisnya.</p>
                        </div>
                    </button>
                </div>
                <div class="col-md-3">
                    <button type="submit" name="kategori" value="Laut"
                        class="card border border-3 text-center p-3 h-100 {{ request('kategori') == 'Laut' ? 'border-primary' : 'border-secondary' }}"
                        style="cursor:pointer;">
                        <div class="card-body">
                            <h5 class="card-title text-primary"><i class="bi bi-ship"></i> Laut</h5>
                            <p class="card-text text-muted">Kapal, ferry, dan jenis kapal lainnya</p>
                        </div>
                    </button>
                </div>
                <div class="col-md-3">
                    <button type="submit" name="kategori" value="Udara"
                        class="card border border-3 text-center p-3 h-100 {{ request('kategori') == 'Udara' ? 'border-warning' : 'border-secondary' }}"
                        style="cursor:pointer;">
                        <div class="card-body">
                            <h5 class="card-title text-warning"><i class="bi bi-airplane-engines"></i> Udara</h5>
                            <p class="card-text text-muted">Pesawat, Helikopter dan jenisnya Pesawat terbang lainnya.</p>
                        </div>
                    </button>
                </div>
            </div>
        </form>
        @endif

        {{-- TAMPILKAN FORM PERHITUNGAN --}}
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

        @if ($metode && $kategori)
        <form action="{{ route('perhitungan.store') }}" method="POST">
            @csrf
            <input type="hidden" name="kategori" value="{{ $kategori }}">
            <input type="hidden" name="metode" value="{{ $metode }}">

            @if ($metode == 'bahan_bakar')
                @include('perhitungan.partials.form_bahan_bakar', ['bahanBakar' => $bahanBakar])
            @elseif ($metode == 'jarak_tempuh')
                @include('perhitungan.partials.form_jarak', ['transportasi' => $jenis])
            @elseif ($metode == 'biaya')
                @include('perhitungan.partials.form_biaya', ['biaya' => $jenisKendaraan])
            @endif

            <div class="mb-3">
                <label for="jumlah_orang" class="form-label">Jumlah Orang</label>
                <input type="number" name="jumlah_orang" class="form-control" min="1" value="1">
            </div>

            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Hitung & Simpan</button>
        </form>
        @endif

    </div>
@endsection
