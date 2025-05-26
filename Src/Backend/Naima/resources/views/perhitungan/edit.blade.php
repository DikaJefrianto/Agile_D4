@extends('layouts.main')

@section('title', 'Edit Perhitungan Emisi')

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

        {{-- Hidden input --}}
        <input type="hidden" name="metode" value="{{ $perhitungan->metode }}">
        <input type="hidden" name="kategori" value="{{ $perhitungan->kategori }}">

        {{-- Tampilkan metode --}}
        <div class="mb-3">
            <h5>Metode Perhitungan Emisi yang Dipilih</h5>
            <div class="row">
                @php $metodes = ['bahan_bakar' => 'Bahan_Bakar', 'jarak_tempuh' => 'Jarak Tempuh', 'biaya' => 'Biaya']; @endphp
                @foreach($metodes as $key => $label)
                    <div class="col-md-4">
                        <div class="card text-center border-{{ $perhitungan->metode == $key ? 'success border-3' : 'secondary' }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $label }}</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Kategori --}}
        <div class="mb-3">
            <h5>Kategori Transportasi</h5>
            <div class="row">
                @php $kategoris = ['Darat', 'Laut', 'Udara']; @endphp
                @foreach($kategoris as $kat)
                    <div class="col-md-4">
                        <div class="card text-center border-{{ $perhitungan->kategori == $kat ? 'success border-3' : 'secondary' }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $kat }}</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Form input sesuai metode --}}
        @if ($perhitungan->metode == 'bahan_bakar')
            @include('perhitungan.partialss.form_bahan_bakar', [
                'bahanBakar' => $bahanBakar,
                'edit' => true,
                'data' => $perhitungan
            ])
        @elseif($perhitungan->metode == 'jarak_tempuh')
            @include('perhitungan.partials.form_jarak', [
                'transportasi' => $jenis,
                'edit' => true,
                'data' => $perhitungan
            ])
        @elseif($perhitungan->metode == 'biaya')
            @include('perhitungan.partials.form_biaya', [
                'biaya' => $jenisKendaraan,
                'edit' => true,
                'data' => $perhitungan
            ])
        @endif

        {{-- Tambahan input --}}
        <div class="mb-3">
            <label for="jumlah_orang" class="form-label">Jumlah Orang</label>
            <input type="number" name="jumlah_orang" class="form-control" min="1"
                value="{{ old('jumlah_orang', $perhitungan->jumlah_orang) }}">
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control"
                value="{{ old('tanggal', \Carbon\Carbon::parse($perhitungan->tanggal)->format('Y-m-d')) }}">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('perhitungan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
