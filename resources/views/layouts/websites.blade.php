<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @if ($title = $identitas->firstWhere('nama', 'Title Website'))
    <title>
        {{ $title->keterangan }}
    </title>
    @endif

    <link rel="shortcut icon" type="image/png"
        @if ($shortcut = $identitas->firstWhere('nama', 'Logo Shorcut')) 
        href="{{ asset('storage/header/' . $shortcut->keterangan) }}" /> 
        @endif

    <meta name="description"
        content="Website Resmi Balai Pelatihan Koperasi & Usaha Kecil Provinsi Kalimantan Selatan. Temukan informasi publik, layanan koperasi, layanan usaha kecil, dan info pelatihan.">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Lora:ital,wght@0,600;0,700;1,600&family=Montserrat:wght@800;900&display=swap"
        rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('websites/css/style.css') }}">
</head>

<body>

    <!-- Sticky Header Navigation -->
    <header class="header" id="mainHeader">
        <div class="header-container">
            <!-- Left: Kalimantan Selatan Emblem Logo -->
            <a href="#" class="brand-logo left-logo">
                @if ($logoleft = $identitas->firstWhere('nama', 'Logo Website'))
                    <img src="{{ asset('storage/header/' . $logoleft->keterangan) }}" class="kalsel-emblem-svg"
                        height="70">
                @endif
            </a>

            <!-- Middle Nav Links -->
            <nav class="nav-menu">
                <ul class="nav-list">
                    <li class="nav-item active"><a href="#" class="nav-link">HOME</a></li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link">PROFIL <i
                                class="fa-solid font-chevron fa-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Visi & Misi</a></li>
                            <li><a href="#">Struktur Organisasi</a></li>
                            <li><a href="#">Tugas & Fungsi</a></li>
                            <li><a href="#">Sejarah</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link">UNIT KERJA <i
                                class="fa-solid font-chevron fa-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Bidang Koperasi</a></li>
                            <li><a href="#">Bidang Usaha Kecil</a></li>
                            <li><a href="#">UPTD Balatkop</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link">PPID <i
                                class="fa-solid font-chevron fa-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Profil PPID</a></li>
                            <li><a href="#">Informasi Berkala</a></li>
                            <li><a href="#">Informasi Setiap Saat</a></li>
                            <li><a href="#">Permohonan Informasi</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link">PROGRAM <i
                                class="fa-solid font-chevron fa-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">OPOP (One Pesantren One Product)</a></li>
                            <li><a href="#">Wirausaha Juara</a></li>
                            <li><a href="#">Digitalisasi UMKM</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link">MEDIA <i
                                class="fa-solid font-chevron fa-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Berita Terkini</a></li>
                            <li><a href="#">Galeri Foto</a></li>
                            <li><a href="#">Video Kegiatan</a></li>
                            <li><a href="#">Pengumuman</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a href="#" class="nav-link">REGULASI</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">KONTAK</a></li>
                </ul>
            </nav>

            <!-- Right: BALATKOP KALSEL Logo -->
            <div class="brand-logo right-logo">
                <div class="balatkop-logo-wrap">
                    @if ($logoright = $identitas->firstWhere('nama', 'Logo White'))
                    <img src="{{ asset('storage/header/' . $logoright->keterangan) }}" class="logo-img logo-white"
                        style="height: 70px">
                    @endif
                    @if ($logoright = $identitas->firstWhere('nama', 'Logo Landing'))
                    <img src="{{ asset('storage/header/' . $logoright->keterangan) }}" class="logo-img logo-blue"
                        style="height: 70px">
                    @endif
                </div>
            </div>

            <!-- Mobile Hamburger Button -->
            <button class="mobile-toggle" aria-label="Toggle Navigation">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </header>

    <!-- Hero Wrapper with Background -->
    <div class="hero-wrapper">
        <div class="bg-overlay"></div>

        <!-- Main Hero Content -->
        <main class="hero-content">
            <div class="hero-container">

                <!-- Welcome Tagline -->
                <div class="welcome-badge">
                    <span>SELAMAT DATANG DI WEBSITE</span>
                </div>

                <!-- Headline -->
                <h1 class="hero-title">
                    Balai Pelatihan Koperasi & Usaha Kecil<br>Provinsi Kalimantan Selatan
                </h1>

                <!-- Subheadline -->
                <p class="hero-subtitle">
                    Temukan informasi publik terkini
                </p>

                <!-- Search Container -->
                <div class="search-box-wrapper">
                    <form class="search-form" id="searchForm" onsubmit="event.preventDefault();">
                        <input type="text" id="searchInput" class="search-input" placeholder="Cari Informasi ..."
                            autocomplete="off">
                        <button type="submit" class="search-btn" aria-label="Cari">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>

                    <!-- Popular Searches / Hashtags -->
                    <div class="popular-search-bar">
                        <span class="popular-label">Pencarian Terpopuler</span>
                        <div class="tags-group">
                            <a href="#" class="tag-pill">#CPNS</a>
                            <a href="#" class="tag-pill">#LAYANAN KOPERASI</a>
                            <a href="#" class="tag-pill">#BAZAR</a>
                        </div>
                    </div>
                </div>

                <!-- Feature Quick Action Cards (3 Column) -->
                <div class="action-cards-grid">
                    <!-- Blue Card: Layanan Koperasi -->
                    <a href="#" class="action-card card-blue">
                        <div class="card-icon-box">
                            <i class="fa-solid fa-city"></i>
                        </div>
                        <span class="card-text">LAYANAN KOPERASI</span>
                    </a>

                    <!-- Green Card: Layanan Usaha Kecil -->
                    <a href="#" class="action-card card-green">
                        <div class="card-icon-box">
                            <i class="fa-solid fa-store"></i>
                        </div>
                        <span class="card-text">LAYANAN USAHA KECIL</span>
                    </a>

                    <!-- Yellow/Gold Card: Info Pelatihan -->
                    <a href="#" class="action-card card-yellow">
                        <div class="card-icon-box">
                            <i class="fa-solid fa-arrow-right-from-bracket icon-rotate"></i>
                        </div>
                        <span class="card-text">INFO PELATIHAN</span>
                    </a>
                </div>

            </div>
        </main>
    </div>

    <!-- Megamendung Pattern Slider Section Below Hero -->
    <section class="slider-section">
        <div class="megamendung-bg"></div>
        <div class="slider-wrapper-container">

            <!-- Slider Carousel Box -->
            <div class="slider-carousel" id="autoSlider">
                <div class="slider-track" id="sliderTrack">

                    <!-- Slide 1: Anti Gratifikasi Banner -->
                    <div class="slide-item">
                        <div class="banner-card banner-gratifikasi-custom">
                            <div class="banner-left-content">
                                <div class="banner-logos">
                                    <svg viewBox="0 0 100 120" width="30" height="36">
                                        <path d="M50 5 L90 25 V65 C90 90 50 115 50 115 C50 115 10 90 10 65 V25 Z"
                                            fill="#15803d" stroke="#facc15" stroke-width="4" />
                                        <path d="M25 70 L50 40 L75 70 Z" fill="#1e3a8a" />
                                    </svg>
                                    <div class="mini-diskuk">
                                        <span class="m-title">DISKUK</span>
                                        <span class="m-sub">• JABAR •</span>
                                    </div>
                                </div>
                                <div class="banner-gratifikasi-graphics">
                                    <div class="hand-stop-icon">
                                        <i class="fa-solid fa-hand"></i>
                                    </div>
                                    <div class="stop-heading">
                                        <span class="stop-red-text">STOP</span>
                                        <span class="gratifikasi-text">GRATIFIKASI!</span>
                                    </div>
                                </div>
                                <div class="banner-notice-box">
                                    <p>MOHON UNTUK TIDAK MEMBERI IMBALAN, HADIAH ATAU PEMBERIAN DALAM BENTUK APAPUN,
                                        ATAS PELAYANAN YANG KAMI BERIKAN</p>
                                </div>
                            </div>
                            <div class="banner-right-illustration">
                                <img src="banner1.jpg" alt="Anti Gratifikasi Campaign" class="banner-img">
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2: OPOP & UMKM Juara -->
                    <div class="slide-item">
                        <div class="banner-card banner-opop-custom">
                            <div class="banner-left-content text-light">
                                <span class="banner-tag">PROGRAM UNGGULAN</span>
                                <h2 class="banner-main-title">One Pesantren One Product (OPOP)</h2>
                                <p class="banner-desc">Mewujudkan Kemandirian Ekonomi Pesantren & Pendampingan UMKM
                                    Juara di Kalimantan Selatan</p>
                                <a href="#" class="banner-btn">Selengkapnya <i
                                        class="fa-solid fa-arrow-right"></i></a>
                            </div>
                            <div class="banner-right-illustration">
                                <img src="banner2.jpg" alt="OPOP Jabar" class="banner-img">
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3: Pelatihan Koperasi & UMKM -->
                    <div class="slide-item">
                        <div class="banner-card banner-pelatihan-custom">
                            <div class="banner-left-content text-light">
                                <span class="banner-tag gold-tag">BALATKOP JABAR</span>
                                <h2 class="banner-main-title">Pelatihan & Digitalisasi UMKM 2026</h2>
                                <p class="banner-desc">Tingkatkan Kapasitas Usaha Anda Melalui Pelatihan Kewirausahaan
                                    & Akses Pembiayaan Koperasi</p>
                                <a href="#" class="banner-btn gold-btn">Daftar Sekarang <i
                                        class="fa-solid fa-arrow-right"></i></a>
                            </div>
                            <div class="banner-right-illustration">
                                <img src="banner3.jpg" alt="Pelatihan Koperasi Jabar" class="banner-img">
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Navigation Arrows -->
                <button class="slider-arrow prev-btn" id="prevBtn" aria-label="Previous Slide">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <button class="slider-arrow next-btn" id="nextBtn" aria-label="Next Slide">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>

                <!-- Pagination Dots -->
                <div class="slider-dots" id="sliderDots">
                    <!-- Dots will be populated by script.js -->
                </div>
            </div>

        </div>
    </section>

    <!-- =========================================================
         PUSAT INFORMASI / BERITA TERKINI SECTION
         ========================================================= -->
    <section class="news-info-section">
        <div class="news-container">

            <!-- Section Header Titles -->
            <div class="news-header">
                <span class="news-sub-tagline">PUSAT INFORMASI KOPERASI DAN USAHA KECIL DI PROVINSI Kalimantan
                    Selatan</span>
                <h2 class="news-main-title">Berita Terkini</h2>
            </div>

            <!-- Tab Navigation & Filter -->
            <div class="news-tabs-bar">
                <div class="tabs-group">
                    <button class="news-tab-btn active" data-tab="berita">Berita Terbaru</button>
                    <button class="news-tab-btn" data-tab="foto">Galeri Foto</button>
                    <button class="news-tab-btn" data-tab="video">Galeri Video</button>
                </div>
            </div>

            <!-- Main Content Layout (2 Columns: News Grid + Popular Sidebar) -->
            <div class="news-content-grid">

                <!-- Left Column: Featured News Cards Grid (2x2) -->
                <div class="news-left-column">
                    <div class="news-cards-wrapper" id="newsCardsGrid">

                        <!-- Card 1 -->
                        <article class="news-card">
                            <div class="news-image-box">
                                <div class="placeholder-img-bg bg-gradient-1">
                                    <i class="fa-solid fa-people-roof placeholder-icon"></i>
                                </div>
                                <div class="date-badge">
                                    <span class="day-text">24</span>
                                    <span class="month-text">JUL 2026</span>
                                </div>
                            </div>
                            <div class="news-details">
                                <span class="news-category-label">UMKM</span>
                                <h3 class="news-title">
                                    <a href="#">Pendampingan Digitalisasi dan Fasilitasi Legalitas Usaha Mikro
                                        Kalimantan Selatan</a>
                                </h3>
                            </div>
                        </article>

                        <!-- Card 2 -->
                        <article class="news-card">
                            <div class="news-image-box">
                                <div class="placeholder-img-bg bg-gradient-2">
                                    <i class="fa-solid fa-chalkboard-user placeholder-icon"></i>
                                </div>
                                <div class="date-badge">
                                    <span class="day-text">24</span>
                                    <span class="month-text">JUL 2026</span>
                                </div>
                            </div>
                            <div class="news-details">
                                <span class="news-category-label">UMKM</span>
                                <h3 class="news-title">
                                    <a href="#">Bimbingan Teknis Peningkatan Kapasitas SDM Koperasi & UMKM
                                        Juara</a>
                                </h3>
                            </div>
                        </article>

                        <!-- Card 3 -->
                        <article class="news-card">
                            <div class="news-image-box">
                                <div class="placeholder-img-bg bg-gradient-3">
                                    <i class="fa-solid fa-graduation-cap placeholder-icon"></i>
                                </div>
                                <div class="date-badge">
                                    <span class="day-text">21</span>
                                    <span class="month-text">JUL 2026</span>
                                </div>
                            </div>
                            <div class="news-details">
                                <span class="news-category-label">KOPERASI</span>
                                <h3 class="news-title">
                                    <a href="#">Saba Sakola Hadir di SMA PGRI 1 Bandung, Pelajar Dibekali
                                        Pemahaman Koperasi yang...</a>
                                </h3>
                            </div>
                        </article>

                        <!-- Card 4 -->
                        <article class="news-card">
                            <div class="news-image-box">
                                <div class="placeholder-img-bg bg-gradient-4">
                                    <i class="fa-solid fa-user-group placeholder-icon"></i>
                                </div>
                                <div class="date-badge">
                                    <span class="day-text">17</span>
                                    <span class="month-text">JUL 2026</span>
                                </div>
                            </div>
                            <div class="news-details">
                                <span class="news-category-label">KOPERASI</span>
                                <h3 class="news-title">
                                    <a href="#">Tata Sugiarta Terima Kunjungan Kuliah Lapangan Mahasiswa Ikopin
                                        University</a>
                                </h3>
                            </div>
                        </article>

                    </div>

                    <!-- Bottom Action Button -->
                    <div class="more-news-btn-wrap">
                        <a href="#" class="btn-outline-blue">BERITA LAINNYA</a>
                    </div>
                </div>

                <!-- Right Column: Berita Terpopuler Sidebar -->
                <aside class="news-right-sidebar">
                    <h3 class="sidebar-heading">Berita Terpopuler</h3>

                    <div class="popular-list">

                        <!-- Popular Item 1 -->
                        <div class="popular-item">
                            <div class="popular-thumb-box thumb-blue">
                                <i class="fa-solid fa-file-signature"></i>
                            </div>
                            <div class="popular-info">
                                <span class="popular-date">10 JUL 2025</span>
                                <h4 class="popular-title">
                                    <a href="#">Panduan Membuat NIB Perorangan Secara Online untuk Pelaku
                                        UMKM</a>
                                </h4>
                            </div>
                        </div>

                        <!-- Popular Item 2 -->
                        <div class="popular-item">
                            <div class="popular-thumb-box thumb-teal">
                                <i class="fa-solid fa-handshake"></i>
                            </div>
                            <div class="popular-info">
                                <span class="popular-date">31 MAR 2026</span>
                                <h4 class="popular-title">
                                    <a href="#">Memahami Alur Rapat Anggota Tahunan (RAT) Koperasi Secara...</a>
                                </h4>
                            </div>
                        </div>

                        <!-- Popular Item 3 -->
                        <div class="popular-item">
                            <div class="popular-thumb-box thumb-red">
                                <i class="fa-solid fa-bullhorn"></i>
                            </div>
                            <div class="popular-info">
                                <span class="popular-date">14 AUG 2025</span>
                                <h4 class="popular-title">
                                    <a href="#">Tata Cara Pengaduan Melalui SP4N Lapor di lapor.go.id</a>
                                </h4>
                            </div>
                        </div>

                        <!-- Popular Item 4 -->
                        <div class="popular-item">
                            <div class="popular-thumb-box thumb-purple">
                                <i class="fa-solid fa-building-columns"></i>
                            </div>
                            <div class="popular-info">
                                <span class="popular-date">05 FEB 2025</span>
                                <h4 class="popular-title">
                                    <a href="#">Perkembangan Koperasi di Indonesia: Dari Gerakan Rakyat ke Pilar
                                        Ekono...</a>
                                </h4>
                            </div>
                        </div>

                        <!-- Popular Item 5 -->
                        <div class="popular-item">
                            <div class="popular-thumb-box thumb-green">
                                <i class="fa-solid fa-ribbon"></i>
                            </div>
                            <div class="popular-info">
                                <span class="popular-date">12 JUL 2025</span>
                                <h4 class="popular-title">
                                    <a href="#">Hari Koperasi ke-78 Tahun 2025: Koperasi Maju, Indonesia Adil
                                        dan...</a>
                                </h4>
                            </div>
                        </div>

                        <!-- Popular Item 6 -->
                        <div class="popular-item">
                            <div class="popular-thumb-box thumb-orange">
                                <i class="fa-solid fa-clipboard-check"></i>
                            </div>
                            <div class="popular-info">
                                <span class="popular-date">21 MAY 2024</span>
                                <h4 class="popular-title">
                                    <a href="#">Penerapan Metode Pemeriksaan Kesehatan Koperasi</a>
                                </h4>
                            </div>
                        </div>

                    </div>
                </aside>

            </div>

        </div>
    </section>

    <!-- =========================================================
         AGENDA KEGIATAN SECTION
         ========================================================= -->
    <section class="agenda-section">
        <div class="agenda-container">

            <!-- Section Header (Tagline + Title + Navigation Arrows) -->
            <div class="agenda-header">
                <div class="agenda-title-box">
                    <span class="agenda-sub-tagline">PUSAT INFORMASI KOPERASI DAN USAHA KECIL DI PROVINSI Kalimantan
                        Selatan</span>
                    <h2 class="agenda-main-title">Agenda Kegiatan</h2>
                </div>

                <!-- Nav Arrows for Agenda Carousel -->
                <div class="agenda-nav-arrows">
                    <button class="agenda-arrow agenda-prev" id="agendaPrevBtn" aria-label="Agenda Sebelumnya">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <button class="agenda-arrow agenda-next" id="agendaNextBtn" aria-label="Agenda Selanjutnya">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            <!-- Agenda Cards Track / Grid -->
            <div class="agenda-carousel-wrapper">
                <div class="agenda-track" id="agendaTrack">

                    <!-- Agenda Item 1 -->
                    <div class="agenda-card">
                        <div class="agenda-date-box">
                            <div class="agenda-day">06</div>
                            <div class="agenda-month">JAN</div>
                        </div>
                        <div class="agenda-body">
                            <span class="status-pill status-upcoming">Belum Dimulai</span>
                            <h3 class="agenda-card-title">
                                <a href="#">Pembekalan KKN Mahasiswa Universitas Padjadjaran</a>
                            </h3>
                            <div class="agenda-meta">
                                <span class="meta-item"><i class="fa-regular fa-calendar-check"></i> 06.01.26</span>
                                <span class="meta-item"><i class="fa-regular fa-clock"></i> 10:11 AM</span>
                            </div>
                        </div>
                    </div>

                    <!-- Agenda Item 2 -->
                    <div class="agenda-card">
                        <div class="agenda-date-box">
                            <div class="agenda-day">06</div>
                            <div class="agenda-month">JAN</div>
                        </div>
                        <div class="agenda-body">
                            <span class="status-pill status-upcoming">Belum Dimulai</span>
                            <h3 class="agenda-card-title">
                                <a href="#">Rapat Percepatan Pembangunan KDKMP</a>
                            </h3>
                            <div class="agenda-meta">
                                <span class="meta-item"><i class="fa-regular fa-calendar-check"></i> 06.01.26</span>
                                <span class="meta-item"><i class="fa-regular fa-clock"></i> 10:08 AM</span>
                            </div>
                        </div>
                    </div>

                    <!-- Agenda Item 3 -->
                    <div class="agenda-card">
                        <div class="agenda-date-box">
                            <div class="agenda-day">06</div>
                            <div class="agenda-month">JAN</div>
                        </div>
                        <div class="agenda-body">
                            <span class="status-pill status-upcoming">Belum Dimulai</span>
                            <h3 class="agenda-card-title">
                                <a href="#">Rapat Anggota Tahunan Koperasi Warga SMAN 5 Cimahi</a>
                            </h3>
                            <div class="agenda-meta">
                                <span class="meta-item"><i class="fa-regular fa-calendar-check"></i> 06.01.26</span>
                                <span class="meta-item"><i class="fa-regular fa-clock"></i> 10:07 AM</span>
                            </div>
                        </div>
                    </div>

                    <!-- Agenda Item 4 (Additional slide for carousel) -->
                    <div class="agenda-card">
                        <div class="agenda-date-box">
                            <div class="agenda-day">12</div>
                            <div class="agenda-month">JAN</div>
                        </div>
                        <div class="agenda-body">
                            <span class="status-pill status-upcoming">Belum Dimulai</span>
                            <h3 class="agenda-card-title">
                                <a href="#">Sosialisasi Pembiayaan Dana Bergulir UMKM Jabar</a>
                            </h3>
                            <div class="agenda-meta">
                                <span class="meta-item"><i class="fa-regular fa-calendar-check"></i> 12.01.26</span>
                                <span class="meta-item"><i class="fa-regular fa-clock"></i> 09:00 AM</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Bottom Action Button -->
            <div class="more-agenda-btn-wrap">
                <a href="#" class="btn-outline-blue">AGENDA LAINNYA</a>
            </div>

        </div>
    </section>

    <!-- =========================================================
         PRODUK UNGGULAN USAHA KECIL Kalimantan Selatan SECTION
         ========================================================= -->
    <section class="products-section">
        <div class="products-container">

            <!-- Split Layout: Left Titles/Nav & Right Carousel -->
            <div class="products-split-layout">

                <!-- Left Intro Side -->
                <div class="products-intro-side">
                    <span class="products-sub-tagline">PUSAT INFORMASI KOPERASI DAN USAHA KECIL DI PROVINSI Kalimantan
                        Selatan</span>
                    <h2 class="products-main-title">Produk<br>Unggulan Usaha<br>Kecil Kalimantan Selatan</h2>

                    <!-- Navigation Arrows for Product Cards -->
                    <div class="products-nav-arrows">
                        <button class="products-arrow prod-prev" id="prodPrevBtn" aria-label="Produk Sebelumnya">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <button class="products-arrow prod-next" id="prodNextBtn" aria-label="Produk Selanjutnya">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Right Cards Carousel Track Side -->
                <div class="products-carousel-side">
                    <div class="products-carousel-wrapper">
                        <div class="products-track" id="productsTrack">

                            <!-- Product Card 1: Sukahijab -->
                            <div class="product-card">
                                <div class="product-img-box">
                                    <img src="prod1.jpg" alt="Sukahijab Modest Fashion" class="product-img">
                                </div>
                                <div class="product-info-box">
                                    <span class="product-tag">ADMIN</span>
                                    <h3 class="product-title"><a href="#">Sukahijab</a></h3>
                                    <p class="product-location">KAB TASIKMALAYA, Kalimantan Selatan</p>
                                </div>
                            </div>

                            <!-- Product Card 2: Sae Nadhilah -->
                            <div class="product-card">
                                <div class="product-img-box">
                                    <img src="prod2.jpg" alt="Sae Nadhilah Batik Denim" class="product-img">
                                </div>
                                <div class="product-info-box">
                                    <span class="product-tag">ZN</span>
                                    <h3 class="product-title"><a href="#">Sae Nadhilah</a></h3>
                                    <p class="product-location">KAB BOGOR, Kalimantan Selatan</p>
                                </div>
                            </div>

                            <!-- Product Card 3: Mister Jenky -->
                            <div class="product-card">
                                <div class="product-img-box">
                                    <img src="prod3.jpg" alt="Mister Jenky Snack" class="product-img">
                                </div>
                                <div class="product-info-box">
                                    <span class="product-tag">ZN</span>
                                    <h3 class="product-title"><a href="#">Mister Jenky</a></h3>
                                    <p class="product-location">KAB INDRAMAYU, Kalimantan Selatan</p>
                                </div>
                            </div>

                            <!-- Product Card 4: Jabal Handicraft -->
                            <div class="product-card">
                                <div class="product-img-box">
                                    <img src="prod4.jpg" alt="Jabal Handicraft" class="product-img">
                                </div>
                                <div class="product-info-box">
                                    <span class="product-tag">ZN</span>
                                    <h3 class="product-title"><a href="#">Jabal Handicraft</a></h3>
                                    <p class="product-location">KAB KUNINGAN, Kalimantan Selatan</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Action Button -->
            <div class="more-products-btn-wrap">
                <a href="#" class="btn-outline-blue">PRODUK LAINNYA</a>
            </div>

        </div>
    </section>

    <!-- =========================================================
         LINK TERKAIT (PARTNER LOGOS MARQUEE) SECTION
         ========================================================= -->
    <section class="related-links-section">
        <div class="links-container">

            <!-- Section Header -->
            <div class="links-header">
                <span class="links-sub-tagline">PUSAT INFORMASI KOPERASI DAN USAHA KECIL DI PROVINSI Kalimantan
                    Selatan</span>
                <h2 class="links-main-title">Link Terkait</h2>
            </div>

            <!-- Infinite Auto-Scrolling Marquee Container (1 Baris + Pause on Hover) -->
            <div class="partner-marquee-container" id="partnerMarquee">
                <div class="partner-marquee-track">

                    <!-- SET 1 LOGOS -->
                    <!-- Partner 1: KEMEN KOP UKM -->
                    <a href="https://kemenkopukm.go.id" target="_blank" class="partner-logo-item"
                        title="Kementerian Koperasi dan UKM RI">
                        <div class="logo-box">
                            <div class="kemenkop-symbol">
                                <i class="fa-solid fa-dharmachakra"></i>
                            </div>
                            <div class="logo-text-col">
                                <span class="logo-bold-title">KEMEN<br>KOPUKM</span>
                                <span class="logo-tiny-sub">Kementerian Koperasi Dan UKM<br>Republik Indonesia</span>
                            </div>
                        </div>
                    </a>

                    <!-- Partner 2: Smesco -->
                    <a href="https://smesco.go.id" target="_blank" class="partner-logo-item"
                        title="Smesco Indonesia">
                        <div class="logo-box">
                            <div class="smesco-symbol">S</div>
                            <span class="smesco-title">smesco</span>
                        </div>
                    </a>

                    <!-- Partner 3: OPOP -->
                    <a href="https://opop.jabarprov.go.id" target="_blank" class="partner-logo-item"
                        title="One Pesantren One Product Jabar">
                        <div class="logo-box">
                            <div class="opop-symbol">
                                <i class="fa-solid fa-people-carry-box"></i>
                            </div>
                            <div class="opop-text-col">
                                <span class="opop-title">OPOP</span>
                                <span class="opop-sub">One Pesantren One Product</span>
                            </div>
                        </div>
                    </a>

                    <!-- Partner 4: Singakota -->
                    <a href="#" class="partner-logo-item" title="Singakota Digital">
                        <div class="logo-box">
                            <div class="singakota-symbol">
                                <i class="fa-solid fa-diagram-project"></i>
                            </div>
                            <div class="singakota-text-col">
                                <span class="singakota-title">singakota</span>
                                <span class="singakota-sub">Sistem Informasi Pengawasan<br>Koperasi Digital</span>
                            </div>
                        </div>
                    </a>

                    <!-- Partner 5: DISKUK JABAR Emblem -->
                    <a href="#" class="partner-logo-item" title="DISKUK Provinsi Kalimantan Selatan">
                        <div class="logo-box diskuk-partner-card">
                            <svg viewBox="0 0 100 45" width="48" height="24" fill="none"
                                stroke="#94a3b8">
                                <line x1="50" y1="2" x2="50" y2="10"
                                    stroke-width="2" />
                                <circle cx="50" cy="2" r="2" fill="#94a3b8" />
                                <path d="M42 12 L50 7 L58 12 H42 Z" fill="#94a3b8" />
                                <path d="M38 18 L50 12 L62 18 H38 Z" fill="#94a3b8" />
                                <path d="M32 25 L50 18 L68 25 H32 Z" fill="#94a3b8" />
                                <rect x="22" y="25" width="56" height="12" fill="none" stroke-width="2" />
                            </svg>
                            <span class="diskuk-partner-text">DISKUK JABAR</span>
                        </div>
                    </a>

                    <!-- Partner 6: Portal Jabarprov.go.id -->
                    <a href="https://jabarprov.go.id" target="_blank" class="partner-logo-item"
                        title="Portal Resmi Pemprov Jabar">
                        <div class="logo-box">
                            <div class="portal-symbol">
                                <i class="fa-solid fa-cubes"></i>
                            </div>
                            <div class="portal-text-col">
                                <span class="portal-sub">PORTAL</span>
                                <span class="portal-bold">JABARPROVGOID</span>
                            </div>
                        </div>
                    </a>

                    <!-- SET 2 LOGOS (DUPLICATED FOR SEAMLESS INFINITE LOOP) -->
                    <!-- Partner 1: KEMEN KOP UKM -->
                    <a href="https://kemenkopukm.go.id" target="_blank" class="partner-logo-item"
                        title="Kementerian Koperasi dan UKM RI">
                        <div class="logo-box">
                            <div class="kemenkop-symbol">
                                <i class="fa-solid fa-dharmachakra"></i>
                            </div>
                            <div class="logo-text-col">
                                <span class="logo-bold-title">KEMEN<br>KOPUKM</span>
                                <span class="logo-tiny-sub">Kementerian Koperasi Dan UKM<br>Republik Indonesia</span>
                            </div>
                        </div>
                    </a>

                    <!-- Partner 2: Smesco -->
                    <a href="https://smesco.go.id" target="_blank" class="partner-logo-item"
                        title="Smesco Indonesia">
                        <div class="logo-box">
                            <div class="smesco-symbol">S</div>
                            <span class="smesco-title">smesco</span>
                        </div>
                    </a>

                    <!-- Partner 3: OPOP -->
                    <a href="https://opop.jabarprov.go.id" target="_blank" class="partner-logo-item"
                        title="One Pesantren One Product Jabar">
                        <div class="logo-box">
                            <div class="opop-symbol">
                                <i class="fa-solid fa-people-carry-box"></i>
                            </div>
                            <div class="opop-text-col">
                                <span class="opop-title">OPOP</span>
                                <span class="opop-sub">One Pesantren One Product</span>
                            </div>
                        </div>
                    </a>

                    <!-- Partner 4: Singakota -->
                    <a href="#" class="partner-logo-item" title="Singakota Digital">
                        <div class="logo-box">
                            <div class="singakota-symbol">
                                <i class="fa-solid fa-diagram-project"></i>
                            </div>
                            <div class="singakota-text-col">
                                <span class="singakota-title">singakota</span>
                                <span class="singakota-sub">Sistem Informasi Pengawasan<br>Koperasi Digital</span>
                            </div>
                        </div>
                    </a>

                    <!-- Partner 5: DISKUK JABAR Emblem -->
                    <a href="#" class="partner-logo-item" title="DISKUK Provinsi Kalimantan Selatan">
                        <div class="logo-box diskuk-partner-card">
                            <svg viewBox="0 0 100 45" width="48" height="24" fill="none"
                                stroke="#94a3b8">
                                <line x1="50" y1="2" x2="50" y2="10"
                                    stroke-width="2" />
                                <circle cx="50" cy="2" r="2" fill="#94a3b8" />
                                <path d="M42 12 L50 7 L58 12 H42 Z" fill="#94a3b8" />
                                <path d="M38 18 L50 12 L62 18 H38 Z" fill="#94a3b8" />
                                <path d="M32 25 L50 18 L68 25 H32 Z" fill="#94a3b8" />
                                <rect x="22" y="25" width="56" height="12" fill="none" stroke-width="2" />
                            </svg>
                            <span class="diskuk-partner-text">DISKUK JABAR</span>
                        </div>
                    </a>

                    <!-- Partner 6: Portal Jabarprov.go.id -->
                    <a href="https://jabarprov.go.id" target="_blank" class="partner-logo-item"
                        title="Portal Resmi Pemprov Jabar">
                        <div class="logo-box">
                            <div class="portal-symbol">
                                <i class="fa-solid fa-cubes"></i>
                            </div>
                            <div class="portal-text-col">
                                <span class="portal-sub">PORTAL</span>
                                <span class="portal-bold">JABARPROVGOID</span>
                            </div>
                        </div>
                    </a>

                </div>
            </div>

        </div>
    </section>

    <!-- =========================================================
         FOOTER SECTION
         ========================================================= -->
    <footer class="site-footer">
        <div class="footer-container">

            <!-- Main 4-Column Grid -->
            <div class="footer-grid">

                <!-- Col 1: Tentang & Google Maps Box -->
                <div class="footer-col col-tentang">
                    <h3 class="footer-heading">Tentang</h3>
                    <p class="footer-desc">
                        Balai Pelatihan Koperasi & Usaha Kecil Prov. Kalimantan Selatan memiliki fungsi utama sebagai
                        pusat pendidikan dan pelatihan untuk pengembangan sumber daya manusia (SDM) koperasi dan pelaku
                        usaha kecil di Provinsi Kalimantan Selatan.
                    </p>

                    <!-- Google Maps Card Box -->
                    <div class="maps-card">
                        <div class="maps-icon-box">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div class="maps-info">
                            <h4 class="maps-title">Google Maps</h4>
                            <p class="maps-address">Jl. Soekarno Hatta No.705, Sekejati, Kec. Buahbatu, Kota Bandung,
                                Kalimantan Selatan 40286</p>
                        </div>
                    </div>
                </div>

                <!-- Col 2: Profil -->
                <div class="footer-col col-profil">
                    <h3 class="footer-heading">Profil</h3>
                    <ul class="footer-links">
                        <li><a href="#">Tentang</a></li>
                        <li><a href="#">Visi dan Misi</a></li>
                        <li><a href="#">Struktur Organisasi</a></li>
                        <li><a href="#">Fasilitas</a></li>
                    </ul>
                </div>

                <!-- Col 3: Layanan -->
                <div class="footer-col col-layanan">
                    <h3 class="footer-heading">Layanan</h3>
                    <ul class="footer-links">
                        <li><a href="#">Diklat SDM Koperasi</a></li>
                        <li><a href="#">Diklat SDM UKM</a></li>
                        <li><a href="#">Rumah Kemasan</a></li>
                    </ul>
                </div>

                <!-- Col 4: Badges Official ASN (BerAKHLAK & Bangga Melayani Bangsa) -->
                <div class="footer-col col-badges">

                    <!-- BerAKHLAK Badge -->
                    <div class="official-badge badge-berakhlak">
                        <div class="badge-inner">
                            <div class="berakhlak-text">
                                <span class="ber-red">Ber</span><span class="akhlak-red">AKHLAK</span>
                                <i class="fa-solid fa-chevron-right arrow-red"></i>
                            </div>
                            <p class="berakhlak-sub">Berorientasi Pelayanan Akuntabel Kompeten Harmonis Loyal Adaptif
                                Kolaboratif</p>
                        </div>
                    </div>

                    <!-- #bangga melayani bangsa Badge -->
                    <div class="official-badge badge-bangga">
                        <div class="badge-inner-bangga">
                            <div class="hashtag-red">#</div>
                            <div class="bangga-text-box">
                                <span class="b-line1">bangga</span>
                                <span class="b-line2">melayani</span>
                                <span class="b-line3">bangsa</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Footer Bottom Line & Copyright -->
            <div class="footer-bottom-bar">
                <div class="footer-brand-logo">
                    <div class="mini-jabar-emblem">
                        <svg viewBox="0 0 100 120" width="22" height="26">
                            <path d="M50 5 L90 25 V65 C90 90 50 115 50 115 C50 115 10 90 10 65 V25 Z" fill="#15803d"
                                stroke="#facc15" stroke-width="4" />
                        </svg>
                    </div>
                    <span class="footer-brand-title">Balatkop-uk</span>
                </div>

                <div class="copyright-text">
                    Copyright &copy; <span class="year-purple">2026</span> by Balatkop-uk Prov. Jabar
                </div>
            </div>

        </div>
    </footer>

    <script src="{{ asset('websites/js/script.js') }}"></script>
</body>

</html>
