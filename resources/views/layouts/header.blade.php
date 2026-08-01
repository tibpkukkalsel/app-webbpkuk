<!-- Sticky Header Navigation -->
<header class="header" id="mainHeader">
    <div class="header-container">
        <!-- Left: Kalimantan Selatan Emblem Logo -->
        <a href="/" class="brand-logo left-logo">
            @if ($logoleft = $identitas->firstWhere('nama', 'Logo Pemprov'))
                <img src="{{ asset('storage/header/' . $logoleft->keterangan) }}" class="kalsel-emblem-svg"
                    alt="Logo Pemprov Kalsel">
            @endif
        </a>

        <!-- Middle Nav Links -->
        <nav class="nav-menu">
            <ul class="nav-list">
                <li class="nav-item active"><a href="/" class="nav-link">BERANDA</a></li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link">PROFIL <i class="fa-solid font-chevron fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('/profil/tentang') }}">Tentang</a></li>
                        <li><a href="{{ url('/profil/visimisi') }}">Visi & Misi</a></li>
                        <li><a href="{{ url('/profil/struktur-organisasi') }}">Struktur Organisasi</a></li>
                        <li><a href="{{ url('/profil/pegawai') }}">Data Pegawai</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link">LAYANAN <i class="fa-solid font-chevron fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Dashboard Diklat</a></li>
                        <li><a href="{{ url('/layanan/pemanfaatan-fasilitas') }}">Pemanfaatan Fasilitas</a></li>
                        <li><a href="https://pusatlayanankemasankalsel.com/">Layanan Kemasan</a></li>
                        <li><a href="#">Identifikasi Kebutuhan Pelatihan</a></li>
                        <li><a href="#">Sertifikat Elektronik</a></li>
                        <li><a href="#">Survei Kepuasan Diklat</a></li>
                    </ul>
                </li>
                <li class="nav-item active"><a href="{{ url('/agenda') }}" class="nav-link">AGENDA</a></li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link">INFORMASI <i
                            class="fa-solid font-chevron fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('/informasi?jenis=Berita') }}">Berita</a></li>
                        <li><a href="{{ url('/informasi?jenis=Artikel') }}">Artikel</a></li>
                        <li><a href="{{ url('/informasi?jenis=Tips') }}">Info dan Tips</a></li>
                        <li><a href="{{ url('/informasi') }}">Semua Informasi</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a href="{{ url('/galeri/foto') }}" class="nav-link">GALERI <i
                            class="fa-solid font-chevron fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('/galeri/foto') }}">Foto</a></li>
                        <li><a href="{{ url('/galeri/video') }}">Video</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a href="#" class="nav-link">KONTAK</a></li>
            </ul>
        </nav>

        <!-- Center: BERANDA Home Button & Logo Dividers (Mobile Column 2) -->
        <div class="header-home-wrap">
            <div class="header-logo-divider"></div>
            <a href="{{ url('/') }}" class="header-home-btn" title="Beranda">
                <i class="fa-solid fa-house"></i>
                <span>BERANDA</span>
            </a>
            <div class="header-logo-divider"></div>
        </div>

        <!-- Right: BALATKOP KALSEL Logo (Mobile Column 3) -->
        <div class="brand-logo right-logo">
            <div class="balatkop-logo-wrap">
                @if ($logoright = $identitas->firstWhere('nama', 'Logo Balatkop Sec'))
                    <img src="{{ asset('storage/header/' . $logoright->keterangan) }}" class="logo-img logo-white"
                        alt="Balatkop Kalsel">
                @endif
                @if ($logoright = $identitas->firstWhere('nama', 'Logo Balatkop Primary'))
                    <img src="{{ asset('storage/header/' . $logoright->keterangan) }}" class="logo-img logo-blue"
                        alt="Balatkop Kalsel">
                @endif
            </div>
        </div>
    </div>
</header>

<!-- Mobile Bottom Navigation Bar (BCA Style Mobile Nav) -->
<div class="mobile-bottom-nav">
    <div class="mobile-nav-container">
        <!-- Item 1: Profil -->
        <button class="mobile-nav-item" data-sheet="sheet-profil" type="button">
            <div class="mobile-nav-icon">
                <i class="fa-regular fa-building"></i>
            </div>
            <span class="mobile-nav-label">Profil</span>
        </button>

        <!-- Item 2: Layanan -->
        <button class="mobile-nav-item" data-sheet="sheet-layanan" type="button">
            <div class="mobile-nav-icon">
                <i class="fa-solid fa-list-check"></i>
            </div>
            <span class="mobile-nav-label">Layanan</span>
        </button>

        <!-- Item 3: Agenda -->
        <a href="{{ url('/agenda') }}" class="mobile-nav-item">
            <div class="mobile-nav-icon">
                <i class="fa-regular fa-calendar-days"></i>
            </div>
            <span class="mobile-nav-label">Agenda</span>
        </a>

        <!-- Item 4: Informasi -->
        <button class="mobile-nav-item" data-sheet="sheet-informasi" type="button">
            <div class="mobile-nav-icon">
                <i class="fa-regular fa-newspaper"></i>
            </div>
            <span class="mobile-nav-label">Informasi</span>
        </button>

        <!-- Item 5: Galeri -->
        <button class="mobile-nav-item" data-sheet="sheet-galeri" type="button">
            <div class="mobile-nav-icon">
                <i class="fa-solid fa-photo-film"></i>
            </div>
            <span class="mobile-nav-label">Galeri</span>
        </button>

        <!-- Item 6: Kontak -->
        <a href="#" class="mobile-nav-item">
            <div class="mobile-nav-icon">
                <i class="fa-solid fa-headset"></i>
            </div>
            <span class="mobile-nav-label">Kontak</span>
        </a>
    </div>
</div>

<!-- Mobile Sub-Menu Bottom Sheets & Backdrop -->
<div class="mobile-sheet-backdrop" id="mobileSheetBackdrop"></div>

<!-- Sheet: Profil -->
<div class="mobile-bottom-sheet" id="sheet-profil">
    <div class="sheet-header">
        <div class="sheet-title">
            <i class="fa-regular fa-building"></i>
            <span>Menu Profil</span>
        </div>
        <button class="sheet-close-btn" type="button"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <ul class="sheet-menu-list">
        <li><a href="{{ url('/profil/tentang') }}"><i class="fa-solid fa-chevron-right"></i> Tentang</a></li>
        <li><a href="{{ url('/profil/visimisi') }}"><i class="fa-solid fa-chevron-right"></i> Visi & Misi</a></li>
        <li><a href="{{ url('/profil/struktur-organisasi') }}"><i class="fa-solid fa-chevron-right"></i> Struktur
                Organisasi</a></li>
        <li><a href="{{ url('/profil/pegawai') }}"><i class="fa-solid fa-chevron-right"></i> Data Pegawai</a></li>
    </ul>
</div>

<!-- Sheet: Layanan -->
<div class="mobile-bottom-sheet" id="sheet-layanan">
    <div class="sheet-header">
        <div class="sheet-title">
            <i class="fa-solid fa-list-check"></i>
            <span>Menu Layanan</span>
        </div>
        <button class="sheet-close-btn" type="button"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <ul class="sheet-menu-list">
        <li><a href="#"><i class="fa-solid fa-chevron-right"></i> Dashboard Diklat</a></li>
        <li><a href="{{ url('/layanan/pemanfaatan-fasilitas') }}"><i class="fa-solid fa-chevron-right"></i> Pemanfaatan Fasilitas</a></li>
        <li><a href="https://pusatlayanankemasankalsel.com/"><i class="fa-solid fa-chevron-right"></i> Layanan Kemasan</a></li>
        <li><a href="#"><i class="fa-solid fa-chevron-right"></i> Identifikasi Kebutuhan Pelatihan</a></li>
        <li><a href="#"><i class="fa-solid fa-chevron-right"></i> Sertifikat Elektronik</a></li>
        <li><a href="#"><i class="fa-solid fa-chevron-right"></i> Survei Kepuasan Diklat</a></li>
    </ul>
</div>

<!-- Sheet: Informasi / Berita -->
<div class="mobile-bottom-sheet" id="sheet-informasi">
    <div class="sheet-header">
        <div class="sheet-title">
            <i class="fa-solid fa-newspaper"></i>
            <span>Menu Berita & Informasi</span>
        </div>
        <button class="sheet-close-btn" type="button"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <ul class="sheet-menu-list">
        <li><a href="{{ url('/informasi?jenis=Berita') }}"><i class="fa-solid fa-chevron-right"></i> Berita</a></li>
        <li><a href="{{ url('/informasi?jenis=Artikel') }}"><i class="fa-solid fa-chevron-right"></i> Artikel</a>
        </li>
        <li><a href="{{ url('/informasi?jenis=Tips') }}"><i class="fa-solid fa-chevron-right"></i> Info dan Tips</a>
        </li>
        <li><a href="{{ url('/informasi') }}"><i class="fa-solid fa-chevron-right"></i> Semua Informasi</a></li>
    </ul>
</div>

<!-- Sheet: Galeri -->
<div class="mobile-bottom-sheet" id="sheet-galeri">
    <div class="sheet-header">
        <div class="sheet-title">
            <i class="fa-solid fa-photo-film"></i>
            <span>Menu Galeri</span>
        </div>
        <button class="sheet-close-btn" type="button"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <ul class="sheet-menu-list">
        <li><a href="{{ url('/galeri/foto') }}"><i class="fa-solid fa-chevron-right"></i> Foto</a></li>
        <li><a href="{{ url('/galeri/video') }}"><i class="fa-solid fa-chevron-right"></i> Video</a></li>
    </ul>
</div>
