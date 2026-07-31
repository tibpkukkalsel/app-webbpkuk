@extends('layouts.websites')

@section('title', 'Galeri Foto')

@section('content')

    <!-- PAGE BANNER / BREADCRUMB HEADER (IDENTICAL TO INFORMASI PAGE) -->
    <div class="profile-page-banner"
        style="background-image: url('{{ asset('storage/profileweb/' . $tentang->firstWhere('status', 'file')?->keterangan) }}');">
        <div class="profile-banner-overlay"></div>
        <div class="profile-banner-container">
            <div class="profile-breadcrumb">
                <a href="{{ url('/') }}"><i class="fa-solid fa-house"></i> BERANDA</a>
                <span class="separator">/</span>
                <span class="current">GALERI FOTO</span>
            </div>
            <h1 class="profile-banner-title">Galeri Foto</h1>
        </div>
    </div>

    <!-- MAIN GALERI GRID SECTION & FILTER -->
    <section class="informasi-main-section">
        <div class="informasi-container">

            <!-- Section Header & Filter Button -->
            <div class="informasi-header-row">
                <h2 class="informasi-section-heading">
                    Galeri Foto Balatkop-UK Prov. Kalsel
                </h2>

                <button type="button"
                    class="btn-filter-toggle {{ !empty($selectedKategori) || !empty($search) ? 'has-filter' : '' }}"
                    id="informasiFilterToggle">
                    <i class="fa-solid fa-sliders"></i>
                    <span>Filter</span>
                    @if (!empty($selectedKategori) || !empty($search))
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
                                <span>Filter Galeri Foto</span>
                            </div>
                            <button type="button" class="filter-modal-close" id="filterModalClose" aria-label="Tutup">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <div class="filter-modal-body">
                            <form action="{{ url('/galeri') }}" method="GET" id="filterModalForm">
                                <input type="hidden" name="kategori" id="filterKategoriInput"
                                    value="{{ $selectedKategori ?? '' }}">

                                <!-- Filter Group: Search Input -->
                                <div class="filter-group filter-group-search">
                                    <label class="filter-group-label"><i class="fa-solid fa-magnifying-glass me-1"></i>
                                        Cari Galeri Foto:</label>
                                    <div class="filter-search-box">
                                        <input type="text" name="q" class="filter-search-input"
                                            id="filterQueryInput" placeholder="Ketik Kata Kunci Galeri ..."
                                            value="{{ $search ?? '' }}">
                                        <button type="button" class="clear-search-btn" id="clearSearchInputBtn"
                                            title="Hapus Teks Pencarian"
                                            style="{{ empty($search) ? 'display:none;' : '' }}">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Filter Group: Kategori -->
                                @if ($kategoriList->count() > 0)
                                    <div class="filter-group">
                                        <label class="filter-group-label"><i class="fa-solid fa-tags me-1"></i>
                                            Kategori:</label>
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
                            <a href="{{ url('/galeri') }}" class="btn-reset-filter-modal">
                                <i class="fa-solid fa-rotate-left me-1"></i> Reset Filter
                            </a>
                            <button type="submit" form="filterModalForm" class="btn-apply-modal" id="filterModalApply">
                                Cari & Terapkan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Galeri Cards Grid (3 Columns) -->
            <div class="informasi-grid-wrapper">
                @forelse ($galeriFoto as $b)
                    @php
                        $thumbUrl = $b->thumbnail
                            ? asset('storage/post/thumbnail/' . $b->thumbnail)
                            : ($b->galeri->first()?->gambar
                                ? asset('storage/post/galeri/' . $b->galeri->first()->gambar)
                                : null);
                        $totalFoto = $b->galeri->count() + ($b->thumbnail ? 1 : 0);
                    @endphp
                    <article class="news-card">
                        <div class="news-image-box">
                            <a href="{{ route('website.galeri.detail', $b->slug ?? $b->id_post) }}" class="news-img-link"
                                title="{{ $b->judul }}">
                                @if ($thumbUrl)
                                    <img src="{{ $thumbUrl }}" alt="{{ $b->judul }}" loading="lazy"
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
                            <!-- Date Badge Overlay at Bottom Right -->
                            <div class="date-badge">
                                <span class="day-text">{{ $b->created_at ? $b->created_at->format('d') : '01' }}</span>
                                <span class="month-text">{{ bulan_indo($b->created_at) }}
                                    {{ $b->created_at ? $b->created_at->format('Y') : '2026' }}</span>
                            </div>
                        </div>
                        <div class="news-details">
                            <span class="news-category-label">
                                <i class="fa-solid fa-images me-1 text-blue"></i> {{ $totalFoto }} FOTO
                                @if ($b->kategori)
                                    &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-folder-open me-1"></i>
                                    {{ strtoupper($b->kategori->kategori) }}
                                @endif
                            </span>

                            <h3 class="news-title">
                                <a
                                    href="{{ route('website.galeri.detail', $b->slug ?? $b->id_post) }}">{{ $b->judul }}</a>
                            </h3>
                        </div>
                    </article>
                @empty
                    <div class="informasi-empty-state">
                        <i class="fa-solid fa-images empty-icon"></i>
                        <h3 class="empty-title">Tidak Ada Galeri Foto</h3>
                        <p class="empty-desc">Maaf, belum ada data galeri foto yang sesuai dengan filter pilihan Anda.</p>
                        <a href="{{ url('/galeri') }}" class="btn-outline-blue mt-3">Reset Filter</a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination Controls (Indonesian & Ultra-Clean Custom Styled) -->
            @if ($galeriFoto->hasPages())
                <div class="informasi-pagination-container">
                    <div class="pagination-info-text">
                        Menampilkan {{ $galeriFoto->firstItem() }} - {{ $galeriFoto->lastItem() }} dari total
                        {{ $galeriFoto->total() }}
                        data galeri
                    </div>

                    <ul class="custom-pagination-list">
                        {{-- Previous Page Link --}}
                        @if ($galeriFoto->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link" aria-hidden="true"><i
                                        class="fa-solid fa-chevron-left"></i></span>
                            </li>
                        @else
                            <li class="page-item">
                                <a href="{{ $galeriFoto->previousPageUrl() }}" class="page-link" rel="prev"
                                    aria-label="Sebelumnya"><i class="fa-solid fa-chevron-left"></i></a>
                            </li>
                        @endif

                        {{-- Page Number Links --}}
                        @foreach ($galeriFoto->getUrlRange(1, $galeriFoto->lastPage()) as $page => $url)
                            @if ($page == $galeriFoto->currentPage())
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
                        @if ($galeriFoto->hasMorePages())
                            <li class="page-item">
                                <a href="{{ $galeriFoto->nextPageUrl() }}" class="page-link" rel="next"
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterToggle = document.getElementById('informasiFilterToggle');
            const filterModal = document.getElementById('informasiFilterModal');
            const filterBackdrop = document.getElementById('filterModalBackdrop');
            const filterClose = document.getElementById('filterModalClose');

            const queryInput = document.getElementById('filterQueryInput');
            const clearSearchBtn = document.getElementById('clearSearchInputBtn');

            const kategoriInput = document.getElementById('filterKategoriInput');

            function openFilterModal() {
                if (filterModal) {
                    filterModal.classList.add('is-active');
                    document.body.style.overflow = 'hidden';
                }
            }

            function closeFilterModal() {
                if (filterModal) {
                    filterModal.classList.remove('is-active');
                    document.body.style.overflow = '';
                }
            }

            if (filterToggle) filterToggle.addEventListener('click', openFilterModal);
            if (filterBackdrop) filterBackdrop.addEventListener('click', closeFilterModal);
            if (filterClose) filterClose.addEventListener('click', closeFilterModal);

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && filterModal && filterModal.classList.contains('is-active')) {
                    closeFilterModal();
                }
            });

            if (queryInput && clearSearchBtn) {
                queryInput.addEventListener('input', function() {
                    if (this.value.trim() !== '') {
                        clearSearchBtn.style.display = 'flex';
                    } else {
                        clearSearchBtn.style.display = 'none';
                    }
                });

                clearSearchBtn.addEventListener('click', function() {
                    queryInput.value = '';
                    this.style.display = 'none';
                    queryInput.focus();
                });
            }

            // Kategori Pill Selection
            const kategoriPills = document.querySelectorAll('#kategoriPillsGroup .filter-pill-btn');
            kategoriPills.forEach(pill => {
                pill.addEventListener('click', function() {
                    kategoriPills.forEach(p => p.classList.remove('active'));
                    this.classList.add('active');
                    if (kategoriInput) {
                        kategoriInput.value = this.getAttribute('data-val') || '';
                    }
                });
            });
        });
    </script>
@endpush
