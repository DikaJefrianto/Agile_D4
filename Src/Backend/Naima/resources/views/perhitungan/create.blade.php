@extends('layouts.main')

@section('content')
    <div class="container">
        <h2 class="mb-4">Perhitungan Emisi</h2>

        {{-- Pilihan metode --}}
        <form action="{{ route('perhitungan.create') }}" method="GET" class="mb-4">
            <div class="mb-3">
                <h4 class="row justify-content-center">Pilih Metode Perhitungan Emisi yang kamu ketahui</h4>
                <div class="row justify-content-center">
                    <div class="col-md-3">
                        <button type="submit" name="metode" value="bahan_bakar" class="card border-success text-center p-3 h-100" style="cursor:pointer;">
                            <div class="card-body">
                                <h5 class="card-title text-success"><i class="bi bi-fuel-pump"></i> Bahan Bakar</h5>
                                <p class="card-text text-muted">Gunakan data konsumsi bahan bakar.</p>
                            </div>
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" name="metode" value="jarak_tempuh" class="card border-primary text-center p-3 h-100" style="cursor:pointer;">
                            <div class="card-body">
                                <h5 class="card-title text-primary"><i class="bi bi-geo-alt-fill"></i> Jarak Tempuh</h5>
                                <p class="card-text text-muted">Gunakan data jarak perjalanan.</p>
                            </div>
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" name="metode" value="biaya" class="card border-warning text-center p-3 h-100" style="cursor:pointer;">
                            <div class="card-body">
                                <h5 class="card-title text-warning"><i class="bi bi-cash-stack"></i> Biaya</h5>
                                <p class="card-text text-muted">Gunakan data biaya perjalanan.</p>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
            

            <div class="mb-3">
                <h4 class="row justify-content-center">Kategori Transportasi yang anda Gunakan</h4>
                <div class="row justify-content-center">
                    <div class="col-md-3">
                        <button type="submit" name="kategori" value="Darat"
                            class="card border-success text-center p-3 h-100 {{ request('kategori') == 'Darat' ? 'border-3 border-success' : '' }}"
                            style="cursor:pointer;">
                            <div class="card-body">
                                <h5 class="card-title text-success"><i class="bi bi-truck"></i> Darat</h5>
                                <p class="card-text text-muted">Transportasi darat seperti mobil, motor.</p>
                            </div>
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" name="kategori" value="Laut"
                            class="card border-primary text-center p-3 h-100 {{ request('kategori') == 'Laut' ? 'border-3 border-primary' : '' }}"
                            style="cursor:pointer;">
                            <div class="card-body">
                                <h5 class="card-title text-primary"><i class="bi bi-ship"></i> Laut</h5>
                                <p class="card-text text-muted">Transportasi laut seperti kapal, ferry.</p>
                            </div>
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" name="kategori" value="Udara"
                            class="card border-warning text-center p-3 h-100 {{ request('kategori') == 'Udara' ? 'border-3 border-warning' : '' }}"
                            style="cursor:pointer;">
                            <div class="card-body">
                                <h5 class="card-title text-warning"><i class="bi bi-airplane-engines"></i> Udara</h5>
                                <p class="card-text text-muted">Transportasi udara seperti pesawat.</p>
                            </div>
                        </button>
                    </div>
                </div>
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
