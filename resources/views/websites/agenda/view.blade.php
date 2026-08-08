@extends('layouts.websites')

@section('title', 'Agenda Kegiatan')

@section('content')

    <!-- PAGE BANNER / BREADCRUMB HEADER -->
    <div class="profile-page-banner"
        style="background-image: url('{{ asset('storage/profileweb/' . $tentang->firstWhere('status', 'file')?->keterangan) }}');">
        <div class="profile-banner-overlay"></div>
        <div class="profile-banner-container">
            <div class="profile-breadcrumb">
                <a href="{{ url('/') }}"><i class="fa-solid fa-house"></i> BERANDA</a>
                <span class="separator">/</span>
                <span class="current">AGENDA</span>
            </div>
            <h1 class="profile-banner-title">Agenda</h1>
        </div>
    </div>

    <!-- MAIN AGENDA GRID SECTION & FILTER -->
    <section class="informasi-main-section">
        <div class="informasi-container">

            <!-- Section Header & Filter Button -->
            <div class="informasi-header-row">
                <div>
                    <h2 class="informasi-section-heading">
                        Agenda Kegiatan Balatkop-UK Prov. Kalsel
                    </h2>
                    <p class="informasi-section-subheading">
                        Jadwal & kegiatan pelatihan, workshop, dan pembinaan Koperasi & UMKM Kalimantan Selatan.
                    </p>
                </div>

                <div class="informasi-action-buttons">
                    @if ($hasActiveFilter)
                        <a href="{{ url('/agenda') }}" class="btn-reset-filter" title="Reset Semua Filter">
                            <i class="fa-solid fa-rotate-left"></i>
                            <span>Reset Filter</span>
                        </a>
                    @endif
                    <button type="button" class="btn-filter-toggle {{ $hasActiveFilter ? 'has-filter' : '' }}"
                        id="informasiFilterToggle">
                        <i class="fa-solid fa-sliders"></i>
                        <span>Filter</span>
                        @if ($hasActiveFilter)
                            <span class="filter-dot-active"></span>
                        @endif
                    </button>
                </div>
            </div>

            <!-- Quick Status Filter Pills Row -->
            @php
                $currStatus = $statusAgenda ?? '';
                $monthsIndo = [
                    1 => 'Januari',
                    2 => 'Februari',
                    3 => 'Maret',
                    4 => 'April',
                    5 => 'Mei',
                    6 => 'Juni',
                    7 => 'Juli',
                    8 => 'Agustus',
                    9 => 'September',
                    10 => 'Oktober',
                    11 => 'November',
                    12 => 'Desember',
                ];
            @endphp
            <div class="agenda-status-quick-bar mb-4">
                <a href="{{ url('/agenda') . '?' . http_build_query(array_merge(request()->except(['status_agenda', 'page']))) }}"
                    class="agenda-quick-tab {{ empty($currStatus) ? 'active' : '' }}">
                    <i class="fa-solid fa-layer-group me-1"></i> Semua Agenda
                </a>
                <a href="{{ url('/agenda') . '?' . http_build_query(array_merge(request()->except(['status_agenda', 'page']), ['status_agenda' => 'active'])) }}"
                    class="agenda-quick-tab tab-active-live {{ $currStatus === 'active' ? 'active' : '' }}">
                    <span class="pulse-dot"></span> Sedang Berlangsung
                </a>
                <a href="{{ url('/agenda') . '?' . http_build_query(array_merge(request()->except(['status_agenda', 'page']), ['status_agenda' => 'upcoming'])) }}"
                    class="agenda-quick-tab {{ $currStatus === 'upcoming' ? 'active' : '' }}">
                    <i class="fa-regular fa-clock me-1"></i> Akan Datang
                </a>
                <a href="{{ url('/agenda') . '?' . http_build_query(array_merge(request()->except(['status_agenda', 'page']), ['status_agenda' => 'ended'])) }}"
                    class="agenda-quick-tab {{ $currStatus === 'ended' ? 'active' : '' }}">
                    <i class="fa-solid fa-circle-check me-1"></i> Selesai
                </a>
            </div>

            <!-- Active Filters Summary Bar (if filter active) -->
            @if ($hasActiveFilter)
                <div class="active-filters-bar mb-4">
                    <span class="active-filter-label"><i class="fa-solid fa-filter text-blue me-1"></i> Filter Aktif:</span>
                    <div class="active-filter-tags">
                        @if (!empty($search))
                            <a href="{{ url('/agenda') . '?' . http_build_query(request()->except(['q', 'page'])) }}"
                                class="filter-tag-pill">
                                <span>Pencarian: "{{ $search }}"</span>
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        @endif
                        @if (!empty($currStatus))
                            @php
                                $statusLabel = match ($currStatus) {
                                    'active' => 'Sedang Berlangsung',
                                    'upcoming' => 'Akan Datang',
                                    'ended' => 'Selesai',
                                    default => $currStatus,
                                };
                            @endphp
                            <a href="{{ url('/agenda') . '?' . http_build_query(request()->except(['status_agenda', 'page'])) }}"
                                class="filter-tag-pill">
                                <span>Status: {{ $statusLabel }}</span>
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        @endif
                        @if (!empty($bulan) && isset($monthsIndo[(int) $bulan]))
                            <a href="{{ url('/agenda') . '?' . http_build_query(request()->except(['bulan', 'page'])) }}"
                                class="filter-tag-pill">
                                <span>Bulan: {{ $monthsIndo[(int) $bulan] }}</span>
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        @endif
                        @if (!empty($tahun))
                            <a href="{{ url('/agenda') . '?' . http_build_query(request()->except(['tahun', 'page'])) }}"
                                class="filter-tag-pill">
                                <span>Tahun: {{ $tahun }}</span>
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        @endif
                        @if (!empty($tglDari))
                            <a href="{{ url('/agenda') . '?' . http_build_query(request()->except(['tgl_dari', 'page'])) }}"
                                class="filter-tag-pill">
                                <span>Dari: {{ \Carbon\Carbon::parse($tglDari)->format('d/m/Y') }}</span>
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        @endif
                        @if (!empty($tglSampai))
                            <a href="{{ url('/agenda') . '?' . http_build_query(request()->except(['tgl_sampai', 'page'])) }}"
                                class="filter-tag-pill">
                                <span>Sampai: {{ \Carbon\Carbon::parse($tglSampai)->format('d/m/Y') }}</span>
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        @endif
                        <a href="{{ url('/agenda') }}" class="clear-all-filters-link">Hapus Semua</a>
                    </div>
                </div>
            @endif

            <!-- FILTER MODAL DIALOG -->
            <div class="informasi-filter-modal" id="informasiFilterModal" aria-hidden="true">
                <div class="filter-modal-backdrop" id="filterModalBackdrop"></div>
                <div class="filter-modal-dialog">
                    <div class="filter-modal-content">
                        <!-- Modal Header -->
                        <div class="filter-modal-header">
                            <div class="modal-header-title">
                                <i class="fa-solid fa-sliders me-1 text-blue"></i>
                                <span>Filter Agenda Kegiatan</span>
                            </div>
                            <button type="button" class="filter-modal-close" id="filterModalClose" aria-label="Tutup">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <div class="filter-modal-body">
                            <form action="{{ url('/agenda') }}" method="GET" id="filterModalForm">
                                <input type="hidden" name="status_agenda" id="filterStatusInput"
                                    value="{{ $statusAgenda ?? '' }}">

                                <!-- Filter Group: Search Input -->
                                <div class="filter-group filter-group-search mb-4">
                                    <label class="filter-group-label"><i class="fa-solid fa-magnifying-glass me-1"></i>
                                        Cari Kata Kunci:</label>
                                    <div class="filter-search-box">
                                        <input type="text" name="q" class="filter-search-input"
                                            id="filterQueryInput"
                                            placeholder="Ketik Nama, Deskripsi, atau Lokasi Agenda ..."
                                            value="{{ $search ?? '' }}">
                                        <button type="button" class="clear-search-btn" id="clearSearchInputBtn"
                                            title="Hapus Teks Pencarian"
                                            style="{{ empty($search) ? 'display:none;' : '' }}">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Filter Group: Status Agenda Pills -->
                                <div class="filter-group mb-4">
                                    <label class="filter-group-label"><i class="fa-solid fa-list-check me-1"></i>
                                        Status Agenda:</label>
                                    <div class="filter-pills-wrap" id="statusPillsGroup">
                                        <button type="button"
                                            class="filter-pill-btn {{ empty($statusAgenda) ? 'active' : '' }}"
                                            data-val="">Semua Status</button>
                                        <button type="button"
                                            class="filter-pill-btn {{ $statusAgenda === 'active' ? 'active' : '' }}"
                                            data-val="active">Sedang Berlangsung</button>
                                        <button type="button"
                                            class="filter-pill-btn {{ $statusAgenda === 'upcoming' ? 'active' : '' }}"
                                            data-val="upcoming">Akan Datang</button>
                                        <button type="button"
                                            class="filter-pill-btn {{ $statusAgenda === 'ended' ? 'active' : '' }}"
                                            data-val="ended">Selesai</button>
                                    </div>
                                </div>

                                <!-- Filter Group: Month & Year Select -->
                                <div class="filter-grid-two-cols mb-4">
                                    <div class="filter-group">
                                        <label class="filter-group-label"><i class="fa-solid fa-calendar-days me-1"></i>
                                            Bulan:</label>
                                        <select name="bulan" class="filter-select-input">
                                            <option value="">-- Semua Bulan --</option>
                                            @foreach ($monthsIndo as $num => $name)
                                                <option value="{{ $num }}"
                                                    {{ (string) $bulan === (string) $num ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="filter-group">
                                        <label class="filter-group-label"><i class="fa-solid fa-calendar me-1"></i>
                                            Tahun:</label>
                                        <select name="tahun" class="filter-select-input">
                                            <option value="">-- Semua Tahun --</option>
                                            @foreach ($availableYears as $yr)
                                                <option value="{{ $yr }}"
                                                    {{ (string) $tahun === (string) $yr ? 'selected' : '' }}>
                                                    Tahun {{ $yr }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Filter Group: Date Range Picker -->
                                <div class="filter-group">
                                    <label class="filter-group-label"><i class="fa-regular fa-calendar-range me-1"></i>
                                        Rentang Tanggal Spesifik:</label>
                                    <div class="filter-grid-two-cols">
                                        <div>
                                            <span class="sub-label">Dari Tanggal:</span>
                                            <input type="date" name="tgl_dari" class="filter-date-input"
                                                value="{{ $tglDari ?? '' }}">
                                        </div>
                                        <div>
                                            <span class="sub-label">Sampai Tanggal:</span>
                                            <input type="date" name="tgl_sampai" class="filter-date-input"
                                                value="{{ $tglSampai ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Modal Footer -->
                        <div class="filter-modal-footer">
                            <a href="{{ url('/agenda') }}" class="btn-reset-filter-modal">
                                <i class="fa-solid fa-rotate-left me-1"></i> Reset Filter
                            </a>
                            <button type="submit" form="filterModalForm" class="btn-apply-modal" id="filterModalApply">
                                Cari & Terapkan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Agenda Grid Container (Matching Reference Screenshot - 3 Columns Grid) -->
            <div class="agenda-page-grid">
                @forelse ($agendas as $a)
                    @php
                        $tglAwal = $a->tgl_awal ? \Carbon\Carbon::parse($a->tgl_awal) : null;
                        $tglAkhirObj = $a->tgl_akhir ? \Carbon\Carbon::parse($a->tgl_akhir) : null;

                        $dayNum = '01';
                        $monthCode = 'JAN';

                        if ($tglAwal) {
                            $dayNum = $tglAwal->format('d');
                            $monthCode = bulan_indo($tglAwal);

                            if ($tglAkhirObj && $tglAkhirObj->format('Y-m-d') !== $tglAwal->format('Y-m-d')) {
                                if ($tglAwal->format('m-Y') === $tglAkhirObj->format('m-Y')) {
                                    $dayNum = $tglAwal->format('d') . '-' . $tglAkhirObj->format('d');
                                }
                            }
                        }

                        // Format rentang tanggal awal s.d. tanggal akhir
                        $dateFormatted = \App\Helpers\DateHelper::formatRentangAgenda($a->tgl_awal, $a->tgl_akhir);

                        // Format rentang jam awal s.d. jam akhir
                        $timeFormatted = '';
                        if ($a->jam_mulai) {
                            $jamMulai = \Carbon\Carbon::parse($a->jam_mulai)->format('H:i');
                            $timeFormatted = $jamMulai;
                            if ($a->jam_akhir) {
                                $jamAkhir = \Carbon\Carbon::parse($a->jam_akhir)->format('H:i');
                                $timeFormatted .= ' - ' . $jamAkhir;
                            }
                            $timeFormatted .= ' WITA';
                        }

                        $now = \Carbon\Carbon::now();
                        $tglAkhirVal = $tglAkhirObj
                            ? $tglAkhirObj->copy()->endOfDay()
                            : ($tglAwal
                                ? $tglAwal->copy()->endOfDay()
                                : null);

                        $statusText = 'Belum Dimulai';
                        $statusBadgeClass = 'status-upcoming-badge';

                        if ($tglAwal && $tglAkhirVal) {
                            if ($now->between($tglAwal->copy()->startOfDay(), $tglAkhirVal)) {
                                $statusText = 'Sedang Berlangsung';
                                $statusBadgeClass = 'status-active-badge';
                            } elseif ($now->gt($tglAkhirVal)) {
                                $statusText = 'Selesai';
                                $statusBadgeClass = 'status-ended-badge';
                            }
                        }
                    @endphp

                    <div class="agenda-ref-card">
                        <!-- Left Calendar Date Badge Box -->
                        <div class="agenda-ref-date-box">
                            <div class="agenda-ref-day" style="{{ strlen($dayNum) > 2 ? 'font-size: 1.05rem;' : '' }}">
                                {{ $dayNum }}
                            </div>
                            <div class="agenda-ref-month">{{ $monthCode }}</div>
                        </div>

                        <!-- Right Content Details -->
                        <div class="agenda-ref-details">
                            <span class="agenda-ref-status {{ $statusBadgeClass }}">{{ $statusText }}</span>
                            <h3 class="agenda-ref-title">
                                <a href="{{ route('website.agenda.detail', $a->slug ?? $a->id_agenda) }}"
                                    title="{{ $a->nama }}">
                                    {{ $a->nama }}
                                </a>
                            </h3>
                            <div class="agenda-ref-meta">
                                <div class="agenda-meta-item" title="Rentang Tanggal Agenda">
                                    <i class="fa-regular fa-calendar-check text-blue"></i>
                                    <span>{{ $dateFormatted }}</span>
                                </div>
                                @if ($timeFormatted)
                                    <div class="agenda-meta-item" title="Rentang Jam Agenda">
                                        <i class="fa-regular fa-clock text-blue"></i>
                                        <span>{{ $timeFormatted }}</span>
                                    </div>
                                @endif
                                @if (!empty($a->tempat))
                                    <div class="agenda-meta-item" title="Lokasi Tempat Agenda">
                                        <i class="fa-solid fa-location-dot text-blue"></i>
                                        <span>{{ $a->tempat }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="informasi-empty-state" style="grid-column: 1 / -1;">
                        <i class="fa-regular fa-calendar-xmark empty-icon"></i>
                        <h3 class="empty-title">Tidak Ada Agenda Kegiatan</h3>
                        <p class="empty-desc">Maaf, belum ada data agenda kegiatan yang sesuai dengan kriteria filter
                            pilihan Anda.</p>
                        <a href="{{ url('/agenda') }}" class="btn-outline-blue mt-3">Reset Filter</a>
                    </div>
                @endforelse
            </div>

            <!-- Custom Pagination -->
            @if ($agendas->hasPages())
                <div class="informasi-pagination-container">
                    <div class="pagination-info-text">
                        Menampilkan {{ $agendas->firstItem() }} - {{ $agendas->lastItem() }} dari total
                        {{ $agendas->total() }}
                        data agenda
                    </div>

                    <ul class="custom-pagination-list">
                        @if ($agendas->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link" aria-hidden="true"><i
                                        class="fa-solid fa-chevron-left"></i></span>
                            </li>
                        @else
                            <li class="page-item">
                                <a href="{{ $agendas->previousPageUrl() }}" class="page-link" rel="prev"
                                    aria-label="Sebelumnya"><i class="fa-solid fa-chevron-left"></i></a>
                            </li>
                        @endif

                        @foreach ($agendas->getUrlRange(1, $agendas->lastPage()) as $page => $url)
                            @if ($page == $agendas->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        @if ($agendas->hasMorePages())
                            <li class="page-item">
                                <a href="{{ $agendas->nextPageUrl() }}" class="page-link" rel="next"
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

            const filterStatusInput = document.getElementById('filterStatusInput');
            const statusPills = document.querySelectorAll('#statusPillsGroup .filter-pill-btn');

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

            // Toggle active pill in modal
            statusPills.forEach(function(pill) {
                pill.addEventListener('click', function() {
                    statusPills.forEach(p => p.classList.remove('active'));
                    this.classList.add('active');
                    if (filterStatusInput) {
                        filterStatusInput.value = this.getAttribute('data-val');
                    }
                });
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
        });
    </script>
@endpush
