@extends('backend.layouts.app')

@section('title', 'Ajukan Konsultasi')

@section('admin-content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Ajukan Konsultasi Baru</h2>
    <form action="{{ route('admin.consultations.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="topik" class="block font-medium text-gray-700">Topik</label>
            <input type="text" name="topik" id="topik" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="block font-medium text-gray-700">Deskripsi (opsional)</label>
            <textarea name="deskripsi" id="deskripsi" rows="4" class="mt-1 block w-full rounded border-gray-300 shadow-sm"></textarea>
        </div>

        <button type="submit" class="btn-primary">
            <i class="bi bi-send mr-2"></i> Kirim Pengajuan
        </button>
    </form>
</div>
@endsection
