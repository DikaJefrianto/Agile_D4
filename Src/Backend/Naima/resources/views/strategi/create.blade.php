@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Strategi</h2>
    <form action="{{ route('strategi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-2">
            <label>Perusahaan</label>
            <select name="perusahaan_id" class="form-control">
                @foreach($perusahaans as $p)
                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-2">
            <label>Nama Program</label>
            <input name="nama_program" class="form-control" required>
        </div>
        <div class="mb-2">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
        </div>
        <div class="mb-2">
            <label>Dokumen (Opsional)</label>
            <input type="file" name="dokumen" class="form-control">
        </div>
        <div class="mb-2">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="draf">Draf</option>
                <option value="aktif">Aktif</option>
                <option value="selesai">Selesai</option>
            </select>
        </div>
        <button class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
