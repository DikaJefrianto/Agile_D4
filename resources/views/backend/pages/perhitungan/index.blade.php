@extends('backend.layouts.app')

@section('title')
    {{ __('Perhitungan') }} | {{ config('app.name') }}
@endsection

@section('admin-content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div x-data="{ pageName: '{{ __('Perhitungan') }}' }">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                    {{ __('Perhitungan Emisi') }}
                </h2>
                <nav>
                    <ol class="flex items-center gap-1.5">
                        <li>
                            <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                                href="{{ route('admin.dashboard') }}">
                                {{ __('Home') }}
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <li class="text-sm text-gray-800 dark:text-white/90">{{ __('Perhitungan') }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5 flex justify-between items-center">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">{{ __('Daftar Perhitungan Emisi') }}
                    </h3>
                    <a href="{{ route('admin.perhitungan.create') }}" class="btn-success">
                        <i class="bi bi-plus-circle mr-2"></i> {{ __('Tambah Data') }}
                    </a>
                </div>

                <div class="space-y-3 border-t border-gray-100 dark:border-gray-800 overflow-x-auto">
                    @include('backend.layouts.partials.messages')

                    <table class="w-full dark:text-gray-400">
                        <thead class="bg-light text-capitalize">
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">
                                    {{ __('No.') }}</th>
                                <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">
                                    {{ __('Titik Awal') }}</th>
                                <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">
                                    {{ __('Titik Tujuan') }}</th>
                                <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">
                                    {{ __('Metode') }}</th>
                                <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">
                                    {{ __('Kategori') }}</th>
                                <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">
                                    {{ __('Jenis') }}</th>
                                <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">
                                    {{ __('Input') }}</th>

                                <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">
                                    {{ __('Jumlah Orang') }}</th>
                                <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">
                                    {{ __('Emisi (kg CO₂e)') }}</th>
                                <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">
                                    {{ __('Tanggal') }}</th>
                                <th class="p-2 bg-gray-50 dark:bg-gray-800 dark:text-white text-left px-5">
                                    {{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($perhitungan as $item)
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <td class="px-5 py-4 sm:px-6">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-4 sm:px-6">{{ $item->titik_awal ?? '-' }}</td>
                                    <td class="px-5 py-4 sm:px-6">{{ $item->titik_tujuan ?? '-' }}</td>
                                    <td class="px-5 py-4 sm:px-6">
                                        @switch($item->metode)
                                            @case('bahan_bakar')
                                                {{ __('Bahan Bakar') }}
                                            @break

                                            @case('jarak')
                                            @case('jarak_tempuh')
                                                {{ __('Jarak Tempuh') }}
                                            @break

                                            @case('biaya')
                                                {{ __('Biaya') }}
                                            @break

                                            @default
                                                {{ ucfirst($item->metode) }} {{-- For unknown methods, just capitalize the raw value --}}
                                        @endswitch
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">{{ __(ucfirst($item->kategori)) }}</td>
                                    {{-- Assuming kategori might not always be directly translatable, but if it is, consider __($item->kategori) --}}
                                    <td class="px-5 py-4 sm:px-6">
                                        @if ($item->metode === 'bahan_bakar' && $item->bahanBakar)
                                            {{ $item->bahanBakar->Bahan_bakar }}
                                        @elseif (in_array($item->metode, ['jarak', 'jarak_tempuh']) && $item->transportasi)
                                            {{ $item->transportasi->jenis }}
                                        @elseif ($item->metode === 'biaya' && $item->biaya)
                                            {{ $item->biaya->jenisKendaraan }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">{{ $item->nilai_input ?? '-' }}</td>


                                    <td class="px-5 py-4 sm:px-6">{{ $item->jumlah_orang ?? '-' }}</td>
                                    <td class="px-5 py-4 sm:px-6 text-success font-semibold">
                                        {{ number_format($item->hasil_emisi, 2) }}</td>
                                    <td class="px-5 py-4 sm:px-6">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</td>
                                    <td class="px-5 py-4 sm:px-6 flex gap-2">
                                        {{-- Tombol Edit hanya muncul jika user adalah 'karyawan' --}}
                                        @if (Auth::check() && Auth::user()->hasRole('Karyawan'))
                                            {{-- Otorisasi Edit berdasarkan Policy --}}
                                            <a href="{{ route('admin.perhitungan.edit', $item) }}"
                                                class="btn-default !p-2">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        @endif


                                        <a href="{{ route('admin.perhitungan.show', $item->id) }}" class="btn-default !p-2"
                                            title="{{ __('Lihat Detail') }}">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        {{-- Tombol Hapus hanya muncul jika user adalah 'karyawan' --}}
                                        @if (Auth::check() && Auth::user()->hasRole('Karyawan'))
                                            {{-- Otorisasi Hapus berdasarkan Policy --}}
                                            <button data-modal-target="delete-modal-{{ $item->id }}"
                                                data-modal-toggle="delete-modal-{{ $item->id }}"
                                                class="btn-danger !p-2">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4 text-gray-500 dark:text-gray-400">
                                            {{ __('Belum ada data perhitungan tersedia.') }}
                                        </td>
                                    </tr>
                                @endforelse
                                @foreach ($perhitungan as $item)
                                    <div id="delete-modal-{{ $item->id }}" tabindex="-1" aria-hidden="true"
                                        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                                        <div class="relative w-full max-w-md h-full md:h-auto">
                                            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-700">
                                                <button type="button"
                                                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                    data-modal-hide="delete-modal-{{ $item->id }}">
                                                    <svg class="w-3 h-3" aria-hidden="true" fill="none" viewBox="0 0 14 14"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                                <div class="p-4 md:p-5 text-center">
                                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
                                                        fill="none" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>
                                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                                        {{ __('Yakin ingin menghapus data ini?') }}
                                                    </h3>
                                                    <form action="{{ route('admin.perhitungan.destroy', $item) }}"
                                                        method="POST">
                                                        @csrf @method('DELETE')
                                                        <button type="submit"
                                                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                            {{ __('Ya, Hapus') }}
                                                        </button>
                                                        <button data-modal-hide="delete-modal-{{ $item->id }}"
                                                            type="button"
                                                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                                            {{ __('Batal') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="my-4 px-4 sm:px-6">
                            {{ $perhitungan->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
