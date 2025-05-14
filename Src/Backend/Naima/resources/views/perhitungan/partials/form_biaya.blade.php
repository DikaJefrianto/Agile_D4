<div class="mb-3">
    <label for="kategori_transportasi" class="form-label">Kategori Transportasi</label>
    <select name="kategori_transportasi" id="kategori_transportasi_biaya" class="form-select" onchange="updateJenisKendaraanBiaya()">
        <option value="">-- Pilih Kategori --</option>
        <option value="darat">Darat</option>
        <option value="laut">Laut</option>
        <option value="udara">Udara</option>
    </select>
</div>

<div class="mb-3">
    <label for="jenis_kendaraan" class="form-label">Jenis Kendaraan</label>
    <select name="jenis_kendaraan" id="jenis_kendaraan_biaya" class="form-select">
        <option value="">-- Pilih Jenis Kendaraan --</option>
    </select>
</div>

<div class="mb-3">
    <label for="biaya" class="form-label">Biaya (Rp)</label>
    <input type="number" name="biaya" class="form-control">
</div>

<div class="mb-3">
    <label for="jumlah_orang" class="form-label">Jumlah Orang</label>
    <input type="number" name="jumlah_orang" class="form-control">
</div>

<div class="mb-3">
    <label for="tanggal" class="form-label">Tanggal</label>
    <input type="date" name="tanggal" class="form-control">
</div>

<script>
    const kendaraanBiayaOptions = {
        darat: ['Mobil', 'Motor', 'Bus', 'Kereta'],
        laut: ['Kapal Ferry', 'Speedboat'],
        udara: ['Pesawat Komersial', 'Helikopter']
    };

    function updateJenisKendaraanBiaya() {
        const kategori = document.getElementById('kategori_transportasi_biaya').value;
        const kendaraanSelect = document.getElementById('jenis_kendaraan_biaya');
        kendaraanSelect.innerHTML = '<option value="">-- Pilih Jenis Kendaraan --</option>';

        if (kategori && kendaraanBiayaOptions[kategori]) {
            kendaraanBiayaOptions[kategori].forEach(kendaraan => {
                const option = document.createElement('option');
                option.value = kendaraan;
                option.textContent = kendaraan;
                kendaraanSelect.appendChild(option);
            });
        }
    }
</script>
