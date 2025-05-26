@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-12 text-center">
            <h2 class="text-success">Dashboard Jejak Karbon Anda</h2>
            <p class="text-muted">Pantau dan kelola data emisi perjalanan bisnis Anda secara interaktif.</p>
        </div>
    </div>

    {{-- Ringkasan Total Emisi --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-success shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title text-success">Total Emisi Anda</h5>
                    <h3>{{ number_format($totalEmisi, 2) }} <small class="text-muted">kg CO₂e</small></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-primary shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title text-primary">Jumlah Perjalanan</h5>
                    <h3>{{ $jumlahPerjalanan }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-info shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title text-info">Rata-rata Emisi</h5>
                    <h3>{{ number_format($rataRataEmisi, 2) }} <small class="text-muted">kg CO₂e</small></h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik Emisi per Bulan --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-success text-white">
            Grafik Emisi per Bulan
        </div>
        <div class="card-body">
            <canvas id="chartEmisi"></canvas>
        </div>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartEmisi');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($bulan) !!},
            datasets: [{
                label: 'Emisi per Bulan (kg CO₂e)',
                data: {!! json_encode($totalEmisiBulanan) !!},
                backgroundColor: 'rgba(40, 167, 69, 0.2)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Emisi (kg CO₂e)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Bulan'
                    }
                }
            }
        }
    });
</script>
@endsection
