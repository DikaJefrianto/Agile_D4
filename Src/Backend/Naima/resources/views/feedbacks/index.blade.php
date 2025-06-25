@extends('layouts.app')

@section('content')
    <!-- kode HTML feedback kamu di sini -->
    <div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Feedback</h3>
        @if(auth()->user()->role !== 'admin')
            <a href="{{ route('feedbacks.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Feedback
            </a>
        @endif
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle text-center">
            <thead class="table-success">
                <tr>
                    <th style="width: 5%;">No</th>
                    @if(auth()->user()->role === 'admin')
                        <th style="width: 15%;">Nama Pengguna</th>
                    @endif
                    <th style="width: 20%;">Kategori</th>
                    <th style="width: 45%;">Deskripsi</th>
                    <th style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($feedbacks as $index => $feedback)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        @if(auth()->user()->role === 'admin')
                            <td>{{ $feedback->user->name ?? '-' }}</td>
                        @endif
                        <td>{{ $feedback->kategori }}</td>
                        <td>{{ $feedback->deskripsi }}</td>
                        <td>
                            {{-- Hapus hanya untuk admin atau user yang membuat feedback --}}
                            @if(auth()->user()->role === 'admin' || auth()->id() === $feedback->user_id)
                                <form action="{{ route('feedbacks.destroy', $feedback->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role === 'admin' ? 5 : 4 }}" class="text-center">Belum ada data feedback.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

