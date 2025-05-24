<div class="sidebar d-flex flex-column p-3">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <i class="bi bi-leaf-fill fs-3">
            <img src="/images/ns-white-color.png" alt="NAIMA Logo" style="width: 100%; height: auto;"></i>
        <span class="fs-3 ms-2"></span>
    </a>
    <hr class="text-white">
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link">
                <i class="bi bi-house me-2"></i> Beranda
            </a>
        </li>
        <li><a href="" class="nav-link text-white"><i class="bi bi-buildings me-2"></i>Perusahaan</a></li>
        <li><a href="" class="nav-link text-white"><i class="bi bi-person me-2"></i>karyawan</a></li>
        <li class="nav-item">
            <a href="{{ route('perhitungan.create') }}" class="nav-link">
                <i class="bi bi-calculator me-2"></i> Perhitungan
            </a>
        </li>
        {{-- Menu Dropdown Perhitungan --}}
        <li>
            <a class="nav-link text-white dropdown-toggle" data-bs-toggle="collapse" href="#submenuPerhitungan"
                role="button" aria-expanded="false" aria-controls="submenuPerhitungan">
                <i class="bi bi-list-ul me-2"></i> Tabel
            </a>
            <div class="collapse ps-2 @if (request()->routeIs('perhitungan.') || request()->routeIs('transportasi.') || request()->routeIs('bahanbakar.*')) show @endif" id="submenuPerhitungan">
                <ul class="nav flex-column">
                    <li>
                        <a href="{{ route('perhitungan.index') }}" class="nav-link text-white">
                            <i class="bi bi-calculator me-2"></i> Hasil Perhitungan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('transportasi.index') }}" class="nav-link text-white">
                            <i class="bi bi-truck me-2"></i>  Emisi Transportasi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('BahanBakar.index') }}" class="nav-link text-white ">
                            <i class="bi bi-fuel-pump me-2"></i>  Emisi Bahan Bakar
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('biaya.index') }}" class="nav-link @if (request()->routeIs('biaya.*')) active @endif">
                            <i class="bi bi-cash-coin me-2"></i> Emisi Biaya
                        </a>
                    </li>   
                </ul>
            </div>
        </li>

        <li>
            <a href="#" class="nav-link @if (request()->routeIs('konsultasi.*')) active @endif">
                <i class="bi bi-chat-left-dots me-2"></i> Konsultasi
            </a>
        </li>
        <!-- Tambahkan setelah Konsultasi -->
        
        <li>
            <a href="#"
                class="nav-link @if (request()->routeIs('strategi.*')) active @endif">
                <i class="bi bi-lightbulb me-2"></i> Strategi
            </a>
        </li>
        <li>
            <a href="#" class="nav-link @if (request()->routeIs('panduan.*')) active @endif">
                <i class="bi bi-journal-text me-2"></i> Panduan
            </a>
        </li>
        <li>
            <a href="#"
                class="nav-link @if (request()->routeIs('feedback.*')) active @endif">
                <i class="bi bi-chat-square-quote me-2"></i> Feedback
            </a>
        </li>

    </ul>
</div>
