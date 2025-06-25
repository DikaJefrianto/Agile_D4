<!DOCTYPE html>
<html>
<head>
    <title>{{ __('Detail Laporan Emisi') }} - {{ $perusahaan->nama }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10pt; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1, h2, h3 { text-align: center; margin-bottom: 10px; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <h1>{{ __('Detail Laporan Emisi') }}</h1>
    <h2>{{ __('Perusahaan') }}: {{ $perusahaan->nama }}</h2>
    <h3>{{ __('Periode') }}: {{ \Carbon\Carbon::createFromDate((int)$tahun, (int)$bulan)->translatedFormat('F Y') }}</h3>

    <h4>{{ __('summary_period') }}</h4>
    <table>
        <thead>
            <tr>
                <th>{{ __('total_emission_kg') }}</th>
                <th>{{ __('daily_average_kg') }}</th>
                <th>{{ __('number_of_trips') }}</th>
                <th>{{ __('total_related_cost') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ number_format($totalEmisi, 2, ',', '.') }} kg</td>
                <td>{{ number_format($rataRataHarian, 2, ',', '.') }} kg</td>
                <td>{{ $totalPerjalanan }}</td>
                <td>{{ number_format($totalBiaya, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <h4>{{ __('list_detailed_emission_calculations') }}</h4>
    <table>
        <thead>
            <tr>
                <th>{{ __('no') }}</th>
                <th>{{ __('date') }}</th>
                <th>{{ __('employee') }}</th>
                <th>{{ __('method') }}</th>
                <th>{{ __('type_bb_transport_cost') }}</th>
                <th>{{ __('input_value') }}</th>
                <th>{{ __('number_of_people') }}</th>
                <th>{{ __('emission_kg') }}</th>
                <th>{{ __('related_cost_rp') }}</th>
                <th>{{ __('route') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($detailPerhitungans as $index => $perhitungan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $perhitungan->tanggal->translatedFormat('d M Y, H:i') }}</td>
                    <td>{{ $perhitungan->user->name ?? 'N/A' }}</td>
                    <td>{{ __($perhitungan->metode) }}</td>
                    <td>
                        @if ($perhitungan->metode == 'bahan_bakar' && $perhitungan->bahanBakar)
                            {{ $perhitungan->bahanBakar->Bahan_bakar }} ({{ __($perhitungan->bahanBakar->kategori) }})
                        @elseif ($perhitungan->metode == 'jarak_tempuh' && $perhitungan->transportasi)
                            {{ $perhitungan->transportasi->jenis }} ({{ __($perhitungan->transportasi->kategori) }})
                        @elseif ($perhitungan->metode == 'biaya' && $perhitungan->biaya)
                            {{ $perhitungan->biaya->jenisKendaraan }} ({{ __($perhitungan->biaya->kategori) }})
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        {{ number_format($perhitungan->nilai_input, 2, ',', '.') }}
                        @if ($perhitungan->metode == 'bahan_bakar') {{ __('Liter') }}
                        @elseif ($perhitungan->metode == 'jarak_tempuh') {{ __('km') }}
                        @elseif ($perhitungan->metode == 'biaya') {{ __('Rp') }}
                        @endif
                    </td>
                    <td>{{ $perhitungan->jumlah_orang }}</td>
                    <td>{{ number_format($perhitungan->hasil_emisi, 2, ',', '.') }} {{ __('kg') }}</td>
                    <td>Rp {{ number_format($perhitungan->biaya->factorEmisi ?? 0, 0, ',', '.') }}</td>
                    <td>{{ $perhitungan->titik_awal }} - {{ $perhitungan->titik_tujuan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">{{ __('no_detailed_emission_data') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
