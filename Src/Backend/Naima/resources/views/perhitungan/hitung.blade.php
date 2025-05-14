@extends('layouts.dashboard')

@section('title', 'Hitung Emisi')

@section('content')
<div class="container">
    <h2 class="text-center text-success mb-4">Hitung Emisi Perjalanan Bisnis</h2>

    <form action="{{ route('perhitungan.hitungEmisi') }}" method="POST" class="mx-auto" style="max-width: 600px;">
        @csrf

        {{-- Pilih Metode --}}
        <div class="mb-3">
            <label for="metode" class="form-label">Pilih Metode Perhitungan:</label>
            <select id="metode" name="metode"
                    class="form-select @error('metode') is-invalid @enderror" required>
                <option value="" disabled {{ old('metode') ? '' : 'selected' }}>-- Pilih Metode --</option>
                <option value="fuel"     {{ old('metode')=='fuel' ? 'selected':'' }}>Fuel Based Method (Bahan Bakar)</option>
                <option value="distance" {{ old('metode')=='distance' ? 'selected':'' }}>Distance Based Method (Jarak)</option>
                <option value="spend"    {{ old('metode')=='spend' ? 'selected':'' }}>Spend Based Method (Biaya)</option>
            </select>
            @error('metode') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Fuel --}}
        <div id="fuel-fields" class="metode-fields mb-3" style="display:none;">
            <label class="form-label">Fuel Based Method</label>
            <div class="mb-3">
                <label for="vol_bahan" class="form-label">Volume Bahan Bakar (L):</label>
                <input type="number" step="0.01" name="vol_bahan" id="vol_bahan"
                       value="{{ old('vol_bahan') }}"
                       class="form-control @error('vol_bahan') is-invalid @enderror">
                @error('vol_bahan') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="faktor_emisi" class="form-label">Faktor Emisi (kg CO₂e/L):</label>
                <input type="number" step="0.0001" name="faktor_emisi" id="faktor_emisi"
                       value="{{ old('faktor_emisi') }}"
                       class="form-control @error('faktor_emisi') is-invalid @enderror">
                @error('faktor_emisi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- Distance --}}
        <div id="distance-fields" class="metode-fields mb-3" style="display:none;">
            <label class="form-label">Distance Based Method</label>
            <div class="mb-3">
                <label for="jarak_tempuh" class="form-label">Jarak Tempuh (km):</label>
                <input type="number" step="0.01" name="jarak_tempuh" id="jarak_tempuh"
                       value="{{ old('jarak_tempuh') }}"
                       class="form-control @error('jarak_tempuh') is-invalid @enderror">
                @error('jarak_tempuh') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="faktor_per_km" class="form-label">Faktor Emisi per km (kg CO₂e/km):</label>
                <input type="number" step="0.0001" name="faktor_per_km" id="faktor_per_km"
                       value="{{ old('faktor_per_km') }}"
                       class="form-control @error('faktor_per_km') is-invalid @enderror">
                @error('faktor_per_km') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- Spend --}}
        <div id="spend-fields" class="metode-fields mb-3" style="display:none;">
            <label class="form-label">Spend Based Method</label>
            <div class="mb-3">
                <label for="biaya" class="form-label">Total Biaya Perjalanan (Rp):</label>
                <input type="number" step="1" name="biaya" id="biaya"
                       value="{{ old('biaya') }}"
                       class="form-control @error('biaya') is-invalid @enderror">
                @error('biaya') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="faktor_eeio" class="form-label">Faktor Emisi per Rupiah (kg CO₂e/Rp):</label>
                <input type="number" step="0.000001" name="faktor_eeio" id="faktor_eeio"
                       value="{{ old('faktor_eeio') }}"
                       class="form-control @error('faktor_eeio') is-invalid @enderror">
                @error('faktor_eeio') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-success px-5">Hitung Emisi</button>
        </div>
    </form>

    {{-- Tampilkan Hasil --}}
    @if(!is_null($hasil))
    <div class="mt-5 text-center">
        <h4>Hasil:</h4>
        <p class="fs-2 text-success">{{ number_format($hasil, 2) }} <small>kg CO₂</small></p>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    const sel = document.getElementById('metode');
    const blocks = {
        fuel: document.getElementById('fuel-fields'),
        distance: document.getElementById('distance-fields'),
        spend: document.getElementById('spend-fields'),
    };
    function toggle() {
        Object.values(blocks).forEach(b => b.style.display='none');
        const v = sel.value;
        if (blocks[v]) blocks[v].style.display = 'block';
    }
    sel.addEventListener('change', toggle);
    window.addEventListener('DOMContentLoaded', () => {
        if (sel.value) toggle();
    });
</script>
@endpush
