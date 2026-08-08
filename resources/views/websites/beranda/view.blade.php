@extends('layouts.websites')

@php
    $heroImages = $heroImages ?? [
        'https://images.unsplash.com/photo-1577495508048-b635879837f1?q=80&w=1920&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=1920&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=1920&auto=format&fit=crop',
    ];
@endphp

@section('content')
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
                    <form class="search-form" id="searchForm" action="{{ url('/informasi') }}" method="GET">
                        <input type="text" id="searchInput" name="q" class="search-input"
                            placeholder="Cari informasi . . ." autocomplete="off">
                        <button type="submit" class="search-btn" aria-label="Cari">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>

                    <!-- Popular Searches / Hashtags -->
                    <div class="popular-search-bar">
                        <span class="popular-label">Hashtag Populer</span>
                        <div class="tags-group">
                            <a href="{{ url('/informasi?q=KOPERASIMODERN') }}" class="tag-pill">#KOPERASIMODERN</a>
                            <a href="{{ url('/informasi?q=UMKMNAIKKELAS') }}" class="tag-pill">#UMKMNAIKKELAS</a>
                        </div>
                    </div>
                </div>

                <!-- Feature Quick Action Cards (3 Column) -->
                <div class="action-cards-grid">
                    <!-- Blue Card: Dashboard Diklat -->
                    <a href="{{ url('/layanan/dashboard-diklat') }}" class="action-card card-blue">
                        <div class="card-icon-box">
                            <i class="fa-solid fa-chart-column"></i>
                        </div>
                        <span class="card-text">DASHBOARD DIKLAT</span>
                    </a>

                    <!-- Green Card: Identifikasi Diklat -->
                    <a href="{{ url('/layanan/identifikasi-kebutuhan-diklat') }}" class="action-card card-green">
                        <div class="card-icon-box">
                            <i class="fa-solid fa-file-pen"></i>
                        </div>
                        <span class="card-text">IDENTIFIKASI DIKLAT</span>
                    </a>

                    <!-- Yellow/Gold Card: Layanan Lainnya Trigger Button -->
                    <button type="button" class="action-card card-yellow" id="openLayananLainnyaBtn"
                        style="border:none; outline:none; cursor:pointer; font-family:inherit;">
                        <div class="card-icon-box">
                            <i class="fa-solid fa-border-all"></i>
                        </div>
                        <span class="card-text">LAYANAN LAINNYA</span>
                    </button>
                </div>

            </div>
        </main>
    </div>

    <!-- MODAL LAYANAN LAINNYA DIALOG -->
    <div class="layanan-modal-overlay" id="layananLainnyaModal" aria-hidden="true">
        <div class="layanan-modal-backdrop" id="layananModalBackdrop"></div>
        <div class="layanan-modal-dialog">
            <div class="layanan-modal-content">
                <!-- Modal Header -->
                <div class="layanan-modal-header">
                    <div class="modal-header-title">
                        <div class="modal-header-icon-box">
                            <i class="fa-solid fa-layer-group text-blue"></i>
                        </div>
                        <div>
                            <h3 class="modal-main-heading">Portal Layanan Balatkop-UK</h3>
                            <p class="modal-sub-heading">Pilih jenis layanan publik digital yang Anda butuhkan</p>
                        </div>
                    </div>
                    <button type="button" class="layanan-modal-close" id="layananModalClose" aria-label="Tutup">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Modal Body: Services Grid (2 Columns) -->
                <div class="layanan-modal-body">
                    <div class="layanan-grid-container">

                        <!-- Item 1: Dashboard Diklat -->
                        <a href="{{ url('/layanan/dashboard-diklat') }}" class="layanan-item-card">
                            <div class="layanan-item-icon-box bg-icon-blue">
                                <i class="fa-solid fa-chart-column"></i>
                            </div>
                            <div class="layanan-item-info">
                                <h4 class="layanan-item-title">Dashboard Diklat</h4>
                                <p class="layanan-item-desc">Informasi & statistik data pelatihan Koperasi dan UMKM.</p>
                            </div>
                            <i class="fa-solid fa-chevron-right layanan-arrow-icon"></i>
                        </a>

                        <!-- Item 2: Pemanfaatan Fasilitas -->
                        <a href="{{ url('/layanan/pemanfaatan-fasilitas') }}" class="layanan-item-card">
                            <div class="layanan-item-icon-box bg-icon-emerald">
                                <i class="fa-solid fa-building-user"></i>
                            </div>
                            <div class="layanan-item-info">
                                <h4 class="layanan-item-title">Pemanfaatan Fasilitas</h4>
                                <p class="layanan-item-desc">Sewa & reservasi gedung, aula, wisma, atau ruang pelatihan.</p>
                            </div>
                            <i class="fa-solid fa-chevron-right layanan-arrow-icon"></i>
                        </a>

                        <!-- Item 3: Layanan Kemasan -->
                        <a href="https://pusatlayanankemasankalsel.com/" target="_blank" rel="noopener noreferrer"
                            class="layanan-item-card">
                            <div class="layanan-item-icon-box bg-icon-amber">
                                <i class="fa-solid fa-box-open"></i>
                            </div>
                            <div class="layanan-item-info">
                                <h4 class="layanan-item-title">
                                    Layanan Kemasan <i
                                        class="fa-solid fa-arrow-up-right-from-square external-link-icon"></i>
                                </h4>
                                <p class="layanan-item-desc">Pusat desain & konsultasi rumah kemasan UMKM Kalsel.</p>
                            </div>
                            <i class="fa-solid fa-chevron-right layanan-arrow-icon"></i>
                        </a>

                        <!-- Item 4: Identifikasi Kebutuhan Pelatihan -->
                        <a href="{{ url('/layanan/identifikasi-kebutuhan-diklat') }}" class="layanan-item-card">
                            <div class="layanan-item-icon-box bg-icon-purple">
                                <i class="fa-solid fa-clipboard-list"></i>
                            </div>
                            <div class="layanan-item-info">
                                <h4 class="layanan-item-title">Identifikasi Kebutuhan Pelatihan</h4>
                                <p class="layanan-item-desc">Pengisian formulir kebutuhan diklat bagi pengurus/UMKM.</p>
                            </div>
                            <i class="fa-solid fa-chevron-right layanan-arrow-icon"></i>
                        </a>

                        <!-- Item 5: Sertifikat Elektronik -->
                        <a href="{{ url('/layanan/sertifikat-elektronik') }}" class="layanan-item-card">
                            <div class="layanan-item-icon-box bg-icon-rose">
                                <i class="fa-solid fa-certificate"></i>
                            </div>
                            <div class="layanan-item-info">
                                <h4 class="layanan-item-title">Sertifikat Elektronik</h4>
                                <p class="layanan-item-desc">Verifikasi keabsahan & download e-sertifikat alumni diklat.</p>
                            </div>
                            <i class="fa-solid fa-chevron-right layanan-arrow-icon"></i>
                        </a>

                        <!-- Item 6: Survei Kepuasan Diklat -->
                        <a href="{{ url('/layanan/survei-kepuasan-diklat') }}" class="layanan-item-card">
                            <div class="layanan-item-icon-box bg-icon-indigo">
                                <i class="fa-solid fa-square-poll-vertical"></i>
                            </div>
                            <div class="layanan-item-info">
                                <h4 class="layanan-item-title">Survei Kepuasan Diklat (SKM)</h4>
                                <p class="layanan-item-desc">Penilaian indeks kepuasan masyarakat atas pelayanan diklat.</p>
                            </div>
                            <i class="fa-solid fa-chevron-right layanan-arrow-icon"></i>
                        </a>

                    </div>
                </div>
            </div>
        </div>
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
                                        alt="{{ $info->judul }}" class="full-banner-img" loading="lazy" decoding="async">
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

    <!-- TENTANG BALAI PELATIHAN / TUGAS & FUNGSI SECTION -->
    <section class="about-overview-section">
        <div class="about-overview-container">
            <div class="about-overview-grid">

                <!-- Left Column: Intro & Headline -->
                <div class="about-overview-left">
                    <span class="about-tagline-pill">TENTANG</span>
                    @if ($kalimatTentang = $tagline->firstWhere('nama', 'Kalimat Tentang'))
                        <h2 class="about-overview-title">{{ $kalimatTentang->keterangan_1 }}</h2>
                    @endif

                    @if ($kalimatTugas = $tagline->firstWhere('nama', 'Kalimat Tugas'))
                        <p class="about-overview-lead">
                            {{ $kalimatTugas->keterangan_1 }}
                        </p>
                    @endif

                    @if ($kalimatFungsi = $tagline->firstWhere('nama', 'Kalimat Fungsi'))
                        <div class="about-accent-box">
                            <p>
                                {{ $kalimatFungsi->keterangan_1 }}
                            </p>
                        </div>
                    @endif

                    <div class="about-btn-wrap">
                        <a href="#" class="btn-outline-blue">
                            <span>SELENGKAPNYA</span>
                            <i class="fa-solid fa-arrow-right-long ms-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Right Column: Feature Cards Grid (Connected to Beranda Table where jenis = Card) -->
                <div class="about-overview-right">
                    <div class="about-cards-grid">
                        @foreach ($tagline->where('jenis', 'Card') as $card)
                            <div class="about-feature-card">
                                <div
                                    class="feature-icon-box {{ ['icon-blue', 'icon-amber', 'icon-teal', 'icon-indigo'][$loop->index % 4] }}">
                                    <i
                                        class="{{ ['fa-solid fa-chalkboard-user', 'fa-solid fa-lightbulb', 'fa-solid fa-book-open-reader', 'fa-solid fa-chart-line'][$loop->index % 4] }}"></i>
                                </div>
                                <h3 class="feature-card-title">{{ $card->keterangan_1 }}</h3>
                                <p class="feature-card-desc">{{ $card->keterangan_2 }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- LINK TERKAIT (PARTNER LOGOS MARQUEE) SECTION -->
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
                                            alt="{{ $linkItem->nama }}" class="partner-logo-img">
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
                                            alt="{{ $linkItem->nama }}" class="partner-logo-img">
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

    <!-- PUSAT INFORMASI / BERITA TERKINI SECTION -->
    <section class="news-info-section">
        <div class="news-container">

            <!-- Section Header Titles -->
            <div class="news-header">
                <span class="news-sub-tagline">PUSAT INFORMASI KOPERASI DAN USAHA KECIL DI PROVINSI KALIMANTAN
                    SELATAN</span>
                <h2 class="news-main-title">Informasi Terkini</h2>
            </div>

            <!-- Tab Navigation & Filter -->
            <div class="news-tabs-bar">
                <div class="tabs-group">
                    <button class="news-tab-btn active" data-tab="berita">Informasi Terbaru</button>
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
                                        <a href="{{ route('website.informasi.detail', $b->slug ?? $b->id_post) }}"
                                            class="news-img-link" title="Baca Selengkapnya">
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
                                            <span class="month-text">{{ bulan_indo($b->created_at) }}
                                                {{ $b->created_at ? $b->created_at->format('Y') : '2026' }}</span>
                                        </div>
                                    </div>
                                    <div class="news-details">
                                        <span class="news-category-label">
                                            <i class="{{ $jenisIcon }} me-1"></i>
                                            {{ strtoupper($b->jenis ?? 'BERITA') }}
                                            @if ($b->kategori)
                                                &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-folder-open me-1"></i>
                                                {{ strtoupper($b->kategori->kategori) }}
                                            @endif
                                        </span>
                                        <h3 class="news-title">
                                            <a
                                                href="{{ route('website.informasi.detail', $b->slug ?? $b->id_post) }}">{{ $b->judul }}</a>
                                        </h3>
                                        @php
                                            $rawSummary = !empty(trim($b->ringkasan ?? '')) ? $b->ringkasan : $b->isi;
                                            $cleanSummary = trim(html_entity_decode(strip_tags($rawSummary ?? '')));
                                        @endphp
                                        <p class="news-excerpt">
                                            {{ Str::limit($cleanSummary, 120) }}
                                        </p>
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
                                        <span class="news-category-label"><i
                                                class="ti ti-article me-1"></i>BERITA&nbsp;&nbsp;<i
                                                class="fa-solid fa-folder-open me-1"></i>UMKM</span>
                                        <h3 class="news-title">
                                            <a href="#">Pendampingan Digitalisasi dan Fasilitasi Legalitas Usaha
                                                Mikro Kalimantan Selatan</a>
                                        </h3>
                                        <p class="news-excerpt">
                                            Balai Pelatihan Koperasi dan Usaha Kecil Provinsi Kalimantan Selatan
                                            menyelenggarakan pendampingan digitalisasi dan fasilitasi legalitas usaha mikro.
                                        </p>
                                    </div>
                                </article>
                            @endforelse
                        </div>

                        <div class="more-news-btn-wrap">
                            <a href="{{ url('/informasi') }}" class="btn-outline-blue">INFORMASI LAINNYA</a>
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
                                        <a href="{{ route('website.galeri.detail', $f->slug ?? $f->id_post) }}"
                                            class="news-img-link" title="Lihat Galeri Foto ({{ $totalFoto }} Foto)">
                                            @if ($coverFoto)
                                                <img src="{{ $coverFoto }}" alt="{{ $f->judul }}" loading="lazy"
                                                    decoding="async" style="width:100%; height:100%; object-fit:cover;">
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
                                        <span class="news-category-label">{{ $f->kategori?->kategori ?? 'GALERI FOTO' }}
                                            &bull; {{ $totalFoto }} FOTO</span>
                                        <h3 class="news-title">
                                            <a
                                                href="{{ route('website.galeri.detail', $f->slug ?? $f->id_post) }}">{{ $f->judul }}</a>
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
                            <a href="{{ url('/galeri/foto') }}" class="btn-outline-blue">FOTO LAINNYA</a>
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
                                            <div class="video-play-btn-center">
                                                <i class="fa-solid fa-play"></i>
                                            </div>
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
                                        <span class="news-category-label">{{ $v->kategori?->kategori ?? 'VIDEO' }}</span>
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
                                            <div class="video-play-btn-center">
                                                <i class="fa-solid fa-play"></i>
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
                            <a href="{{ url('/galeri/video') }}" class="btn-outline-blue">VIDEO LAINNYA</a>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Berita Terpopuler Sidebar -->
                <aside class="news-right-sidebar">
                    <h3 class="sidebar-heading">Informasi Terpopuler</h3>

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
                            <a href="{{ route('website.informasi.detail', $pop->slug ?? $pop->id_post) }}"
                                class="popular-item" title="{{ $pop->judul }}">
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

    <!-- AGENDA KEGIATAN SECTION -->
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
                <a href="{{ url('/agenda') }}" class="btn-outline-blue">AGENDA LAINNYA</a>
            </div>

        </div>
    </section>

    <!-- PRODUK UNGGULAN USAHA KECIL Kalimantan Selatan SECTION -->
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
                            @forelse($produkUmkms as $prod)
                                <div class="product-card">
                                    <div class="product-img-box"
                                        style="position: relative; overflow: hidden; height: 180px; border-radius: 12px 12px 0 0;">
                                        @if ($prod->foto && Storage::disk('public')->exists($prod->foto))
                                            <img src="{{ asset('storage/' . $prod->foto) }}"
                                                alt="{{ $prod->nama_produk }}" class="product-img"
                                                style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('admins/images/products/s1.jpg') }}"
                                                alt="{{ $prod->nama_produk }}" class="product-img"
                                                style="width: 100%; height: 100%; object-fit: cover;">
                                        @endif
                                        <!-- BADGE READY DI SUDUT KANAN ATAS THUMBNAIL -->
                                        <span class="badge-ready"
                                            style="position: absolute; top: 10px; right: 10px; background: #28a745; color: #ffffff; padding: 4px 10px; font-weight: 700; font-size: 11px; border-radius: 6px; letter-spacing: 0.5px; text-transform: uppercase; box-shadow: 0 2px 6px rgba(0,0,0,0.2); z-index: 2;">
                                            <i class="fa-solid fa-check-circle me-1"></i> Ready
                                        </span>
                                    </div>
                                    <div class="product-info-box">
                                        <div>
                                            <span class="product-tag">{{ $prod->nama_umkm }}</span>
                                            <h3 class="product-title"
                                                style="margin-top: 6px; margin-bottom: 12px; font-size: 1.05rem; font-weight: 700; line-height: 1.35;">
                                                {{ $prod->nama_produk }}</h3>
                                        </div>

                                        <div class="product-meta-list"
                                            style="margin-top: auto; display: flex; flex-direction: column; gap: 9px; border-top: 1px solid #e2e8f0; padding-top: 14px; font-size: 0.8rem;">
                                            <!-- Wilayah / Lokasi (Tanpa frasa Kalimantan Selatan) -->
                                            <div class="meta-item" style="display: flex; align-items: center; gap: 10px;">
                                                <i class="fa-solid fa-location-dot"
                                                    style="color: #e11d48; width: 16px; text-align: center; font-size: 0.9rem; flex-shrink: 0;"></i>
                                                <span>{{ ucwords(strtolower($prod->wilayah->nama ?? 'Kalimantan Selatan')) }}</span>
                                            </div>

                                            <!-- Ukuran -->
                                            @if ($prod->ukuran)
                                                <div class="meta-item"
                                                    style="display: flex; align-items: center; gap: 10px;">
                                                    <i class="fa-solid fa-box-open"
                                                        style="color: #6366f1; width: 16px; text-align: center; font-size: 0.85rem; flex-shrink: 0;"></i>
                                                    <span>Ukuran: {{ $prod->ukuran }}</span>
                                                </div>
                                            @endif

                                            <!-- Ketahanan -->
                                            @if ($prod->ketahanan)
                                                <div class="meta-item"
                                                    style="display: flex; align-items: center; gap: 10px;">
                                                    <i class="fa-solid fa-clock"
                                                        style="color: #d97706; width: 16px; text-align: center; font-size: 0.85rem; flex-shrink: 0;"></i>
                                                    <span>Ketahanan: {{ $prod->ketahanan }}</span>
                                                </div>
                                            @endif

                                            <!-- Pengiriman -->
                                            <div class="meta-item" style="display: flex; align-items: center; gap: 10px;">
                                                <i class="fa-solid fa-truck-fast"
                                                    style="color: #0284c7; width: 16px; text-align: center; font-size: 0.85rem; flex-shrink: 0;"></i>
                                                <span>Pengiriman: {{ $prod->pengiriman ?: 'Seluruh Indonesia' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-muted text-center w-100">Belum ada data produk UMKM.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Action Button -->
            <div class="more-products-btn-wrap">
                <a href="https://pusatlayanankemasankalsel.com/galeri-produk" target="_blank"
                    class="btn-outline-blue">PRODUK
                    LAINNYA</a>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const openLayananBtn = document.getElementById('openLayananLainnyaBtn');
            const layananModal = document.getElementById('layananLainnyaModal');
            const layananBackdrop = document.getElementById('layananModalBackdrop');
            const layananClose = document.getElementById('layananModalClose');

            function openLayananModal() {
                if (layananModal) {
                    layananModal.classList.add('is-active');
                    document.body.style.overflow = 'hidden';
                }
            }

            function closeLayananModal() {
                if (layananModal) {
                    layananModal.classList.remove('is-active');
                    document.body.style.overflow = '';
                }
            }

            if (openLayananBtn) openLayananBtn.addEventListener('click', openLayananModal);
            if (layananBackdrop) layananBackdrop.addEventListener('click', closeLayananModal);
            if (layananClose) layananClose.addEventListener('click', closeLayananModal);

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && layananModal && layananModal.classList.contains('is-active')) {
                    closeLayananModal();
                }
            });
        });
    </script>
@endpush
