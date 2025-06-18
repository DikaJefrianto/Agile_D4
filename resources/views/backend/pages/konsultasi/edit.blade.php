@extends('backend.layouts.app')

@section('title')
    {{ __('Edit Konsultasi') }} | {{ config('app.name') }}
@endsection

@section('admin-content')
<div class="p-4 mx-auto max-w-4xl md:p-6">
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
            {{ __('Edit Konsultasi') }}
        </h2>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <form action="{{ route('admin.konsultasis.update', $konsultasi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-white" for="topik">Topik</label>
                <input type="text" id="topik" name="topik" value="{{ $konsultasi->topik }}" disabled class="form-input bg-gray-100 dark:bg-gray-800 dark:text-white cursor-not-allowed" />
            </div>

            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-white" for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" disabled class="form-textarea bg-gray-100 dark:bg-gray-800 dark:text-white cursor-not-allowed">{{ $konsultasi->deskripsi }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-white" for="status">Status</label>
                <select id="status" name="status" class="form-select">
                    <option value="pending" {{ $konsultasi->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="diterima" {{ $konsultasi->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="ditolak" {{ $konsultasi->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-white" for="jadwal">Jadwal</label>
                <input type="datetime-local" id="jadwal" name="jadwal" value="{{ $konsultasi->jadwal ? \Carbon\Carbon::parse($konsultasi->jadwal)->format('Y-m-d\TH:i') : '' }}" class="form-input" />
            </div>

            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-white" for="lokasi">Lokasi</label>
                <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi', $konsultasi->lokasi) }}" class="form-input" placeholder="Contoh: Zoom, Ruang Meeting A, dll" />
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.konsultasis.index') }}" class="btn-secondary">
                    {{ __('Kembali') }}
                </a>
                <button type="submit" class="btn-primary">
                    {{ __('Simpan Perubahan') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
