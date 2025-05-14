@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4">Perhitungan Emisi</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan!</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('perhitungan.store') }}" method="POST">
        @csrf

        {{-- Pertanyaan 1 --}}
        <div class="mb-4">
            <label class="form-label">1. Apakah kamu mengetahui berapa bahan bakar yang terpakai?</label><br>
            <input type="radio" name="tahu_bahan_bakar" value="ya" onchange="handleAnswer(this, 'form-bahan-bakar', 'pertanyaan-jarak')"> Ya
            <input type="radio" name="tahu_bahan_bakar" value="tidak" onchange="handleAnswer(this, null, 'pertanyaan-jarak')"> Tidak
        </div>

        <div id="form-bahan-bakar" style="display: none;">
            @include('perhitungan.partials.form_bahan_bakar')
        </div>

        {{-- Pertanyaan 2 --}}
        <div id="pertanyaan-jarak" style="display: none;" class="mb-4">
            <label class="form-label">2. Apakah kamu mengetahui berapa Jarak tempuhnya?</label><br>
            <input type="radio" name="tahu_jarak" value="ya" onchange="handleAnswer(this, 'form-jarak', 'pertanyaan-biaya')"> Ya
            <input type="radio" name="tahu_jarak" value="tidak" onchange="handleAnswer(this, null, 'pertanyaan-biaya')"> Tidak
        </div>

        <div id="form-jarak" style="display: none;">
            @include('perhitungan.partials.form_jarak')
        </div>

        {{-- Pertanyaan 3 --}}
        <div id="pertanyaan-biaya" style="display: none;" class="mb-4">
            <label class="form-label">3. Apakah kamu mengetahui berapa biaya yang kamu keluarkan?</label><br>
            <input type="radio" name="tahu_biaya" value="ya" onchange="handleAnswer(this, 'form-biaya', null)"> Ya
            <input type="radio" name="tahu_biaya" value="tidak" onchange="window.location='{{ route('dashboard') }}'"> Tidak
        </div>

        <div id="form-biaya" style="display: none;">
            @include('perhitungan.partials.form_biaya')
        </div>

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-success">Hitung & Simpan</button>
            <a href="{{ route('perhitungan.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>

<script>
    function handleAnswer(radio, formId, nextQuestionId) {
        // Sembunyikan semua form
        document.getElementById('form-bahan-bakar').style.display = 'none';
        document.getElementById('form-jarak').style.display = 'none';
        document.getElementById('form-biaya').style.display = 'none';

        // Tampilkan form jika pilih "ya"
        if (radio.value === 'ya' && formId) {
            document.getElementById(formId).style.display = 'block';
        }

        // Tampilkan pertanyaan berikutnya jika pilih "tidak"
        if (radio.value === 'tidak' && nextQuestionId) {
            document.getElementById(nextQuestionId).style.display = 'block';
        }
    }
</script>
@endsection
