@extends('layouts.websites')

@section('content')

    <!-- PAGE BANNER / BREADCRUMB HEADER -->
    <div class="profile-page-banner"
        style="background-image: url('{{ asset('storage/profileweb/' . $tentang->firstWhere('status', 'file')?->keterangan) }}');">
        <div class="profile-banner-overlay"></div>
        <div class="profile-banner-container">
            <div class="profile-breadcrumb">
                <a href="{{ url('/') }}"><i class="fa-solid fa-house"></i> BERANDA</a>
                <span class="separator">/</span>
                <span class="current">INFORMASI</span>
            </div>
            <h1 class="profile-banner-title">Pusat Informasi</h1>
        </div>
    </div>

    <!-- MAIN INFORMASI GRID SECTION & FILTER -->
    <section class="informasi-main-section">
        <div class="informasi-container">

            <!-- Section Header & Filter Button -->
            <div class="informasi-header-row">
                <h2 class="informasi-section-heading">
                    Informasi Balatkop-UK Prov. Kalsel
                </h2>

                <button type="button"
                    class="btn-filter-toggle {{ !empty($selectedJenis) || !empty($selectedKategori) ? 'has-filter' : '' }}"
                    id="informasiFilterToggle">
                    <i class="fa-solid fa-sliders"></i>
                    <span>Filter</span>
                    @if (!empty($selectedJenis) || !empty($selectedKategori))
                        <span class="filter-dot-active"></span>
                    @endif
                </button>
            </div>

            <!-- FILTER MODAL DIALOG -->
            <div class="informasi-filter-modal" id="informasiFilterModal" aria-hidden="true">
                <div class="filter-modal-backdrop" id="filterModalBackdrop"></div>
                <div class="filter-modal-dialog">
                    <div class="filter-modal-content">
                        <!-- Modal Header -->
                        <div class="filter-modal-header">
                            <div class="modal-header-title">
                                <i class="fa-solid fa-sliders me-1 text-blue"></i>
                                <span>Filter Informasi</span>
                            </div>
                            <button type="button" class="filter-modal-close" id="filterModalClose" aria-label="Tutup">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <div class="filter-modal-body">
                            <form action="{{ url('/informasi') }}" method="GET" id="filterModalForm">
                                <input type="hidden" name="jenis" id="filterJenisInput"
                                    value="{{ $selectedJenis ?? '' }}">
                                <input type="hidden" name="kategori" id="filterKategoriInput"
                                    value="{{ $selectedKategori ?? '' }}">

                                <!-- Filter Group: Search Input -->
                                <div class="filter-group filter-group-search">
                                    <label class="filter-group-label"><i class="fa-solid fa-magnifying-glass me-1"></i>
                                        Cari Informasi:</label>
                                    <div class="filter-search-box">
                                        <input type="text" name="q" class="filter-search-input"
                                            id="filterQueryInput" placeholder="Ketik Kata Kunci ..."
                                            value="{{ $search ?? '' }}">
                                        <button type="button" class="clear-search-btn" id="clearSearchInputBtn"
                                            title="Hapus Teks Pencarian"
                                            style="{{ empty($search) ? 'display:none;' : '' }}">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Filter Group: Jenis -->
                                <div class="filter-group">
                                    <label class="filter-group-label"><i class="fa-solid fa-layer-group me-1"></i> Jenis
                                        Informasi:</label>
                                    <div class="filter-pills-wrap" id="jenisPillsGroup">
                                        <button type="button"
                                            class="filter-pill-btn {{ empty($selectedJenis) ? 'active' : '' }}"
                                            data-val="">Semua</button>
                                        <button type="button"
                                            class="filter-pill-btn {{ strtolower($selectedJenis ?? '') === 'berita' ? 'active' : '' }}"
                                            data-val="Berita">Berita</button>
                                        <button type="button"
                                            class="filter-pill-btn {{ in_array(strtolower($selectedJenis ?? ''), ['tips', 'info']) ? 'active' : '' }}"
                                            data-val="Tips">Info & Tips</button>
                                        <button type="button"
                                            class="filter-pill-btn {{ strtolower($selectedJenis ?? '') === 'artikel' ? 'active' : '' }}"
                                            data-val="Artikel">Artikel</button>
                                    </div>
                                </div>

                                <!-- Filter Group: Kategori -->
                                @if ($kategoriList->count() > 0)
                                    <div class="filter-group">
                                        <label class="filter-group-label"><i class="fa-solid fa-tags me-1"></i> Kategori
                                            Sub-Bidang:</label>
                                        <div class="filter-pills-wrap" id="kategoriPillsGroup">
                                            <button type="button"
                                                class="filter-pill-btn {{ empty($selectedKategori) ? 'active' : '' }}"
                                                data-val="">Semua Kategori</button>
                                            @foreach ($kategoriList as $kat)
                                                <button type="button"
                                                    class="filter-pill-btn {{ (string) ($selectedKategori ?? '') === (string) $kat->id_kategori ? 'active' : '' }}"
                                                    data-val="{{ $kat->id_kategori }}">
                                                    {{ $kat->kategori }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </form>
                        </div>

                        <!-- Modal Footer -->
                        <div class="filter-modal-footer">
                            <a href="{{ url('/informasi') }}" class="btn-reset-filter-modal">
                                <i class="fa-solid fa-rotate-left me-1"></i> Reset Filter
                            </a>
                            <button type="submit" form="filterModalForm" class="btn-apply-modal" id="filterModalApply">
                                Cari & Terapkan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Posts Cards Grid (3 Columns) -->
            <div class="informasi-grid-wrapper">
                @forelse ($posts as $b)
                    @php
                        $thumbUrl = null;
                        if ($b->thumbnail) {
                            $thumbUrl = asset('storage/post/thumbnail/' . $b->thumbnail);
                        }
                    @endphp
                    <article class="news-card">
                        <div class="news-image-box">
                            <a href="#" class="news-img-link" title="{{ $b->judul }}">
                                @if ($thumbUrl)
                                    <img src="{{ $thumbUrl }}" alt="{{ $b->judul }}" loading="lazy"
                                        decoding="async" style="width:100%; height:100%; object-fit:cover;">
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
                            <!-- Date Badge Overlay at Bottom Right -->
                            <div class="date-badge">
                                <span class="day-text">{{ $b->created_at ? $b->created_at->format('d') : '01' }}</span>
                                <span class="month-text">{{ bulan_indo($b->created_at) }}
                                    {{ $b->created_at ? $b->created_at->format('Y') : '2026' }}</span>
                            </div>
                        </div>
                        <div class="news-details">
                            @php
                                $jenisIcon = 'fa-solid fa-newspaper';
                                if (in_array(strtolower($b->jenis ?? ''), ['tips', 'info'])) {
                                    $jenisIcon = 'fa-solid fa-lightbulb';
                                } elseif (strtolower($b->jenis ?? '') === 'artikel') {
                                    $jenisIcon = 'fa-solid fa-file-pen';
                                }
                            @endphp
                            <span class="news-category-label">
                                <i class="{{ $jenisIcon }} me-1"></i>
                                {{ strtoupper($b->jenis ?? 'BERITA') }}
                                @if ($b->kategori)
                                    &bull; {{ strtoupper($b->kategori->kategori) }}
                                @endif
                            </span>
                            <h3 class="news-title">
                                <a href="#">{{ $b->judul }}</a>
                            </h3>
                            @php
                                $summaryText = !empty(trim($b->ringkasan ?? ''))
                                    ? $b->ringkasan
                                    : (!empty(trim($b->isi ?? ''))
                                        ? $b->isi
                                        : $b->judul);
                            @endphp
                            <p class="news-excerpt">
                                {{ Str::limit(strip_tags($summaryText), 120) }}
                            </p>
                            @if ($b->hashtags && $b->hashtags->count() > 0)
                                <div class="news-card-hashtags mt-2">
                                    @foreach ($b->hashtags as $hTag)
                                        <a href="{{ url('/informasi?q=' . urlencode($hTag->hashtag)) }}"
                                            class="news-hashtag-badge">
                                            #{{ $hTag->hashtag }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="informasi-empty-state">
                        <i class="fa-solid fa-folder-open empty-icon"></i>
                        <h3 class="empty-title">Tidak Ada Data Informasi</h3>
                        <p class="empty-desc">Maaf, belum ada data informasi yang sesuai dengan filter pilihan Anda.</p>
                        <a href="{{ url('/informasi') }}" class="btn-outline-blue mt-3">Reset Filter</a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination Controls (Indonesian & Ultra-Clean Custom Styled) -->
            @if ($posts->hasPages())
                <div class="informasi-pagination-container">
                    <div class="pagination-info-text">
                        Menampilkan {{ $posts->firstItem() }} - {{ $posts->lastItem() }} dari total {{ $posts->total() }}
                        data
                    </div>

                    <ul class="custom-pagination-list">
                        {{-- Previous Page Link --}}
                        @if ($posts->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link" aria-hidden="true"><i
                                        class="fa-solid fa-chevron-left"></i></span>
                            </li>
                        @else
                            <li class="page-item">
                                <a href="{{ $posts->previousPageUrl() }}" class="page-link" rel="prev"
                                    aria-label="Sebelumnya"><i class="fa-solid fa-chevron-left"></i></a>
                            </li>
                        @endif

                        {{-- Page Number Links --}}
                        @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                            @if ($page == $posts->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($posts->hasMorePages())
                            <li class="page-item">
                                <a href="{{ $posts->nextPageUrl() }}" class="page-link" rel="next"
                                    aria-label="Selanjutnya"><i class="fa-solid fa-chevron-right"></i></a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link" aria-hidden="true"><i
                                        class="fa-solid fa-chevron-right"></i></span>
                            </li>
                        @endif
                    </ul>
                </div>
            @endif

        </div>
    </section>
@endsection
