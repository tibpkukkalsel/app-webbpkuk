@extends('layouts.websites')

@section('title', 'Data Pegawai')

@section('content')

    <!-- PAGE BANNER / BREADCRUMB HEADER (IDENTICAL TO TENTANG PAGE) -->
    <div class="profile-page-banner"
        style="background-image: url('{{ asset('storage/profileweb/' . $tentang->firstWhere('status', 'file')?->keterangan) }}');">
        <div class="profile-banner-overlay"></div>
        <div class="profile-banner-container">
            <div class="profile-breadcrumb">
                <a href="{{ url('/') }}"><i class="fa-solid fa-house"></i> BERANDA</a>
                <span class="separator">/</span>
                <span class="current">PEGAWAI</span>
            </div>
            <h1 class="profile-banner-title">Data Pegawai</h1>
        </div>
    </div>

    <!-- MAIN CONTENT SECTION -->
    <section class="pegawai-page-section">
        <div class="container-websites">

            <!-- FILTER SEKSI SELECTOR CONTAINER (INTERACTIVE PILLS & SELECTOR) -->
            <div class="pegawai-filter-card">
                <div class="pegawai-filter-header">
                    <div class="pegawai-filter-title">
                        <div class="filter-icon-badge">
                            <i class="fa-solid fa-sitemap"></i>
                        </div>
                        <div>
                            <h3 class="filter-main-heading">Pilih Seksi / Subbagian</h3>
                            <p class="filter-sub-heading">Filter dan tampilkan data pegawai berdasarkan unit kerja</p>
                        </div>
                    </div>
                </div>

                <!-- Horizontal Interactive Pill Tabs (Desktop & Laptop View) -->
                <div class="pegawai-pills-bar">
                    <a href="{{ url('/profil/pegawai') }}" class="pegawai-pill-item {{ !$selectedSeksi ? 'active' : '' }}">
                        <i class="fa-solid fa-layer-group"></i>
                        <span>Semua Seksi</span>
                    </a>
                    @foreach ($seksiList as $s)
                        <a href="{{ url('/profil/pegawai?seksi=' . ($s->slug ?? $s->id_seksi)) }}"
                            class="pegawai-pill-item {{ ($selectedSeksi && $selectedSeksi->id_seksi == $s->id_seksi) ? 'active' : '' }}">
                            <i class="fa-solid fa-building-user"></i>
                            <span>{{ $s->seksi }}</span>
                        </a>
                    @endforeach
                </div>

                <!-- Custom Select Dropdown (Mobile Responsive View) -->
                <div class="pegawai-mobile-select-wrap">
                    <form action="{{ url('/profil/pegawai') }}" method="GET" id="mobile-seksi-form">
                        <div class="mobile-seksi-select-card">
                            <div class="mobile-seksi-select-header">
                                <div class="mobile-seksi-label">
                                    <span class="mobile-label-title">Filter Unit Kerja</span>
                                    <span class="mobile-label-subtitle">Pilih seksi untuk menampilkan data pegawai</span>
                                </div>
                            </div>
                            <div class="mobile-seksi-select-body">
                                <div class="mobile-select-wrapper">
                                    <i class="fa-solid fa-building-user mobile-select-icon"></i>
                                    <select name="seksi" class="mobile-seksi-native-select"
                                        onchange="document.getElementById('mobile-seksi-form').submit()">
                                        <option value="">&#9679; Semua Seksi / Subbagian</option>
                                        @foreach ($seksiList as $s)
                                            <option value="{{ $s->slug ?? $s->id_seksi }}"
                                                {{ ($selectedSeksi && $selectedSeksi->id_seksi == $s->id_seksi) ? 'selected' : '' }}>
                                                &#9679; {{ $s->seksi }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class="fa-solid fa-chevron-down mobile-select-arrow"></i>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ACTIVE FILTER RESULT SUMMARY STRIP -->
            <div class="pegawai-active-info-strip mb-4">
                <div class="active-info-badge">
                    <i class="fa-solid fa-layer-group"></i>
                    <span>
                        Unit Kerja Terpilih:
                        <strong>{{ $selectedSeksi ? $selectedSeksi->seksi : 'Semua Seksi / Subbagian' }}</strong>
                    </span>
                </div>
                <span class="active-count-badge">
                    Total: <strong>{{ count($pegawaiList) }} Pegawai</strong>
                </span>
            </div>

            <!-- PEGAWAI CARDS GRID (MATCHING REFERENCE SCREENSHOT) -->
            @if (count($pegawaiList) > 0)
                <div class="pegawai-grid-wrapper">
                    @foreach ($pegawaiList as $p)
                        <div class="pegawai-card-item">
                            <!-- Card Frame Overlay -->
                            <div class="pegawai-card-frame">
                                <!-- Top Header Overlay -->
                                <div class="pegawai-card-header-overlay">
                                    @if ($logoleft = $identitas->firstWhere('nama', 'Logo Pemprov'))
                                        <img src="{{ asset('storage/header/' . $logoleft->keterangan) }}"
                                            class="pegawai-header-emblem" alt="Logo Pemprov">
                                    @else
                                        <i class="fa-solid fa-shield-halved text-white fs-4"></i>
                                    @endif
                                    <div class="pegawai-header-text">
                                        <h6>BALAI PELATIHAN KOPERASI <br> & USAHA KECIL</h6>
                                        <p>PROVINSI KALIMANTAN SELATAN</p>
                                    </div>
                                </div>

                                <!-- Photo Container -->
                                <div class="pegawai-card-photo-container">
                                    @if ($p->foto && Storage::disk('public')->exists('pegawai/' . $p->foto))
                                        <img src="{{ asset('storage/pegawai/' . $p->foto) }}" alt="{{ $p->nama }}"
                                            class="pegawai-card-photo">
                                    @else
                                        <div class="pegawai-card-photo-placeholder">
                                            <i class="fa-solid fa-user-tie"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Slanted Banner Overlay at Bottom -->
                                <div class="pegawai-card-banner-overlay">
                                    <h6 class="pegawai-banner-name">{{ $p->nama }}</h6>
                                    <p class="pegawai-banner-title">{{ $p->jabatan?->jabatan ?? '-' }}</p>
                                </div>
                            </div>

                            <!-- External Typography Below Card -->
                            <div class="pegawai-card-info-external">
                                <h4 class="pegawai-external-name">{{ $p->nama }}</h4>
                                <p class="pegawai-external-title">{{ $p->jabatan?->jabatan ?? '-' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="informasi-empty-state text-center py-5">
                    <i class="fa-solid fa-users-slash empty-icon text-muted fs-1 mb-3"></i>
                    <h3 class="empty-title">Data Pegawai Tidak Ditemukan</h3>
                    <p class="empty-desc text-muted">Belum ada data pegawai yang terdaftar pada seksi yang dipilih.</p>
                    <a href="{{ url('/profil/pegawai') }}"
                        class="btn-outline-blue mt-3 d-inline-flex align-items-center gap-2">
                        <i class="fa-solid fa-rotate-left"></i> Lihat Semua Pegawai
                    </a>
                </div>
            @endif

        </div>
    </section>

@endsection
