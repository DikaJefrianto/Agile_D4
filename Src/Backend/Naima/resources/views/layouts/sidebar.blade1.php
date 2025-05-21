<div class="sidebar d-flex flex-column p-3 bg-success text-white" style="height: 100vh; width: 250px; position: fixed;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <img src="/images/ns-white-color.png" alt="NAIMA Logo" style="width: 50px; height: auto;" class="me-2">
        <span class="fs-4">NAIMA Sustainability</span>
    </a>
    <hr class="text-white">
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="/" class="nav-link text-white">
                <i class="bi bi-house me-2"></i> Beranda
            </a>
        </li>
        <li>
            <a href="{{ route('perusahaans.index') }}" class="nav-link text-white">
                <i class="bi bi-buildings me-2"></i> Manajemen Perusahaan
            </a>
        </li>
        <li>
            <a href="{{ route('penggunas.index') }}" class="nav-link text-white">
                <i class="bi bi-person me-2"></i> Pengguna
            </a>
        </li>
        <li>
            <a href="#" class="nav-link text-white">
                <i class="bi bi-calculator me-2"></i> Perhitungan
            </a>
        </li>
        <li>
            <a class="nav-link text-white dropdown-toggle" data-bs-toggle="collapse" href="#submenuPerhitungan"
                role="button" aria-expanded="false" aria-controls="submenuPerhitungan">
                <i class="bi bi-list-ul me-2"></i> Tabel
            </a>
            <div class="collapse ps-2" id="submenuPerhitungan">
                <ul class="nav flex-column">
                    <li>
                        <a href="#" class="nav-link text-white">
                            <i class="bi bi-calculator me-2"></i> Hasil Perhitungan
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link text-white">
                            <i class="bi bi-truck me-2"></i> Jenis Transportasi
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link text-white">
                            <i class="bi bi-fuel-pump me-2"></i> Bahan Bakar
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li>
            <a href="#" class="nav-link text-white">
                <i class="bi bi-chat-left-dots me-2"></i> Konsultasi
            </a>
        </li>
        <li>
            <a href="#" class="nav-link text-white">
                <i class="bi bi-cash-coin me-2"></i> Manajemen Biaya
            </a>
        </li>
        <li>
            <a href="#" class="nav-link text-white">
                <i class="bi bi-lightbulb me-2"></i> Strategi
            </a>
        </li>
        <li>
            <a href="#" class="nav-link text-white">
                <i class="bi bi-journal-text me-2"></i> Panduan
            </a>
        </li>
        <li>
            <a href="#" class="nav-link text-white">
                <i class="bi bi-chat-square-quote me-2"></i> Feedback
            </a>
        </li>
    </ul>
</div>
