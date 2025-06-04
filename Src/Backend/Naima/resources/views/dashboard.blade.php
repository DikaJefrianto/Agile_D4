@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="row row-cols-2 row-cols-md-4 g-3 mb-4">
        @if (auth()->user()->role == 'admin')
        <div class="col">
            <div class="card card-box text-center" onclick="window.location.href='{{ route('perusahaans.index') }}'">
                <i class="bi bi-buildings fs-3"></i>
                <h5 class="mt-2">Manajemen Perusahaan</h5>
            </div>
        </div>
        @endif
        @if (auth()->user()->role == 'perusahaan')

        <div class="col">
            <div class="card card-box text-center" onclick="window.location.href='{{ route('karyawans.index') }}'">
                <i class="bi bi-person fs-3"></i>
                <h5 class="mt-2">Karyawan</h5>
            </div>
        </div>
        @endif

        <div class="col">
            <div class="card card-box text-center" onclick="window.location.href='#'">
                <i class="bi bi-calculator fs-3"></i>
                <h5 class="mt-2">Perhitungan</h5>
            </div>
        </div>
        @if (auth()->user()->role == 'admin')
        <div class="col">
            <div class="card card-box text-center" onclick="window.location.href='#'">
                <i class="bi bi-list-ul fs-3"></i>
                <h5 class="mt-2">Tabel</h5>
            </div>
        </div>
        @endif
        @if (auth()->user()->role == 'admin')
        <div class="col">
            <div class="card card-box text-center" onclick="window.location.href='#'">
                <i class="bi bi-chat-left-dots fs-3"></i>
                <h5 class="mt-2">Bahan Bakar</h5>
            </div>
        </div>
        <div class="col">
            <div class="card card-box text-center" onclick="window.location.href='#'">
                <i class="bi bi-cash-coin fs-3"></i>
                <h5 class="mt-2">Manajemen Biaya</h5>
            </div>
        </div>
        @endif
        @if (auth()->user()->role == 'admin'| auth()->user()->role == 'perusahaan')
        <div class="col">
            <div class="card card-box text-center" onclick="window.location.href='{{ route('strategi.index') }}'">
                <i class="bi bi-lightbulb fs-3"></i>
                <h5 class="mt-2">Strategi</h5>
            </div>
        </div>
        @endif

        <div class="col">
            <div class="card card-box text-center" onclick="window.location.href='#'">
                <i class="bi bi-chat-square-quote fs-3"></i>
                <h5 class="mt-2">Feedback</h5>
            </div>
        </div>
    </div>
@endsection
