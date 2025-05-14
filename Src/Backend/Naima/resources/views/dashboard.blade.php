@extends('layouts.dashboard')

@section('title', 'Beranda')

@section('content')
<div class="container-fluid py-4">
  {{-- Header --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-success">Selamat Datang,    </h3>
  </div>

  {{-- Statistik Ringkas --}}
  <div class="row">
    <div class="col-md-4 mb-3">
      <div class="card shadow-sm border-start border-success border-5">
        <div class="card-body">
          <h6 class="text-muted">Total Perhitungan</h6>
          <h3>{{ $totalPerhitungan }}</h3>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-3">
      <div class="card shadow-sm border-start border-warning border-5">
        <div class="card-body">
          <h6 class="text-muted">Total Emisi</h6>
          <h3>{{ number_format($totalEmisi, 2) }} kg CO₂e</h3>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-3">
      <div class="card shadow-sm border-start border-info border-5">
        <div class="card-body">
          <h6 class="text-muted">Metode Terbanyak</h6>
          <h4 class="text-capitalize">{{ $metodeFavorit ?? '-' }}</h4>
        </div>
      </div>
    </div>
  </div>

  {{-- Grafik Emisi (Opsional) --}}
  <div class="card shadow-sm mt-4">
    <div class="card-body">
      <h5 class="mb-4">Tren Emisi Bulanan</h5>
      <canvas id="emissionChart" height="100"></canvas>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('emissionChart').getContext('2d');
  const chart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: {!! json_encode($bulan) !!},
      datasets: [{
        label: 'Emisi (kg CO₂e)',
        data: {!! json_encode($dataEmisi) !!},
        backgroundColor: 'rgba(25, 135, 84, 0.2)',
        borderColor: 'rgba(25, 135, 84, 1)',
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
            text: 'kg CO₂e'
          }
        }
      }
    }
  });
</script>
@endsection
