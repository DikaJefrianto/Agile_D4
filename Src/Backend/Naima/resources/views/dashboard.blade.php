@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2>Perhitungan Emisi</h2>
        <p>Selamat datang di aplikasi Perhitungan Emisi!</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card text-white bg-primary h-100">
            <div class="card-body">
                <h5 class="card-title">Total Perhitungan</h5>
                <p class="card-text display-5">{{ $totalPerhitungan ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-white bg-success h-100">
            <div class="card-body">
                <h5 class="card-title">Total Emisi Terhitung (Kg CO2)</h5>
                <p class="card-text display-5">{{ number_format($totalEmisi ?? 0, 2) }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">  
        <div class="card text-white bg-info h-100">
            <div class="card-body">
                <h5 class="card-title">Perhitungan Terbaru</h5>
                <p class="card-text">
                    {{-- @if($lastPerhitungan)
                        {{ $lastPerhitungan->metode }} - {{ $lastPerhitungan->kategori }}<br>
                        {{ date('d M Y', strtotime($lastPerhitungan->tanggal)) }}
                    @else
                        Belum ada data
                    @endif --}}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
