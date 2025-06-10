@extends('backend.layouts.app')

@section('title', 'Detail Perusahaan')

@section('content')
<div class="container mt-4">
    <h1 class="mb-3">Detail Perusahaan</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $perusahaan->nama }}</h5>
            <p><strong>Email:</strong> {{ $perusahaan->email }}</p>
            <p><strong>Username:</strong> {{ $perusahaan->username }}</p>
            <p><strong>Alamat:</strong> {{ $perusahaan->alamat }}</p>
            <p><strong>Keterangan:</strong> {{ $perusahaan->keterangan }}</p>
            <p><strong>Jumlah Karyawan:</strong> {{ $perusahaan->karyawans_count }}</p>
        </div>
    </div>

    <a href="{{ route('admin.perusahaans.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
