{{-- Dropdown kategori --}}
{{-- <div class="mb-3">
    <label for="kategori" class="form-label">Kategori</label>
    <select name="kategori" id="kategori" class="form-select" onchange="filterBahanBakar()">
        <option value="">-- Pilih Kategori --</option>
        @php
            $kategoriOptions = $bahanBakar->pluck('kategori')->unique();
        @endphp
        @foreach ($kategoriOptions as $kategori)
            <option value="{{ $kategori }}">{{ ucfirst($kategori) }}</option>
        @endforeach
    </select>
</div> --}}

{{-- Dropdown bahan bakar --}}
<div class="mb-3">
    <label for="Bahan_bakar" class="form-label">Bahan Bakar</label>
    <select name="Bahan_bakar" id="Bahan_bakar" class="form-select" >
        <option value="">-- Pilih Bahan Bakar --</option>
        @foreach($bahanBakar as $item)
            <option value="{{ $item->id }}" data-kategori="{{ $item->kategori }}">
                {{ $item->Bahan_bakar }} ({{ ucfirst($item->kategori) }})
            </option>
        @endforeach
    </select>   
</div>

{{-- Input jumlah bahan bakar --}}
<div class="mb-3">
    <label for="nilai_input" class="form-label">Jumlah Bahan Bakar (liter)</label>
    <input type="number" name="nilai_input" id="nilai_input" class="form-control"  min="0" step="any">
</div>

{{-- Input tanggal --}}
{{-- <div class="mb-3">
    <label for="tanggal" class="form-label">Tanggal</label>
    <input type="date" name="tanggal" id="tanggal" class="form-control" >
</div> --}}

<script>
    function filterBahanBakar() {
        const kategori = document.getElementById('kategori').value;
        const bahanSelect = document.getElementById('jenis');
        const options = bahanSelect.querySelectorAll('option');

        options.forEach(option => {
            // Keep placeholder always visible
            if (!option.value) {
                option.style.display = 'block';
                option.disabled = false;
                return;
            }

            if (kategori === '' || option.dataset.kategori === kategori) {
                option.style.display = 'block';
                option.disabled = false;
            } else {
                option.style.display = 'none';
                option.disabled = true;
            }
        });

        // Reset pilihan dropdown saat kategori berubah
        bahanSelect.value = '';
    }
</script>
