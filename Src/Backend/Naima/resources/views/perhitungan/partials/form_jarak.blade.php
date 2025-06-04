<div class="mb-3">
    <label for="jenis" class="form-label">Jenis Kendaraan</label>
    <select name="jenis" id="jenis" class="form-select" required>
        <option value="">-- Pilih jenis Kendaraan --</option>
        @foreach($jenis as $item)
            <option value="{{ $item->id }}" data-kategori="{{ $item->kategori }}">
                {{ $item->jenis }} ({{ ucfirst($item->kategori) }})
            </option>   
        @endforeach
    </select>   
</div>

{{-- Input jumlah bahan bakar --}}
<div class="mb-3">
    <label for="nilai_input" class="form-label">Jarak Yang ditempuh (dalan KM)</label>
    <input type="number" name="nilai_input" id="nilai_input" class="form-control" required min="0" step="any">
</div>

{{-- Input tanggal --}}
{{-- <div class="mb-3">
    <label for="tanggal" class="form-label">Tanggal</label>
    <input type="date" name="tanggal" id="tanggal" class="form-control" required>
</div> --}} 

<script>
    // Fungsi ini bisa dipanggil dari onchange kategori (misal kategori ada di halaman induk)
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
