@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Konsultasi</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="#" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Konsultasi
        </a>
    </div>

    @if($konsultasis->isEmpty())
        <div class="alert alert-warning">Belum ada data konsultasi.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-success">
                    <tr>
                        <th>#</th>
                        <th>Topik</th>
                        <th>Pesan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($konsultasis as $index => $konsultasi)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $konsultasi->topik }}</td>
                            <td>{{ Str::limit($konsultasi->pesan, 50) }}</td>
                            <td>{{ $konsultasi->created_at->format('d M Y') }}</td>
                            <td>
                                <form action="#" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <a href="#" class="btn btn-info btn-sm">Detail</a>
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
