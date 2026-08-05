@extends('layouts.websites')

@section('title', $currentHalaman ? $currentHalaman->judul : 'Daftar Pemanfaatan Fasilitas')

@section('content')
    <!-- DEDICATED FASILITAS CSS & JS -->
    <link rel="stylesheet" href="{{ asset('websites/css/fasilitas.css') }}?v={{ time() }}">

    <!-- PAGE BANNER / BREADCRUMB HEADER -->
    <div class="profile-page-banner"
        style="background-image: url('{{ asset('storage/profileweb/' . $tentang->firstWhere('status', 'file')?->keterangan) }}');">
        <div class="profile-banner-overlay"></div>
        <div class="profile-banner-container">
            <div class="profile-breadcrumb">
                <a href="{{ url('/') }}"><i class="fa-solid fa-house"></i> BERANDA</a>
                <span class="separator">/</span>
                <a href="{{ url('/layanan/pemanfaatan-fasilitas') }}">LAYANAN</a>
                <span class="separator">/</span>
                <span class="current">PEMANFAATAN FASILITAS</span>
            </div>
            <h1 class="profile-banner-title">
                Pemanfaatan Fasilitas</h1>
        </div>
    </div>

    <!-- MAIN PROFILE & FASILITAS SECTION (2 COLUMN SIDEBAR + CONTENT) -->
    <section class="profile-main-section">
        <div class="profile-container">
            <div class="profile-grid">

                <!-- Left Column: Sidebar Menu (Submenu Fasilitas) -->
                <aside class="profile-sidebar">
                    <div class="profile-sidebar-card">
                        <!-- Mobile Minimalist Toggle Button -->
                        <button type="button" class="profile-sidebar-toggle" id="profileSidebarToggle">
                            <span class="toggle-text">Menu Fasilitas</span>
                            <i class="fa-solid fa-bars toggle-icon"></i>
                        </button>

                        <ul class="profile-menu-list" id="profileMenuList">
                            <li>
                                <a href="{{ url('/layanan/pemanfaatan-fasilitas') }}"
                                    class="profile-menu-item {{ is_null($currentHalaman) && !$isPesanOnline && !$isCekStatus ? 'active' : '' }}">
                                    <span class="num">01</span>
                                    <span class="label">Katalog Fasilitas</span>
                                </a>
                            </li>

                            @foreach ($halamans as $idx => $hal)
                                <li>
                                    <a href="{{ url('/layanan/pemanfaatan-fasilitas/' . $hal->slug) }}"
                                        class="profile-menu-item {{ $currentHalaman && $currentHalaman->id_halaman == $hal->id_halaman ? 'active' : '' }}">
                                        <span class="num">{{ str_pad($idx + 2, 2, '0', STR_PAD_LEFT) }}</span>
                                        <span class="label">{{ $hal->judul }}</span>
                                    </a>
                                </li>
                            @endforeach

                            <li>
                                <a href="{{ url('/layanan/pemanfaatan-fasilitas/pesan-online') }}"
                                    class="profile-menu-item {{ $isPesanOnline ? 'active' : '' }}">
                                    <span class="num">{{ str_pad($halamans->count() + 2, 2, '0', STR_PAD_LEFT) }}</span>
                                    <span class="label">Pesan Online</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('/layanan/pemanfaatan-fasilitas/cek-status') }}"
                                    class="profile-menu-item {{ $isCekStatus ? 'active' : '' }}">
                                    <span class="num">{{ str_pad($halamans->count() + 3, 2, '0', STR_PAD_LEFT) }}</span>
                                    <span class="label">Cek Status Booking</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </aside>

                <!-- Right Column: Main Content Area -->
                <main class="profile-content-area">
                    <div class="profile-content-card">

                        @if ($isPesanOnline)
                            <livewire:website.fasilitas.pesan-form />
                        @elseif ($isCekStatus)
                            <livewire:website.fasilitas.cek-status-form />
                        @elseif (is_null($currentHalaman))
                            <!-- KATALOG FASILITAS TITLE HERO CARD -->
                            <div class="catalog-hero-header">
                                <div class="catalog-hero-left">
                                    <div class="catalog-hero-icon-box">
                                        <i class="fa-solid fa-building-circle-check"></i>
                                    </div>
                                    <div>
                                        <span class="catalog-hero-subtitle">Sarana & Prasarana</span>
                                        <h2 class="catalog-hero-title">Katalog Fasilitas Balatkop & UK Prov. Kalsel</h2>
                                    </div>
                                </div>
                                <div class="catalog-hero-right">
                                    <span class="catalog-hero-badge">
                                        <i class="fa-solid fa-boxes-stacked"></i>
                                        <span><strong>{{ $fasilitas->count() }}</strong> Sarana & Gedung Tersedia</span>
                                    </span>
                                </div>
                            </div>

                            <!-- KATALOG FASILITAS GRID -->
                            <div class="fasilitas-catalog-grid">
                                @forelse($fasilitas as $item)
                                    <div class="fasilitas-card">

                                        <!-- CARD MEDIA WRAPPER -->
                                        <div class="card-media-wrap">
                                            @if ($item->thumbnail && Storage::disk('public')->exists('fasilitas/' . $item->thumbnail))
                                                <img src="{{ asset('storage/fasilitas/' . $item->thumbnail) }}"
                                                    class="card-media-img" alt="{{ $item->nama }}">
                                            @else
                                                <div class="card-media-placeholder">
                                                    <i class="fa-solid fa-building"></i>
                                                </div>
                                            @endif

                                            <div class="media-badges-right">
                                                <span class="media-badge media-badge-green">
                                                    <i class="fa-solid fa-circle-check"></i> Tersedia
                                                </span>
                                            </div>
                                        </div>

                                        <!-- CARD BODY -->
                                        <div class="card-content-body">
                                            <h3 class="card-title">{{ $item->nama }}</h3>

                                            <div class="card-meta">
                                                @if ($item->kapasitas)
                                                    <span><i class="fa-solid fa-users text-blue"></i>
                                                        {{ $item->kapasitas }} Orang</span>
                                                @endif
                                                @if ($item->jumlah)
                                                    <span><i class="fa-solid fa-boxes-stacked text-amber"></i>
                                                        {{ $item->jumlah }} Unit</span>
                                                @endif
                                            </div>

                                            <p class="card-desc">
                                                {{ Str::limit($item->deskripsi, 110, '...') ?: 'Sarana pendukung kegiatan pelatihan, rapat, dan acara di UPTD Balatkop & UKM Kalsel.' }}
                                            </p>

                                            <!-- BUTTON ACTION -->
                                            <div class="card-action">
                                                <button type="button" class="btn-detail-modal"
                                                    onclick="openFasilitasModal({{ $item->id_fasilitas }})">
                                                    <i class="fa-solid fa-circle-info"></i> Detail Fasilitas
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- MODAL DETAIL DIALOG -->
                                    <div class="fasilitas-modal-overlay" id="modal-overlay-{{ $item->id_fasilitas }}">
                                        <div class="fasilitas-modal-box">
                                            <div class="modal-box-header">
                                                <div>
                                                    <h3 class="modal-box-title">{{ $item->nama }}</h3>
                                                </div>
                                                <button type="button" class="modal-box-close"
                                                    onclick="closeFasilitasModal({{ $item->id_fasilitas }})">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </div>

                                            <div class="modal-box-body">
                                                <!-- FOTO PREVIEW -->
                                                @if ($item->fotos && $item->fotos->count() > 0)
                                                    <div class="modal-gallery-wrap">
                                                        <img src="{{ asset('storage/fasilitas_foto/' . $item->fotos->first()->foto) }}"
                                                            id="gallery-main-{{ $item->id_fasilitas }}"
                                                            class="modal-main-img" alt="Foto Fasilitas">

                                                        @if ($item->fotos->count() > 1)
                                                            <div class="modal-gallery-thumbs">
                                                                @foreach ($item->fotos as $fItem)
                                                                    <img src="{{ asset('storage/fasilitas_foto/' . $fItem->foto) }}"
                                                                        class="gallery-thumb"
                                                                        onclick="setMainGalleryImage({{ $item->id_fasilitas }}, '{{ asset('storage/fasilitas_foto/' . $fItem->foto) }}')"
                                                                        alt="Thumbnail">
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                @elseif($item->thumbnail && Storage::disk('public')->exists('fasilitas/' . $item->thumbnail))
                                                    <div class="modal-gallery-wrap">
                                                        <img src="{{ asset('storage/fasilitas/' . $item->thumbnail) }}"
                                                            class="modal-main-img" alt="{{ $item->nama }}">
                                                    </div>
                                                @endif

                                                <!-- SPECS GRID -->
                                                <div class="modal-specs-grid">
                                                    <div class="spec-box">
                                                        <span class="spec-label">Kapasitas</span>
                                                        <strong class="spec-val"><i
                                                                class="fa-solid fa-users text-blue"></i>
                                                            {{ $item->kapasitas ?? '-' }} Orang</strong>
                                                    </div>
                                                    <div class="spec-box">
                                                        <span class="spec-label">Jumlah Unit</span>
                                                        <strong class="spec-val"><i
                                                                class="fa-solid fa-boxes-stacked text-amber"></i>
                                                            {{ $item->jumlah ?? 1 }} Unit</strong>
                                                    </div>
                                                    <div class="spec-box">
                                                        <span class="spec-label">Lokasi</span>
                                                        <strong class="spec-val"><i
                                                                class="fa-solid fa-location-dot text-red"></i>
                                                            {{ $item->lokasi ?? '-' }}</strong>
                                                    </div>
                                                </div>

                                                <h4 class="modal-section-heading">Deskripsi Fasilitas</h4>
                                                <p class="modal-desc-text">
                                                    {{ $item->deskripsi ?: 'Tidak ada deskripsi tambahan.' }}</p>


                                            </div>

                                            <div class="modal-box-footer">
                                                <button type="button" class="btn-modal-close"
                                                    onclick="closeFasilitasModal({{ $item->id_fasilitas }})">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="empty-fasilitas-alert">
                                        <i class="fa-solid fa-building-circle-exclamation"></i>
                                        <h3>Belum Ada Data Fasilitas</h3>
                                        <p>Data fasilitas belum ditambahkan atau sedang dalam pembaruan.</p>
                                    </div>
                                @endforelse
                            </div>
                        @else
                            <!-- HALAMAN KETENTUAN DINAMIS (DARI TABEL FASILITAS_HALAMAN) -->
                            <h2 class="profile-content-heading">{{ strtoupper($currentHalaman->judul) }}</h2>
                            <div class="profile-content-body">
                                {!! $currentHalaman->isi ?: '<p class="text-muted">Konten informasi belum diisi.</p>' !!}
                            </div>
                        @endif

                    </div>
                </main>
            </div>
        </div>
    </section>

    <!-- DEDICATED FASILITAS JS -->
    <script src="{{ asset('websites/js/fasilitas.js') }}?v={{ time() }}"></script>
    <script>
        // Sidebar Toggle for Mobile View
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('profileSidebarToggle');
            const menuList = document.getElementById('profileMenuList');

            if (toggleBtn && menuList) {
                toggleBtn.addEventListener('click', function() {
                    menuList.classList.toggle('show');
                });
            }
        });
    </script>
@endsection
