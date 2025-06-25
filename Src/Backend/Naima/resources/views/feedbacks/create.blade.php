@extends('layouts.app') {{-- pastikan ini sama seperti halaman pengguna --}}

@section('content')
<div class="container">
    <h1 class="my-4">Tambah Feedback</h1>

    <form action="{{ route('feedbacks.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <input type="text" name="kategori" class="form-control" id="kategori" placeholder="Masukkan kategori" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" id="deskripsi" rows="4" placeholder="Masukkan deskripsi" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Kirim</button>
    </form>
</div>
@endsection
