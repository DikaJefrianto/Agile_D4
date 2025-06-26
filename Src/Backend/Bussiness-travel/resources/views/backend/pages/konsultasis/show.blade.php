@extends('backend.layouts.app')

@section('title')
    {{ __('Detail Konsultasi') }} | {{ config('app.name') }}
@endsection

@section('admin-content')
<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
            {{ __('Detail Konsultasi') }}
        </h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li>
                    <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('admin.dashboard') }}">
                        {{ __('Home') }}
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                <li>
                    <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('admin.konsultasis.index') }}">
                        {{ __('Konsultasi') }}
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                <li class="text-sm text-gray-800 dark:text-white/90">{{ __('Detail') }}</li>
            </ol>
        </nav>
    </div>

    <div class="space-y-6">
        @include('backend.layouts.partials.messages')

        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
            <h3 class="text-lg font-medium text-gray-800 dark:text-white/90 mb-4">{{ __('Informasi Lengkap Konsultasi') }}</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @if (auth()->user()->hasRole(['Admin', 'Superadmin']))
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Perusahaan Pengaju') }}</label>
                    <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $konsultasi->perusahaan->nama ?? 'N/A' }}</p>
                </div>
                @endif

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Topik Konsultasi') }}</label>
                    <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $konsultasi->topik }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Waktu Diajukan') }}</label>
                    <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $konsultasi->waktu_diajukan ? $konsultasi->waktu_diajukan->format('d M Y, H:i') : '-' }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Lokasi Diajukan') }}</label>
                    <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $konsultasi->lokasi_diajukan ?? '-' }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Status') }}</label>
                    <p class="mt-1">
                        @if($konsultasi->status == 'pending')
                            <span class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">{{ __('Pending') }}</span>
                        @elseif($konsultasi->status == 'diterima')
                            <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-800 ring-1 ring-inset ring-green-600/20">{{ __('Diterima') }}</span>
                        @else
                            <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-800 ring-1 ring-inset ring-red-600/20">{{ __('Ditolak') }}</span>
                        @endif
                    </p>
                </div>

                @if($konsultasi->status == 'diterima' || $konsultasi->status == 'ditolak')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Waktu Disetujui/Ditolak') }}</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $konsultasi->waktu_disetujui ? $konsultasi->waktu_disetujui->format('d M Y, H:i') : '-' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Lokasi Disetujui') }}</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $konsultasi->lokasi_disetujui ?? '-' }}</p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Catatan Admin') }}</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $konsultasi->catatan_admin ?? '-' }}</p>
                    </div>
                @endif
            </div>

            <div class="mt-6 flex justify-end gap-2">
                <a href="{{ route('admin.konsultasis.index') }}" class="btn-success">
                    <i class="bi bi-arrow-left-circle mr-2"></i>
                    {{ __('Kembali ke Daftar') }}
                </a>
                {{-- Hanya Admin/Super Admin yang bisa mengedit status/detail --}}
                @if (auth()->user()->hasRole(['admin', 'super-admin']))
                    <a href="{{ route('admin.konsultasis.edit', $konsultasi->id) }}" class="btn-success">
                        <i class="bi bi-pencil mr-2"></i>
                        {{ __('Kelola Konsultasi') }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
