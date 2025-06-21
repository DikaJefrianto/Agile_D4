@extends('backend.layouts.app')

@section('title')
    {{ __('Edit Perhitungan Emisi') }} | {{ config('app.name') }}
@endsection

@section('admin-content')
    <div class="p-4 mx-auto max-w-screen-xl md:p-6">
        <div class="space-y-6">

            <div class="flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">{{ __('Edit Perhitungan Emisi') }}</h2>
            </div>

            {{-- Error handling --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Terjadi kesalahan!</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('admin.perhitungan.update', $perhitungan->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Hidden fields --}}
                <input type="hidden" name="kategori" value="{{ $kategori }}">
                <input type="hidden" name="metode" value="{{ $metode }}">

                {{-- Tampilkan Metode dan Kategori --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div
                        class="border border-gray-300 dark:border-gray-700 p-4 rounded-xl bg-white dark:bg-gray-800 shadow">
                        <div class="flex items-center gap-3">
                            @php
                                $metodeIcons = [
                                    'bahan_bakar' => [
                                        'icon' => 'bi-fuel-pump',
                                        'label' => 'Bahan Bakar',
                                        'desc' => 'Gunakan data konsumsi bahan bakar',
                                    ],
                                    'jarak_tempuh' => [
                                        'icon' => 'bi-geo-alt-fill',
                                        'label' => 'Jarak Tempuh',
                                        'desc' => 'Gunakan data jarak perjalanan',
                                    ],
                                    'biaya' => [
                                        'icon' => 'bi-cash-stack',
                                        'label' => 'Biaya',
                                        'desc' => 'Gunakan data biaya perjalanan',
                                    ],
                                ];
                                $icon = $metodeIcons[$perhitungan->metode]['icon'];
                                $label = $metodeIcons[$perhitungan->metode]['label'];
                                $desc = $metodeIcons[$perhitungan->metode]['desc'];
                            @endphp
                            <i class="bi {{ $icon }} text-xl text-primary"></i>
                            <div>
                                <div class="font-bold text-gray-800 dark:text-white">{{ $label }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-300">{{ $desc }}</div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="border border-gray-300 dark:border-gray-700 p-4 rounded-xl bg-white dark:bg-gray-800 shadow">
                        <div class="flex items-center gap-3">
                            @php
                                $kategoriIcons = [
                                    'Darat' => 'truck',
                                    'Laut' => 'ship',
                                    'Udara' => 'airplane-engines',
                                ];
                                $iconKategori = $kategoriIcons[$perhitungan->kategori] ?? 'question-circle';
                            @endphp
                            <i class="bi bi-{{ $iconKategori }} text-xl text-primary"></i>
                            <div>
                                <div class="font-bold text-gray-800 dark:text-white">{{ $perhitungan->kategori }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-300">
                                    @switch($perhitungan->kategori)
                                        @case('Darat')
                                            Mobil, motor, kereta, dll.
                                        @break

                                        @case('Laut')
                                            Kapal, ferry, dll.
                                        @break

                                        @case('Udara')
                                            Pesawat, helikopter, dll.
                                        @break

                                        @default
                                            Kategori tidak dikenal
                                    @endswitch
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- Dynamic Field --}}
                @if ($metode === 'bahan_bakar')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Bahan Bakar</label>
                        <select name="Bahan_bakar"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm dark:bg-gray-900 dark:text-white">
                            @foreach ($bahanBakar as $bb)
                                <option value="{{ $bb->id }}"
                                    {{ $bb->id == $perhitungan->bahan_bakar_id ? 'selected' : '' }}>
                                    {{ $bb->Bahan_bakar }} ({{ $bb->kategori }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                @elseif ($metode === 'jarak_tempuh')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Kendaraan</label>
                        <select name="jenis"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm dark:bg-gray-900 dark:text-white">
                            @foreach ($jenis as $trans)
                                <option value="{{ $trans->id }}"
                                    {{ $trans->id == $perhitungan->transportasi_id ? 'selected' : '' }}>
                                    {{ $trans->jenis }} ({{ $trans->kategori }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                @elseif ($metode === 'biaya')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Biaya</label>
                        <select name="jenisKendaraan"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm dark:bg-gray-900 dark:text-white">
                            @foreach ($jenisKendaraan as $b)
                                <option value="{{ $b->id }}"
                                    {{ $b->id == $perhitungan->biaya_id ? 'selected' : '' }}>
                                    {{ $b->jenisKendaraan }} ({{ $b->kategori }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                {{-- Nilai Input --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nilai Input</label>
                    <input type="number" name="nilai_input" step="0.01" value="{{ $perhitungan->nilai_input }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:text-white dark:border-gray-700"
                        required>
                </div>

                {{-- Lokasi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Titik Awal</label>
                    <input type="text" name="titik_awal" value="{{ old('titik_awal', $perhitungan->titik_awal) }}"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:text-white dark:border-gray-700"
                        placeholder="Contoh: Padang">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Titik Tujuan</label>
                    <input type="text" name="titik_tujuan" value="{{ old('titik_tujuan', $perhitungan->titik_tujuan) }}"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:text-white dark:border-gray-700"
                        placeholder="Contoh: Bukittinggi">
                </div>

                {{-- Jumlah Orang --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah Orang</label>
                    <input type="number" name="jumlah_orang" min="1" value="{{ $perhitungan->jumlah_orang }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:text-white dark:border-gray-700">
                </div>

                {{-- Tanggal --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal</label>
                    <input type="datetime-local" name="tanggal" value="{{ $perhitungan->tanggal }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:text-white dark:border-gray-700">
                </div>

                {{-- Submit --}}
                <div class="flex justify-start gap-3">
                    <button type="submit" class="btn-primary">
                        <i class="bi bi-save2"></i> {{ __('Perbarui') }}
                    </button>
                    <a href="{{ route('admin.perhitungan.index') }}" class="btn-default">
                        {{ __('Batal') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
