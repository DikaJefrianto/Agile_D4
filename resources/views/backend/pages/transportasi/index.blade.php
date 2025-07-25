@extends('backend.layouts.app')

@section('title')
    {{ __('Transportasi') }} | {{ config('app.name') }}
@endsection

@section('admin-content')
    <div class="p-4 mx-auto max-w-screen-2xl md:p-6">

        <div x-data="{ pageName: '{{ __('Transportasi') }}' }">
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">{{ __('Transportasi') }}</h2>
                {{-- Tombol 'Tambah Transportasi' hanya akan muncul jika pengguna memiliki peran 'admin', 'superadmin', atau 'karyawan' --}}
                @if(Auth::check() && (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Superadmin')))
                    <a href="{{ route('admin.transportasi.create') }}" class="btn-success">
                        <i class="bi bi-plus-circle mr-2"></i> {{ __('Tambah Transportasi') }}
                    </a>
                @endif
            </div>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-5 py-4 flex flex-wrap justify-between items-center gap-2">
                <h3 class="text-base font-medium text-gray-700 dark:text-white">{{ __('Daftar Transportasi') }}</h3>

                <div class="flex items-center gap-3">
                    <!-- Filter Dropdown -->
                    <div class="relative">
                        <button id="kategoriDropdownButton" data-dropdown-toggle="kategoriDropdown"
                            class="btn-default flex items-center justify-center gap-2" type="button">
                            <i class="bi bi-funnel-fill"></i>
                            {{ __('Filter Kategori') }}
                            <i class="bi bi-chevron-down"></i>
                        </button>

                        <div id="kategoriDropdown"
                            class="z-10 hidden w-48 p-3 mt-2 bg-white rounded-lg shadow dark:bg-gray-700 absolute right-0">
                            <ul class="space-y-2">
                                <li class="cursor-pointer text-sm text-gray-700 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600 px-2 py-1 rounded"
                                    onclick="handleKategoriFilter('')">
                                    {{ __('Semua Kategori') }}
                                </li>
                                @foreach (['Darat', 'Laut', 'Udara'] as $kategori)
                                    <li class="cursor-pointer text-sm text-gray-700 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600 px-2 py-1 rounded {{ request('kategori') === $kategori ? 'bg-gray-200 dark:bg-gray-600' : '' }}"
                                        onclick="handleKategoriFilter('{{ $kategori }}')">
                                        {{ __($kategori) }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <script>
                      function handleKategoriFilter(kategori) {
                          const url = new URL(window.location.href);
                          if (kategori) {
                              url.searchParams.set('kategori', kategori);
                          } else {
                              url.searchParams.delete('kategori');
                          }
                          window.location.href = url.toString();
                      }
                    </script>

                    @include('backend.partials.search-form', [
                        'placeholder' => __('Search by name '),
                    ])
                </div>
            </div>


            <div class="overflow-x-auto">
                @include('backend.layouts.partials.messages')
                <table class="w-full text-sm text-gray-700 dark:text-white">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="p-2 text-left">{{ __('No.') }}</th>
                            <th class="p-2 text-left">{{ __('Kategori') }}</th>
                            <th class="p-2 text-left">{{ __('Nama Transportasi') }}</th>
                            <th class="p-2 text-left">{{ __('Faktor Emisi') }}</th>
                            <th class="p-2 text-left">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transportasis as $item)
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <td class="p-2">{{ $loop->iteration }}</td>
                                <td class="p-2">{{ __($item->kategori) }}</td>
                                <td class="p-2">{{ __($item->jenis) }}</td>
                                <td class="p-2">{{ __($item->factor_emisi) }}</td>
                                <td class="px-5 py-4 sm:px-6 flex gap-2">
                                    {{-- Tombol Edit hanya muncul jika user adalah 'karyawan' --}}
                                    @if (Auth::check() && Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Superadmin'))
                                        {{-- Otorisasi Edit berdasarkan Policy --}}
                                        <a href="{{ route('admin.transportasi.edit', $item) }}"
                                            class="btn-default !p-2">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    @endif

                                    {{-- Tombol Hapus hanya muncul jika user adalah 'karyawan' --}}
                                    @if (Auth::check() && Auth::user()->hasRole('Admin')|| Auth::user()->hasRole('Superadmin'))
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
                                <td colspan="5" class="text-center py-4 text-gray-600 dark:text-gray-400">
                                    {{ __('Tidak ada data transportasi') }}
                                </td>
                            </tr>
                        @endforelse
                        @foreach ($transportasis as $item)
                            <!-- Delete Modal -->
                            <div id="delete-modal-{{ $item->id }}" tabindex="-1" aria-hidden="true"
                                class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                                <div class="relative w-full max-w-md h-full md:h-auto">
                                    <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-700">
                                        <button type="button"
                                            class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                            data-modal-hide="delete-modal-{{ $item->id }}">
                                            <svg class="w-3 h-3" aria-hidden="true" fill="none" viewBox="0 0 14 14"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                        <div class="p-4 md:p-5 text-center">
                                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
                                                fill="none" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                                {{ __('Yakin ingin menghapus transportasi ini?') }}
                                            </h3>
                                            <form action="{{ route('admin.transportasi.destroy', $item) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                    {{ __('Ya, Hapus') }}
                                                </button>
                                                <button data-modal-hide="delete-modal-{{ $item->id }}" type="button"
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

                <div class="my-4 px-4 text-gray-700 dark:text-white">
                    {{ $transportasis->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection

