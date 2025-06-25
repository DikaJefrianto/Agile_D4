<!DOCTYPE html>
<html>
<head>
    <title>Laporan Emisi Perusahaan</title>
    <style>
        /* CSS sederhana untuk PDF */
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h1, h2, h3 {
            text-align: center;
            margin-bottom: 10px;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Laporan Emisi Perusahaan</h1>
    <h2>Periode: {{ \Carbon\Carbon::createFromDate($tahun, $bulan)->translatedFormat('F Y') }}</h2>

    <h3>Laporan Perusahaan</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Perusahaan</th>
                <th>Total Emisi (kg CO₂)</th>
                <th>Rata-rata Harian (kg CO₂)</th>
                <th>Banyak Perjalanan</th>
                <th>Periode</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($perusahaans as $index => $perusahaan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $perusahaan->nama }}</td>
                    <td>{{ number_format($perusahaan->total_emisi_filtered, 2, ',', '.') }} kg</td>
                    <td>{{ number_format($perusahaan->rata_rata_harian, 2, ',', '.') }} kg</td>
                    <td>{{ $perusahaan->total_perjalanan }} kali</td>
                    <td>{{ \Carbon\Carbon::createFromDate($tahun, $bulan)->translatedFormat('F Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data perusahaan untuk periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Anda bisa menambahkan tabel breakdown bahan bakar dan transportasi juga di sini jika diperlukan di PDF --}}
    {{-- Contoh untuk bahan bakar:
    <h3>Emisi Berdasarkan Bahan Bakar</h3>
    <table>
        <thead>
            <tr>
                <th>Jenis Bahan Bakar</th>
                <th>Total Emisi (kg CO₂)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($emisiPerBahanBakar as $data)
            <tr>
                <td>{{ $data->nama_bakar }}</td>
                <td>{{ number_format($data->total_emisi, 2, ',', '.') }} kg</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    --}}
</body>
</html>
