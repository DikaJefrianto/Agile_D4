<div class="mb-3">
    <label for="kategori_transportasi" class="form-label">Kategori Transportasi</label>
    <select name="kategori_transportasi" id="kategori_transportasi" class="form-select" onchange="updateJenisKendaraan()">
        <option value="">-- Pilih Kategori --</option>
        <option value="darat">Darat</option>
        <option value="laut">Laut</option>
        <option value="udara">Udara</option>
    </select>
</div>

<div class="mb-3">
    <label for="jenis_kendaraan" class="form-label">Jenis Kendaraan</label>
    <select name="jenis_kendaraan" id="jenis_kendaraan" class="form-select" onchange="updateJenisBahanBakar()">
        <option value="">-- Pilih Jenis Kendaraan --</option>
    </select>
</div>

<div class="mb-3">
    <label for="jenis_bahan_bakar" class="form-label">Jenis Bahan Bakar</label>
    <select name="jenis_bahan_bakar" id="jenis_bahan_bakar" class="form-select">
        <option value="">-- Pilih Bahan Bakar --</option>
    </select>
</div>

<div class="mb-3">
    <label for="jumlah_bahan_bakar" class="form-label">Jumlah Bahan Bakar (liter)</label>
    <input type="number" name="jumlah_bahan_bakar" id="jumlah_bahan_bakar" class="form-control">
</div>

<div class="mb-3">
    <label for="tanggal" class="form-label">Tanggal</label>
    <input type="date" name="tanggal" class="form-control">
</div>

<script>
    const kendaraanOptions = {
        darat: ['Mobil', 'Motor', 'Bus', 'Truk'],
        laut: ['Kapal Ferry', 'Speedboat'],
        udara: ['Pesawat Komersial', 'Helikopter']
    };

    const bahanBakarOptions = {
        Mobil: ['Bensin', 'Solar', 'Listrik'],
        Motor: ['Bensin', 'Listrik'],
        Bus: ['Solar', 'Listrik'],
        Truk: ['Solar'],
        'Kapal Ferry': ['Solar', 'LNG'],
        Speedboat: ['Bensin', 'Solar'],
        'Pesawat Komersial': ['Avtur'],
        Helikopter: ['Avtur']
    };

    function updateJenisKendaraan() {
        const kategori = document.getElementById('kategori_transportasi').value;
        const kendaraanSelect = document.getElementById('jenis_kendaraan');
        kendaraanSelect.innerHTML = '<option value="">-- Pilih Jenis Kendaraan --</option>';

        if (kategori && kendaraanOptions[kategori]) {
            kendaraanOptions[kategori].forEach(kendaraan => {
                const option = document.createElement('option');
                option.value = kendaraan;
                option.textContent = kendaraan;
                kendaraanSelect.appendChild(option);
            });
        }

        // Reset bahan bakar
        document.getElementById('jenis_bahan_bakar').innerHTML = '<option value="">-- Pilih Bahan Bakar --</option>';
    }

    function updateJenisBahanBakar() {
        const kendaraan = document.getElementById('jenis_kendaraan').value;
        const bahanBakarSelect = document.getElementById('jenis_bahan_bakar');
        bahanBakarSelect.innerHTML = '<option value="">-- Pilih Bahan Bakar --</option>';

        if (kendaraan && bahanBakarOptions[kendaraan]) {
            bahanBakarOptions[kendaraan].forEach(bahan => {
                const option = document.createElement('option');
                option.value = bahan;
                option.textContent = bahan;
                bahanBakarSelect.appendChild(option);
            });
        }
    }
</script>
