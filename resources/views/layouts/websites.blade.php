<!DOCTYPE html>
<html lang="id">

@php
    // Pemilihan Gambar Background Hero — Dikelola melalui Admin Panel (Hero Banner)
    $fallbackImages = [
        'https://images.unsplash.com/photo-1577495508048-b635879837f1?q=80&w=1920&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=1920&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=1920&auto=format&fit=crop',
    ];

    if (!empty($heroBanners) && count($heroBanners) > 0) {
        $heroImages = $heroBanners->map(fn($b) => asset('storage/hero-banner/' . $b->gambar))->toArray();
    } else {
        $heroImages = $fallbackImages;
    }
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Preload Hero Image Pertama Agar Tampil Seketika / Cepat -->
    <link rel="preload" as="image" href="{{ $heroImages[0] }}">

    @php
        $siteTitle =
            $identitas->firstWhere('nama', 'Title Website')?->keterangan ??
            'Balai Pelatihan Koperasi & Usaha Kecil Prov. Kalsel';
        $siteDesc =
            'Website Resmi Balai Pelatihan Koperasi & Usaha Kecil Provinsi Kalimantan Selatan. Temukan informasi publik, layanan koperasi, layanan usaha kecil, dan info pelatihan.';

        $shareLogo = null;
        if ($logoItem = $identitas->firstWhere('nama', 'Logo Website')) {
            $shareLogo = asset('storage/header/' . $logoItem->keterangan);
        }
    @endphp

    <title>{{ $siteTitle }}</title>

    <link rel="shortcut icon" type="image/png"
        @if ($shortcut = $identitas->firstWhere('nama', 'Logo Shortcut')) href="{{ asset('storage/header/' . $shortcut->keterangan) }}" /> @endif <meta
        name="description" content="{{ $siteDesc }}">

    <!-- =========================================================
         OPEN GRAPH / WHATSAPP / FACEBOOK SHARE META TAGS
         ========================================================= -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $siteTitle }}">
    <meta property="og:description" content="{{ $siteDesc }}">
    @if ($shareLogo)
        <meta property="og:image" content="{{ $shareLogo }}">
        <meta property="og:image:secure_url" content="{{ $shareLogo }}">
        <meta property="og:image:type" content="image/png">
    @endif
    <meta property="og:site_name" content="BALATKOP-UK KALSEL">

    <!-- =========================================================
         TWITTER / X CARD META TAGS
         ========================================================= -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ $siteTitle }}">
    <meta name="twitter:description" content="{{ $siteDesc }}">
    @if ($shareLogo)
        <meta name="twitter:image" content="{{ $shareLogo }}">
    @endif
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Lora:ital,wght@0,600;0,700;1,600&family=Montserrat:wght@800;900&display=swap"
        rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tabler Icons for icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
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
                            <li><a href="#">Tentang</a></li>
                            <li><a href="#">Tugas & Fungsi</a></li>
                            <li><a href="#">Visi & Misi</a></li>
                            <li><a href="#">Struktur Organisasi</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link">LAYANAN <i
                                class="fa-solid font-chevron fa-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Dashboard Diklat</a></li>
                            <li><a href="#">Sertifikat Elektronik</a></li>
                        </ul>
                    </li>
                    <li class="nav-item active"><a href="#" class="nav-link">AGENDA</a></li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link">BERITA <i
                                class="fa-solid font-chevron fa-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Berita</a></li>
                            <li><a href="#">Artikel</a></li>
                            <li><a href="#">Info dan Tips</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link">GALERI <i
                                class="fa-solid font-chevron fa-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Foto</a></li>
                            <li><a href="#">Video</a></li>
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
                        <img src="{{ asset('storage/header/' . $logoright->keterangan) }}"
                            class="logo-img logo-white" style="height: 70px">
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
        <div class="hero-bg-slider" id="heroBgSlider">
            @foreach ($heroImages as $index => $imgUrl)
                <div class="hero-bg-slide {{ $index === 0 ? 'active' : '' }}"
                    style="background-image: url('{{ $imgUrl }}');"></div>
            @endforeach
        </div>

        <div class="bg-overlay"></div>

        <!-- Main Hero Content -->
        <main class="hero-content">
            <div class="hero-container">

                <!-- Welcome Tagline -->
                <div class="welcome-badge">
                    @foreach ($tagline as $item)
                        @if ($item->nama === 'Sambutan Dinas/UPTD')
                            <span>{{ $item->keterangan_1 }}</span>
                        @endif
                    @endforeach
                </div>

                <!-- Headline -->
                <h1 class="hero-title">
                    @foreach ($tagline as $item)
                        @if ($item->nama === 'Nama Dinas/UPTD')
                            @php
                                $titleRaw = $item->keterangan_1;
                                $titleFormatted = str_replace(
                                    [
                                        'Balai Pelatihan Koperasi dan Usaha Kecil Provinsi Kalimantan Selatan',
                                        'Balai Pelatihan Koperasi dan Usaha Kecil Prov. Kalsel',
                                    ],
                                    [
                                        'Balai Pelatihan Koperasi <br class="br-mobile">dan Usaha Kecil <br class="br-mobile">Provinsi Kalimantan Selatan',
                                        'Balai Pelatihan Koperasi <br class="br-mobile">dan Usaha Kecil <br class="br-mobile">Prov. Kalsel',
                                    ],
                                    $titleRaw,
                                );
                                if ($titleFormatted === $titleRaw) {
                                    $titleFormatted = str_replace(
                                        ['Koperasi dan Usaha Kecil', 'Koperasi Dan Usaha Kecil'],
                                        'Koperasi <br class="br-mobile">dan Usaha Kecil <br class="br-mobile">',
                                        $titleRaw,
                                    );
                                }
                            @endphp
                            {!! $titleFormatted !!}
                        @endif
                    @endforeach
                </h1>

                <!-- Subheadline -->
                @foreach ($tagline as $item)
                    @if ($item->nama === 'Motto Dinas/UPTD')
                        <p class="hero-subtitle">
                            {{ $item->keterangan_1 }}
                        </p>
                    @endif
                @endforeach

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
                        <span class="popular-label">Hashtag Populer</span>
                        <div class="tags-group">
                            <a href="#" class="tag-pill">#KOPERASIMODERN</a>
                            <a href="#" class="tag-pill">#UMKMNAIKKELAS</a>
                        </div>
                    </div>
                </div>

                <!-- Feature Quick Action Cards (3 Column) -->
                <div class="action-cards-grid">
                    <!-- Blue Card: Statistik Layanan -->
                    <a href="#" class="action-card card-blue">
                        <div class="card-icon-box">
                            <i class="fa-solid fa-chart-column"></i>
                        </div>
                        <span class="card-text">DASHBOARD DIKLAT</span>
                    </a>

                    <!-- Green Card: Layanan Usaha Kecil -->
                    <a href="#" class="action-card card-green">
                        <div class="card-icon-box">
                            <i class="fa-solid fa-ticket"></i>
                        </div>
                        <span class="card-text">SERTIFIKAT ELEKTRONIK</span>
                    </a>

                    <!-- Yellow/Gold Card: Info Pelatihan -->
                    <a href="#" class="action-card card-yellow">
                        <div class="card-icon-box">
                            <i class="fa-solid fa-calendar"></i>
                        </div>
                        <span class="card-text">AGENDA PELATIHAN</span>
                    </a>
                </div>

            </div>
        </main>
    </div>

    <!-- Sasirangan Pattern Slider Section Below Hero -->
    <section class="slider-section">
        <div class="sasirangan-bg"></div>
        <div class="slider-wrapper-container">

            <!-- Slider Carousel Box -->
            <div class="slider-carousel" id="autoSlider">
                <div class="slider-track" id="sliderTrack">

                    @forelse($infografis as $info)
                        <div class="slide-item">
                            <div class="full-banner-card">
                                @if ($info->link)
                                    <a href="{{ $info->link }}" target="_blank">
                                        <img src="{{ asset('storage/infografis/' . $info->gambar) }}"
                                            alt="{{ $info->judul }}" class="full-banner-img" loading="lazy"
                                            decoding="async">
                                    </a>
                                @else
                                    <img src="{{ asset('storage/infografis/' . $info->gambar) }}"
                                        alt="{{ $info->judul }}" class="full-banner-img" loading="lazy"
                                        decoding="async">
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="slide-item">
                            <div class="full-banner-card">
                                <img src="{{ asset('storage/slider/koperasi.jpg') }}" alt="Banner 1"
                                    class="full-banner-img">
                            </div>
                        </div>
                    @endforelse

                </div>

                <!-- Navigation Arrows -->
                <button class="slider-arrow prev-btn" id="prevBtn" aria-label="Previous Slide">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <button class="slider-arrow next-btn" id="nextBtn" aria-label="Next Slide">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>

            <!-- Pagination Dots (Below Banner Image) -->
            <div class="slider-dots" id="sliderDots">
                <!-- Dots will be populated by script.js -->
            </div>

        </div>
    </section>

    <!-- =========================================================
         TENTANG BALAI PELATIHAN / TUGAS & FUNGSI SECTION
         ========================================================= -->
    <section class="about-overview-section">
        <div class="about-overview-container">
            <div class="about-overview-grid">

                <!-- Left Column: Intro & Headline -->
                <div class="about-overview-left">
                    <span class="about-tagline-pill">TENTANG</span>
                    <h2 class="about-overview-title">Balai Pelatihan Koperasi & Usaha Kecil Prov. Kalsel</h2>

                    <p class="about-overview-lead">
                        adalah unit pelaksana teknis di bawah Dinas Koperasi dan UKM Provinsi Kalimantan Selatan
                    </p>

                    <div class="about-accent-box">
                        <p>
                            yang memiliki fungsi utama sebagai pusat pendidikan dan pelatihan untuk pengembangan sumber
                            daya manusia (SDM) koperasi dan pelaku usaha kecil di Provinsi Kalimantan Selatan.
                        </p>
                    </div>

                    <div class="about-btn-wrap">
                        <a href="#" class="btn-outline-blue">
                            <span>SELENGKAPNYA</span>
                            <i class="fa-solid fa-arrow-right-long ms-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Right Column: 4 Feature Cards Grid -->
                <div class="about-overview-right">
                    <div class="about-cards-grid">

                        <!-- Card 1 -->
                        <div class="about-feature-card">
                            <div class="feature-icon-box icon-blue">
                                <i class="fa-solid fa-chalkboard-user"></i>
                            </div>
                            <h3 class="feature-card-title">Menyelenggarakan Pelatihan</h3>
                            <p class="feature-card-desc">
                                Kegiatan Pelatihan teknis dan manajerial untuk meningkatkan keterampilan SDM Koperasi
                                dan UMKM
                            </p>
                        </div>

                        <!-- Card 2 -->
                        <div class="about-feature-card">
                            <div class="feature-icon-box icon-amber">
                                <i class="fa-solid fa-lightbulb"></i>
                            </div>
                            <h3 class="feature-card-title">Meningkatkan Kapasitas SDM</h3>
                            <p class="feature-card-desc">
                                Mengembangkan kompetensi pelaku Koperasi dan UMKM agar lebih profesional, produktif dan
                                mampu bersaing di pasar hingga era digital
                            </p>
                        </div>

                        <!-- Card 3 -->
                        <div class="about-feature-card">
                            <div class="feature-icon-box icon-teal">
                                <i class="fa-solid fa-book-open-reader"></i>
                            </div>
                            <h3 class="feature-card-title">Fasilitasi Pembinaan dan Pendampingan</h3>
                            <p class="feature-card-desc">
                                Berperan dalam membantu pendampingan, konsultasi, dan bimbingan teknis pasca pelatihan
                                SDM Koperasi dan UMKM
                            </p>
                        </div>

                        <!-- Card 4 -->
                        <div class="about-feature-card">
                            <div class="feature-icon-box icon-indigo">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                            <h3 class="feature-card-title">Mendorong Transformasi Koperasi dan UMKM</h3>
                            <p class="feature-card-desc">
                                Mendorong Transformasi Koperasi dan UMKM agar adaptif, inovatif, dan berdaya saing
                                tinggi
                            </p>
                        </div>

                    </div>
                </div>

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
                <h2 class="links-main-title">Link Terkait</h2>
            </div>

            @php
                // Build a robust set of items for the infinite marquee
                $baseItems = $linkTerkait->count() > 0 ? $linkTerkait : collect([]);

                if ($baseItems->count() > 0) {
                    $set1 = collect();
                    while ($set1->count() < 8) {
                        $set1 = $set1->concat($baseItems);
                    }
                } else {
                    $set1 = collect();
                }
            @endphp

            <!-- Infinite Auto-Scrolling Marquee Container -->
            <div class="partner-marquee-container" id="partnerMarquee">
                <div class="partner-marquee-track">

                    @if ($set1->count() > 0)
                        {{-- First Half (Set 1) --}}
                        @foreach ($set1 as $linkItem)
                            <a href="{{ $linkItem->url ?? '#' }}" target="_blank" class="partner-logo-item"
                                title="{{ $linkItem->nama }}">
                                <div class="logo-box">
                                    @if ($linkItem->gambar)
                                        <img src="{{ asset('storage/link-terkait/' . $linkItem->gambar) }}"
                                            alt="{{ $linkItem->nama }}"
                                            style="max-height: 48px; max-width: 140px; object-fit: contain;">
                                    @else
                                        <div class="portal-symbol">
                                            <i class="fa-solid fa-globe"></i>
                                        </div>
                                        <div class="portal-text-col">
                                            <span class="portal-bold">{{ $linkItem->nama }}</span>
                                        </div>
                                    @endif
                                </div>
                            </a>
                        @endforeach

                        {{-- Second Half (Set 2 - Exact Duplicate for Seamless Infinite Loop) --}}
                        @foreach ($set1 as $linkItem)
                            <a href="{{ $linkItem->url ?? '#' }}" target="_blank" class="partner-logo-item"
                                title="{{ $linkItem->nama }}">
                                <div class="logo-box">
                                    @if ($linkItem->gambar)
                                        <img src="{{ asset('storage/link-terkait/' . $linkItem->gambar) }}"
                                            alt="{{ $linkItem->nama }}"
                                            style="max-height: 48px; max-width: 140px; object-fit: contain;">
                                    @else
                                        <div class="portal-symbol">
                                            <i class="fa-solid fa-globe"></i>
                                        </div>
                                        <div class="portal-text-col">
                                            <span class="portal-bold">{{ $linkItem->nama }}</span>
                                        </div>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    @else
                        {{-- Fallback default logos set if DB is empty --}}
                        @for ($i = 0; $i < 2; $i++)
                            <a href="https://kemenkopukm.go.id" target="_blank" class="partner-logo-item"
                                title="Kementerian Koperasi dan UKM RI">
                                <div class="logo-box">
                                    <div class="kemenkop-symbol"><i class="fa-solid fa-dharmachakra"></i></div>
                                    <div class="logo-text-col">
                                        <span class="logo-bold-title">KEMEN<br>KOPUKM</span>
                                        <span class="logo-tiny-sub">Kementerian Koperasi Dan UKM<br>Republik
                                            Indonesia</span>
                                    </div>
                                </div>
                            </a>
                            <a href="https://smesco.go.id" target="_blank" class="partner-logo-item"
                                title="Smesco Indonesia">
                                <div class="logo-box">
                                    <div class="smesco-symbol">S</div>
                                    <span class="smesco-title">smesco</span>
                                </div>
                            </a>
                            <a href="#" class="partner-logo-item" title="Balatkop Kalsel">
                                <div class="logo-box">
                                    <div class="portal-symbol"><i class="fa-solid fa-building-columns"></i></div>
                                    <div class="portal-text-col">
                                        <span class="portal-sub">BALATKOP</span>
                                        <span class="portal-bold">KALSEL</span>
                                    </div>
                                </div>
                            </a>
                            <a href="https://kalselprov.go.id" target="_blank" class="partner-logo-item"
                                title="Pemprov Kalsel">
                                <div class="logo-box">
                                    <div class="portal-symbol"><i class="fa-solid fa-cubes"></i></div>
                                    <div class="portal-text-col">
                                        <span class="portal-sub">PORTAL</span>
                                        <span class="portal-bold">KALSELPROV</span>
                                    </div>
                                </div>
                            </a>
                        @endfor
                    @endif

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
                <span class="news-sub-tagline">PUSAT INFORMASI KOPERASI DAN USAHA KECIL DI PROVINSI KALIMANTAN
                    SELATAN</span>
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

                <!-- Left Column: Tabs Content (Berita, Foto, Video) -->
                <div class="news-left-column">

                    <!-- TAB 1: BERITA TERBARU -->
                    <div class="tab-content-pane active" id="tab-berita">
                        <div class="news-cards-wrapper">
                            @forelse($beritaTerbaru as $b)
                                @php
                                    $jenisIcon = 'ti ti-article';
                                    $jenisLower = strtolower($b->jenis ?? '');
                                    if (str_contains($jenisLower, 'artikel')) {
                                        $jenisIcon = 'ti ti-file-text';
                                    } elseif (str_contains($jenisLower, 'info') || str_contains($jenisLower, 'tips')) {
                                        $jenisIcon = 'ti ti-bulb';
                                    }
                                @endphp
                                <article class="news-card">
                                    <div class="news-image-box">
                                        <a href="#" class="news-img-link" title="Baca Selengkapnya">
                                            @if ($b->thumbnail)
                                                <img src="{{ asset('storage/post/thumbnail/' . $b->thumbnail) }}"
                                                    alt="{{ $b->judul }}" loading="lazy" decoding="async"
                                                    style="width:100%; height:100%; object-fit:cover;">
                                            @else
                                                <div class="placeholder-img-bg bg-gradient-1">
                                                    <i class="fa-solid fa-newspaper placeholder-icon"></i>
                                                </div>
                                            @endif
                                            <div class="blue-overlay-hover">
                                                <div class="read-more-btn">
                                                    <i class="fa-solid fa-book-open"></i>
                                                    <span>Baca Selengkapnya</span>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="date-badge">
                                            <span
                                                class="day-text">{{ $b->created_at ? $b->created_at->format('d') : '01' }}</span>
                                            <span
                                                class="month-text">{{ $b->created_at ? $bulanIndo[(int) $b->created_at->format('m')] . ' ' . $b->created_at->format('Y') : 'JAN 2026' }}</span>
                                        </div>
                                    </div>
                                    <div class="news-details">
                                        <span class="news-category-label">
                                            <i class="{{ $jenisIcon }} me-1"></i>
                                            {{ strtoupper($b->jenis ?? 'BERITA') }} &bull;
                                            {{ strtoupper($b->kategori?->kategori ?? 'KATEGORI') }}
                                        </span>
                                        <h3 class="news-title">
                                            <a href="#">{{ $b->judul }}</a>
                                        </h3>
                                    </div>
                                </article>
                            @empty
                                <article class="news-card">
                                    <div class="news-image-box">
                                        <a href="#" class="news-img-link" title="Baca Selengkapnya">
                                            <div class="placeholder-img-bg bg-gradient-1">
                                                <i class="fa-solid fa-people-roof placeholder-icon"></i>
                                            </div>
                                            <div class="blue-overlay-hover">
                                                <div class="read-more-btn">
                                                    <i class="fa-solid fa-book-open"></i>
                                                    <span>Baca Selengkapnya</span>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="date-badge">
                                            <span class="day-text">24</span>
                                            <span class="month-text">JUL 2026</span>
                                        </div>
                                    </div>
                                    <div class="news-details">
                                        <span class="news-category-label"><i class="ti ti-article me-1"></i> BERITA
                                            &bull; UMKM</span>
                                        <h3 class="news-title">
                                            <a href="#">Pendampingan Digitalisasi dan Fasilitasi Legalitas Usaha
                                                Mikro Kalimantan Selatan</a>
                                        </h3>
                                    </div>
                                </article>
                            @endforelse
                        </div>

                        <div class="more-news-btn-wrap">
                            <a href="#" class="btn-outline-blue">BERITA LAINNYA</a>
                        </div>
                    </div>

                    <!-- TAB 2: GALERI FOTO -->
                    <div class="tab-content-pane" id="tab-foto" style="display: none;">
                        <div class="news-cards-wrapper">
                            @forelse($galeriFoto as $f)
                                @php
                                    $coverFoto = $f->galeri->first()?->gambar
                                        ? asset('storage/post/galeri/' . $f->galeri->first()->gambar)
                                        : ($f->thumbnail
                                            ? asset('storage/post/thumbnail/' . $f->thumbnail)
                                            : null);
                                    $totalFoto = $f->galeri->count();
                                @endphp
                                <article class="news-card">
                                    <div class="news-image-box">
                                        <a href="#" class="news-img-link"
                                            title="Lihat Galeri Foto ({{ $totalFoto }} Foto)">
                                            @if ($coverFoto)
                                                <img src="{{ $coverFoto }}" alt="{{ $f->judul }}"
                                                    loading="lazy" decoding="async"
                                                    style="width:100%; height:100%; object-fit:cover;">
                                            @else
                                                <div class="placeholder-img-bg bg-gradient-2">
                                                    <i class="fa-solid fa-images placeholder-icon"></i>
                                                </div>
                                            @endif
                                            <div class="blue-overlay-hover">
                                                <div class="read-more-btn">
                                                    <i class="fa-solid fa-images"></i>
                                                    <span>Lihat {{ $totalFoto }} Foto</span>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="date-badge">
                                            <span
                                                class="day-text">{{ $f->created_at ? $f->created_at->format('d') : '01' }}</span>
                                            <span
                                                class="month-text">{{ $f->created_at ? $bulanIndo[(int) $f->created_at->format('m')] . ' ' . $f->created_at->format('Y') : 'JAN 2026' }}</span>
                                        </div>
                                    </div>
                                    <div class="news-details">
                                        <span
                                            class="news-category-label">{{ $f->kategori?->kategori ?? 'GALERI FOTO' }}
                                            &bull; {{ $totalFoto }} FOTO</span>
                                        <h3 class="news-title">
                                            <a href="#">{{ $f->judul }}</a>
                                        </h3>
                                    </div>
                                </article>
                            @empty
                                <article class="news-card">
                                    <div class="news-image-box">
                                        <a href="#" class="news-img-link" title="Lihat Foto">
                                            <div class="placeholder-img-bg bg-gradient-2">
                                                <i class="fa-solid fa-images placeholder-icon"></i>
                                            </div>
                                            <div class="blue-overlay-hover">
                                                <div class="read-more-btn">
                                                    <i class="fa-solid fa-image"></i>
                                                    <span>Lihat Foto</span>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="date-badge">
                                            <span class="day-text">24</span>
                                            <span class="month-text">JUL 2026</span>
                                        </div>
                                    </div>
                                    <div class="news-details">
                                        <span class="news-category-label">GALERI FOTO</span>
                                        <h3 class="news-title">
                                            <a href="#">Kegiatan Pelatihan dan Pendampingan Koperasi & UMKM
                                                Juara</a>
                                        </h3>
                                    </div>
                                </article>
                            @endforelse
                        </div>

                        <div class="more-news-btn-wrap">
                            <a href="#" class="btn-outline-blue">FOTO LAINNYA</a>
                        </div>
                    </div>

                    <!-- TAB 3: GALERI VIDEO -->
                    <div class="tab-content-pane" id="tab-video" style="display: none;">
                        <div class="news-cards-wrapper">
                            @forelse($galeriVideo as $v)
                                <article class="news-card">
                                    <div class="news-image-box">
                                        <a href="https://www.youtube.com/watch?v={{ $v->youtube_id }}"
                                            class="news-img-link" title="Putar Video" target="_blank">
                                            <img src="https://img.youtube.com/vi/{{ $v->youtube_id }}/hqdefault.jpg"
                                                alt="{{ $v->judul }}" loading="lazy" decoding="async"
                                                style="width:100%; height:100%; object-fit:cover;">
                                            <div class="blue-overlay-hover">
                                                <div class="read-more-btn">
                                                    <i class="fa-solid fa-circle-play"></i>
                                                    <span>Putar Video</span>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="date-badge">
                                            <span
                                                class="day-text">{{ $v->created_at ? $v->created_at->format('d') : '01' }}</span>
                                            <span
                                                class="month-text">{{ $v->created_at ? $bulanIndo[(int) $v->created_at->format('m')] . ' ' . $v->created_at->format('Y') : 'JAN 2026' }}</span>
                                        </div>
                                    </div>
                                    <div class="news-details">
                                        <span
                                            class="news-category-label">{{ $v->kategori?->kategori ?? 'VIDEO' }}</span>
                                        <h3 class="news-title">
                                            <a href="https://www.youtube.com/watch?v={{ $v->youtube_id }}"
                                                target="_blank">{{ $v->judul }}</a>
                                        </h3>
                                    </div>
                                </article>
                            @empty
                                <article class="news-card">
                                    <div class="news-image-box">
                                        <a href="#" class="news-img-link" title="Putar Video">
                                            <div class="placeholder-img-bg bg-gradient-3">
                                                <i class="fa-solid fa-video placeholder-icon"></i>
                                            </div>
                                            <div class="blue-overlay-hover">
                                                <div class="read-more-btn">
                                                    <i class="fa-solid fa-circle-play"></i>
                                                    <span>Putar Video</span>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="date-badge">
                                            <span class="day-text">24</span>
                                            <span class="month-text">JUL 2026</span>
                                        </div>
                                    </div>
                                    <div class="news-details">
                                        <span class="news-category-label">GALERI VIDEO</span>
                                        <h3 class="news-title">
                                            <a href="#">Dokumentasi Video Kegiatan Balatkop Kalsel</a>
                                        </h3>
                                    </div>
                                </article>
                            @endforelse
                        </div>

                        <div class="more-news-btn-wrap">
                            <a href="#" class="btn-outline-blue">VIDEO LAINNYA</a>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Berita Terpopuler Sidebar -->
                <aside class="news-right-sidebar">
                    <h3 class="sidebar-heading">Berita Terpopuler</h3>

                    <div class="popular-list">
                        @forelse($beritaTerpopuler as $index => $pop)
                            @php
                                $thumbClasses = [
                                    'thumb-blue',
                                    'thumb-teal',
                                    'thumb-red',
                                    'thumb-purple',
                                    'thumb-green',
                                    'thumb-orange',
                                ];
                                $bgClass = $thumbClasses[$index % count($thumbClasses)];

                                $jenisLower = strtolower($pop->jenis ?? '');
                                $icon = 'fa-file-signature';
                                if (str_contains($jenisLower, 'artikel')) {
                                    $icon = 'fa-newspaper';
                                } elseif (str_contains($jenisLower, 'info') || str_contains($jenisLower, 'tips')) {
                                    $icon = 'fa-lightbulb';
                                }
                            @endphp
                            <a href="#" class="popular-item" title="{{ $pop->judul }}">
                                <div class="popular-thumb-link">
                                    @if ($pop->thumbnail)
                                        <img src="{{ asset('storage/post/thumbnail/' . $pop->thumbnail) }}"
                                            alt="{{ $pop->judul }}" loading="lazy" decoding="async"
                                            style="width:100%; height:100%; object-fit:cover; border-radius:12px;">
                                    @else
                                        <div class="popular-thumb-box {{ $bgClass }}">
                                            <i class="fa-solid {{ $icon }}"></i>
                                        </div>
                                    @endif
                                    <div class="blue-overlay-hover"></div>
                                </div>
                                <div class="popular-info">
                                    <div class="popular-meta" style="display: flex; align-items: center; gap: 8px;">
                                        <span class="popular-date">
                                            {{ $pop->created_at ? $pop->created_at->format('d') . ' ' . $bulanIndo[(int) $pop->created_at->format('m')] . ' ' . $pop->created_at->format('Y') : '' }}
                                        </span>
                                    </div>
                                    <h4 class="popular-title">
                                        {{ $pop->judul }}
                                    </h4>
                                </div>
                            </a>
                        @empty
                            <p style="font-size: 0.85rem; color: #64748b;">Belum ada berita populer.</p>
                        @endforelse
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
                    @if ($textagenda = $tagline->firstWhere('nama', 'Kalimat Agenda'))
                        <span class="agenda-sub-tagline">{{ strtoupper($textagenda->keterangan_1) }}</span>
                    @endif
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

                    @forelse($agendas as $a)
                        @php
                            $tglAwal = $a->tgl_awal ? \Carbon\Carbon::parse($a->tgl_awal) : null;
                            $tglAkhirObj = $a->tgl_akhir ? \Carbon\Carbon::parse($a->tgl_akhir) : null;

                            $day = '01';
                            $month = 'JAN';

                            if ($tglAwal) {
                                $day = $tglAwal->format('d');
                                $month = $bulanIndo[(int) $tglAwal->format('m')] ?? 'JAN';

                                if ($tglAkhirObj && $tglAkhirObj->format('Y-m-d') !== $tglAwal->format('Y-m-d')) {
                                    if ($tglAwal->format('m-Y') === $tglAkhirObj->format('m-Y')) {
                                        $day = $tglAwal->format('d') . '-' . $tglAkhirObj->format('d');
                                    }
                                }
                            }

                            // Format tanggal awal s.d. tanggal akhir full angka (dd/mm/yyyy)
                            $formattedDate = '-';
                            if ($tglAwal) {
                                $formattedDate = $tglAwal->format('d/m/Y');

                                if ($tglAkhirObj && $tglAkhirObj->format('Y-m-d') !== $tglAwal->format('Y-m-d')) {
                                    $formattedDate .= ' - ' . $tglAkhirObj->format('d/m/Y');
                                }
                            }

                            $jamText = '';
                            if ($a->jam_mulai) {
                                $jamMulai = \Carbon\Carbon::parse($a->jam_mulai)->format('H:i');
                                $jamText = $jamMulai;
                                if ($a->jam_akhir) {
                                    $jamAkhir = \Carbon\Carbon::parse($a->jam_akhir)->format('H:i');
                                    $jamText .= ' - ' . $jamAkhir;
                                }
                            }

                            $now = \Carbon\Carbon::now();
                            $tglAkhirVal = $tglAkhirObj
                                ? $tglAkhirObj->copy()->endOfDay()
                                : ($tglAwal
                                    ? $tglAwal->copy()->endOfDay()
                                    : null);

                            $statusText = 'Belum Dimulai';
                            $statusClass = 'status-upcoming';

                            if ($tglAwal && $tglAkhirVal) {
                                if ($now->between($tglAwal->copy()->startOfDay(), $tglAkhirVal)) {
                                    $statusText = 'Sedang Berlangsung';
                                    $statusClass = 'status-active';
                                } elseif ($now->gt($tglAkhirVal)) {
                                    $statusText = 'Selesai';
                                    $statusClass = 'status-ended';
                                }
                            }
                        @endphp
                        <div class="agenda-card">
                            <div class="agenda-card-top">
                                <div class="agenda-date-box">
                                    <div class="agenda-day"
                                        style="{{ strlen($day) > 2 ? 'font-size: 1.05rem; padding: 10px 2px 4px;' : '' }}">
                                        {{ $day }}</div>
                                    <div class="agenda-month">{{ $month }}</div>
                                </div>
                                <div class="agenda-body">
                                    <span class="status-pill {{ $statusClass }}">{{ $statusText }}</span>
                                    <h3 class="agenda-card-title">
                                        <a href="#">{{ $a->nama }}</a>
                                    </h3>
                                </div>
                            </div>
                            <div class="agenda-meta">
                                <span class="meta-item" title="Tanggal Agenda">
                                    <i class="fa-regular fa-calendar-check"></i> {{ $formattedDate }}
                                </span>
                                @if ($jamText)
                                    <span class="meta-item" title="Waktu Agenda">
                                        <i class="fa-regular fa-clock"></i> {{ $jamText }} WIB
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="agenda-card" style="width: 100%;">
                            <div class="agenda-body" style="text-align: center; padding: 20px;">
                                <p style="color: #64748b; margin: 0;">Belum ada agenda kegiatan.</p>
                            </div>
                        </div>
                    @endforelse

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
                    @if ($textproduk = $tagline->firstWhere('nama', 'Kalimat Produk UMKM'))
                        <span class="products-sub-tagline">{{ $textproduk->keterangan_1 }}</span>
                    @endif
                    <h2 class="products-main-title">Produk UMKM<br>Kalimantan Selatan</h2>

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
                                    <p class="product-location">KAB TANAH LAUT, Kalimantan Selatan</p>
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
                                    <p class="product-location">KAB BANJAR, Kalimantan Selatan</p>
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
                                    <p class="product-location">KAB TABALONG, Kalimantan Selatan</p>
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
                    Copyright &copy; <span class="year-purple">2026</span> by Balatkop-uk Prov. Kalimantan Selatan
                </div>
            </div>

        </div>
    </footer>

    <script src="{{ asset('websites/js/script.js') }}"></script>
</body>

</html>
