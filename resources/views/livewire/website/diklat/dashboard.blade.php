<div class="gis-wrapper">
    <!-- HERO TITLE & SUBTITLE -->
    <div class="gis-header-box mb-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <span class="gis-subtitle-badge mb-2">
                    <i class="fa-solid fa-bar-chart"></i> Dashboard
                </span>
                <h2 class="gis-main-title mb-1">
                    Sistem Informasi Target, Kebutuhan & Realisasi Diklat
                </h2>
                <p class="gis-main-desc mb-0">
                    Balai Pelatihan Koperasi dan Usaha Kecil Provinsi Kalimantan Selatan
                </p>
            </div>
        </div>
    </div>

    <!-- FILTER BAR CARD -->
    <div class="gis-filter-card mb-4">
        <div class="gis-filter-grid {{ $filterTahun || $filterJenisSdm || $selectedWilayahId ? 'mb-3' : '' }}">
            <div class="gis-filter-item">
                <label class="gis-filter-label"><i class="fa-regular fa-calendar me-1"></i> Filter Tahun <span
                        class="text-danger">*</span></label>
                <select class="gis-filter-select" wire:model.live="filterTahun">
                    <option value="">-- Pilih Tahun --</option>
                    @foreach ($tahunOptions as $th)
                        <option value="{{ $th }}">Tahun {{ $th }}</option>
                    @endforeach
                </select>
            </div>

            <div class="gis-filter-item">
                <label class="gis-filter-label"><i class="fa-solid fa-users-gear me-1"></i> Filter Kategori SDM</label>
                <select class="gis-filter-select" wire:model.live="filterJenisSdm"
                    {{ !$filterTahun ? 'disabled' : '' }}>
                    <option value="">Semua SDM (Koperasi & UMKM)</option>
                    <option value="sdm_koperasi">SDM Koperasi</option>
                    <option value="sdm_umkm">SDM UMKM</option>
                </select>
            </div>
        </div>

        @if ($filterTahun || $filterJenisSdm || $selectedWilayahId)
            <div class="gis-filter-actions pt-3 border-top d-flex justify-content-end align-items-center gap-2">
                <span class="text-muted small"><i class="fa-solid fa-filter me-1"></i> Filter aktif</span>
                <button type="button" class="gis-btn-outline" wire:click="resetFilters">
                    <i class="fa-solid fa-arrow-rotate-left me-1"></i> Reset Filter Data
                </button>
            </div>
        @endif
    </div>

    @if ($filterTahun)
        <!-- 4 SUMMARY KPI STATS CARDS -->
        <div class="gis-kpi-grid mb-4">
            <!-- 1. Total Responden -->
            <div class="gis-kpi-card card-blue">
                <div class="gis-kpi-icon-box">
                    <i class="fa-solid fa-people-group"></i>
                </div>
                <div class="gis-kpi-info">
                    <span class="gis-kpi-label">Total Responden</span>
                    <h3 class="gis-kpi-value">{{ number_format($totalResponden) }}</h3>
                    <span class="gis-kpi-badge">Survei IKP T.A. {{ $filterTahun }}</span>
                </div>
            </div>

            <!-- 2. Hasil Survei Kebutuhan -->
            <div class="gis-kpi-card card-cyan">
                <div class="gis-kpi-icon-box">
                    <i class="fa-solid fa-clipboard-list"></i>
                </div>
                <div class="gis-kpi-info">
                    <span class="gis-kpi-label">Hasil Survei Kebutuhan</span>
                    <h3 class="gis-kpi-value">{{ number_format($totalKebutuhan) }}</h3>
                    <span class="gis-kpi-badge">Usulan Kebutuhan Diklat</span>
                </div>
            </div>

            <!-- 3. Target / Kuota -->
            <div class="gis-kpi-card card-amber">
                <div class="gis-kpi-icon-box">
                    <i class="fa-solid fa-bullseye"></i>
                </div>
                <div class="gis-kpi-info">
                    <span class="gis-kpi-label">Target / Kuota</span>
                    <h3 class="gis-kpi-value">{{ number_format($totalTargetPeserta) }}</h3>
                    <span class="gis-kpi-badge">Kuota Peserta T.A. {{ $filterTahun }}</span>
                </div>
            </div>

            <!-- 4. Realisasi -->
            <div class="gis-kpi-card card-green">
                <div class="gis-kpi-icon-box">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
                <div class="gis-kpi-info">
                    <span class="gis-kpi-label">Realisasi</span>
                    <h3 class="gis-kpi-value">{{ number_format($totalPeserta) }}</h3>
                    <span class="gis-kpi-badge">Alumni Terlatih T.A. {{ $filterTahun }}</span>
                </div>
            </div>
        </div>

        <!-- PENJELASAN MAKNA INDIKATOR CARD (INFO GUIDE BOX) -->
        <div class="gis-info-guide-card mb-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <i class="fa-solid fa-circle-info text-primary fs-5"></i>
                <h6 class="fw-bold text-dark mb-0">Penjelasan Indikator Utama Dashboard Diklat T.A. {{ $filterTahun }}
                </h6>
            </div>
            <div class="gis-info-guide-grid">
                <div class="gis-info-guide-item">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge-dot bg-blue"></span>
                        <strong class="text-dark small">Total Responden</strong>
                    </div>
                    <p class="gis-info-guide-desc">
                        Jumlah pelaku Koperasi & UMKM di Kalsel yang berpartisipasi mengisi survei Identifikasi
                        Kebutuhan Pelatihan (IKP).
                    </p>
                </div>

                <div class="gis-info-guide-item">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge-dot bg-cyan"></span>
                        <strong class="text-dark small">Hasil Survei Kebutuhan</strong>
                    </div>
                    <p class="gis-info-guide-desc">
                        Jumlah akumulasi usulan keikutsertaan program diklat yang diajukan responden sesuai kebutuhan
                        pengembangan kompetensi.
                    </p>
                </div>

                <div class="gis-info-guide-item">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge-dot bg-amber"></span>
                        <strong class="text-dark small">Target / Kuota</strong>
                    </div>
                    <p class="gis-info-guide-desc">
                        Jumlah kuota alokasi peserta diklat yang direncanakan dan didanai oleh anggaran APBD pada T.A.
                        {{ $filterTahun }}.
                    </p>
                </div>

                <div class="gis-info-guide-item">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge-dot bg-green"></span>
                        <strong class="text-dark small">Realisasi</strong>
                    </div>
                    <p class="gis-info-guide-desc">
                        Jumlah aktual alumni peserta yang telah selesai mengikuti dan lulus pelaksanaan pelatihan
                        Balatkop-UK Kalsel.
                    </p>
                </div>
            </div>
        </div>

        <!-- TARGET TABLE SECTION -->
        <div class="gis-detail-card mb-4" wire:key="target-table-top-{{ $filterTahun }}">
            <div class="gis-summary-matrix-card">
                <div class="gis-summary-header mb-3">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-3 py-1">
                            <div
                                class="rounded-circle p-2 bg-warning bg-opacity-10 text-warning d-inline-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-bullseye fs-2"></i>
                            </div>
                            <div>
                                <h3 class="fw-extrabold text-dark mb-1"
                                    style="font-size: 1.85rem; font-weight: 800; letter-spacing: -0.5px;">Target Diklat
                                    T.A. {{ $filterTahun }}</h3>
                                <span
                                    class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-1 rounded-pill fw-semibold fs-2">
                                    Alokasi Kuota Diklat Resmi
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="gis-matrix-table">
                        <thead>
                            <tr>
                                <th style="width: 50px;" class="text-center">No</th>
                                <th>Judul Pendidikan dan Pelatihan</th>
                                <th style="width: 150px;" class="text-center">Kategori SDM</th>
                                <th style="width: 200px;" class="text-center">Target</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($targetList as $idx => $tRow)
                                <tr>
                                    <td class="text-center font-monospace fw-bold text-muted">{{ $idx + 1 }}</td>
                                    <td>
                                        <strong class="text-dark">{{ $tRow['nama_diklat'] }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge {{ $tRow['jenis_sdm'] === 'sdm_koperasi' ? 'bg-primary-subtle text-primary border-primary-subtle' : 'bg-success-subtle text-success border-success-subtle' }}"
                                            style="font-size: 0.68rem; font-weight: 600; padding: 3px 8px; border-radius: 6px; text-transform: uppercase;">
                                            {{ $tRow['jenis_sdm'] === 'sdm_koperasi' ? 'SDM Koperasi' : 'SDM UMKM' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="fw-bold text-warning fs-6">
                                            <i class="fa-solid fa-users me-1"></i>{{ number_format($tRow['target']) }}
                                            Orang
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        Belum ada data target kuota peserta diklat untuk Tahun {{ $filterTahun }}.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if ($targetList->count() > 0)
                            <tfoot>
                                <tr class="fw-bold bg-light">
                                    <td colspan="3" class="text-end text-dark pe-3">TOTAL TARGET KUOTA PESERTA T.A.
                                        {{ $filterTahun }}:</td>
                                    <td class="text-center text-warning fs-6">
                                        {{ number_format($targetList->sum('target')) }} Orang
                                    </td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        <!-- CAPAIAN TARGET DIKLAT (PREMIUM CARD WITH FULL-WIDTH LINE PROGRESS BAR) -->
        <div class="gis-detail-card mb-4" wire:key="capaian-target-card-{{ $filterTahun }}">
            <div class="gis-capaian-hero-card">
                @php
                    $targetCount = $totalTargetPeserta;
                    $realisasiCount = $totalPeserta;
                    $pctVal = $targetCount > 0 ? round(($realisasiCount / $targetCount) * 100, 1) : 0;
                    $sisaTarget = max(0, $targetCount - $realisasiCount);
                    $fillWidth = min(100, max(0, $pctVal));
                @endphp

                <!-- HEADER WITH ICON & STATUS BADGE -->
                <div class="gis-capaian-hero-header mb-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="gis-icon-circle-badge bg-primary bg-opacity-10 text-primary">
                                <i class="fa-solid fa-bullseye"></i>
                            </span>
                            <div>
                                <h5 class="fw-bold text-dark mb-0">Progres Capaian Target Pelatihan dan Pendidikan</h5>
                                <small class="text-muted">Progres capaian target pelatihan dan pendidikan T.A.
                                    {{ $filterTahun }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MAIN BLOCK: CENTERED NUMBERS, LOADING BAR WITH PERCENTAGE BESIDE IT, AND SISA TARGET -->
                <div class="gis-capaian-main-block text-center py-2" style="max-width: 620px; margin: 0 auto;">
                    <!-- 1. CENTERED RATIO NUMBER: 60 / 150 Peserta -->
                    <div class="gis-capaian-ratio-value mb-2 text-center">
                        <span
                            class="text-primary fw-extrabold">{{ number_format($realisasiCount, 0, ',', '.') }}</span>
                        <span class="text-muted mx-1 fs-3">/</span>
                        <span class="text-dark fw-bold">{{ number_format($targetCount, 0, ',', '.') }}</span>
                        <span class="text-muted small ms-2 fw-semibold">Peserta</span>
                    </div>

                    <!-- 2. LOADING LINE PROGRESS BAR WITH PERCENTAGE DIRECTLY BESIDE IT -->
                    <div class="d-flex align-items-center gap-3 my-3">
                        <div class="gis-progress-track-line flex-grow-1">
                            <div class="gis-progress-bar-line {{ $pctVal >= 100 ? 'gradient-success' : ($pctVal >= 50 ? 'gradient-primary' : ($pctVal > 0 ? 'gradient-amber' : 'gradient-muted')) }}"
                                style="width: {{ $fillWidth }}%;">
                                <span class="gis-bar-shimmer"></span>
                            </div>
                        </div>
                        <span
                            class="gis-pct-badge {{ $pctVal >= 100 ? 'pct-success' : ($pctVal > 0 ? 'pct-primary' : 'pct-muted') }}">
                            {{ number_format($pctVal, 1, ',', '.') }}%
                        </span>
                    </div>

                    <!-- 3. CENTERED SISA TARGET FOOTER -->
                    <div class="gis-capaian-sisa-pill mt-3">
                        <i class="fa-solid fa-user-clock text-warning me-1"></i>
                        Sisa target: <strong class="text-dark ms-1">{{ number_format($sisaTarget, 0, ',', '.') }}
                            Peserta</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- UNIFIED STATISTIK, MAP, SEBARAN WILAYAH & RINCIAN CARD -->
        <div class="gis-detail-card mb-4" wire:key="statistik-map-card-{{ $filterTahun }}">
            <!-- HEADER UNIFIKASI STATISTIK -->
            <div class="gis-summary-header mb-4 pb-3 border-bottom">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="gis-icon-circle-badge bg-primary bg-opacity-10 text-primary">
                            <i class="fa-solid fa-earth-asia"></i>
                        </span>
                        <div>
                            <h3 class="fw-bold text-dark mb-1" style="font-size: 1.35rem;">Statistik Diklat dan
                                Sebaran Wilayah</h3>
                            <small class="text-muted"> Data Kebutuhan,
                                Target/Kuota dan Realisasi Diklat
                                {{ $filterTahun }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MAP CONTAINER & QUICK SELECTOR ROW (PETA & MENU WILAYAH) -->
            <div class="gis-map-row mb-4">
                <!-- GIS LEAFLET MAP COL -->
                <div class="gis-map-col">
                    <div class="gis-map-wrapper">
                        <div class="gis-map-header">
                            <div class="gis-flex-center gap-2">
                                <i class="fa-solid fa-map-location-dot text-primary"></i>
                                <span class="fw-bold text-dark">Peta Kalimantan Selatan</span>
                            </div>
                            <small class="text-muted"><i class="fa-solid fa-hand-pointer me-1"></i> Klik
                                lokasi</small>
                        </div>

                        <!-- LEAFLET MAP ELEMENT -->
                        <div id="gisMap" class="gis-map-container" wire:ignore></div>
                    </div>
                </div>

                <!-- KALSEL REGION QUICK GRID SIDEBAR -->
                <div class="gis-sidebar-col">
                    <div class="gis-region-sidebar">
                        <div class="gis-sidebar-header">
                            <h5 class="fw-bold mb-1 text-dark"><i
                                    class="fa-solid fa-list-check text-primary me-1"></i> 13 Kab/Kota Prov. Kalsel</h5>
                            <p class="small text-muted mb-0">Pilih salah satu nama wilayah untuk melihat rincian</p>
                        </div>

                        <div class="gis-region-list">
                            @foreach ($mapData as $m)
                                <div class="gis-region-item {{ $selectedWilayahId == $m['id_wilayah'] ? 'active' : '' }}"
                                    wire:click="selectWilayah({{ $m['id_wilayah'] }})">
                                    <div class="gis-region-item-top mb-1">
                                        <span class="gis-region-name">{{ $m['nama'] }}</span>
                                    </div>
                                    <div class="gis-region-stats-grid">
                                        <div class="stat-badge stat-blue">
                                            <span class="stat-label">Responden</span>
                                            <span class="stat-val">{{ number_format($m['responden']) }}</span>
                                        </div>
                                        <div class="stat-badge stat-cyan">
                                            <span class="stat-label">Kebutuhan</span>
                                            <span class="stat-val">{{ number_format($m['kebutuhan']) }}</span>
                                        </div>
                                        <div class="stat-badge stat-amber">
                                            <span class="stat-label">Target</span>
                                            <span class="stat-val">{{ number_format($m['target']) }}</span>
                                        </div>
                                        <div class="stat-badge stat-green">
                                            <span class="stat-label">Realisasi</span>
                                            <span class="stat-val">{{ number_format($m['realisasi']) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- SELECTED REGION DETAILED BREAKDOWN & REKAPITULASI RINCIAN SECTION -->
            <div id="regionDetailSection" class="pt-4 border-top">
                @if ($selectedWilayah)
                    <div class="gis-summary-matrix-card mb-4" wire:key="detail-{{ $selectedWilayah->id_wilayah }}">
                        <!-- HEADER BANNER -->
                        <div class="gis-detail-header-row mb-4">
                            <div class="gis-detail-title-wrap">
                                <div class="gis-region-icon-circle">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <div>
                                    <div class="gis-detail-meta">
                                        <span class="gis-badge badge-blue-pill">
                                            {{ ucfirst($selectedWilayah->jenis) }}
                                        </span>
                                    </div>
                                    <h3 class="gis-detail-title mb-1">{{ $selectedWilayah->nama }}</h3>
                                    <div class="mt-1">
                                        <span
                                            class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 fs-6">
                                            <i class="fa-solid fa-users me-1"></i> Total
                                            {{ number_format($selectedWilayahResponden) }} Responden Survei IKP
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="gis-btn-close"
                                wire:click="selectWilayah({{ $selectedWilayah->id_wilayah }})">
                                <i class="fa-solid fa-xmark"></i> Tutup Rincian
                            </button>
                        </div>

                        <!-- RINCIAN TABEL DIKLAT WILAYAH -->
                        <div class="gis-summary-header mb-3">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-table text-primary fs-5"></i>
                                    <div>
                                        <h5 class="fw-bold text-dark mb-0">Rincian Diklat Wilayah
                                            {{ $selectedWilayah->nama }}</h5>
                                        <small class="text-muted">Rincian usulan kebutuhan IKP, target kuota peserta,
                                            dan realisasi alumni T.A. {{ $filterTahun }}</small>
                                    </div>
                                </div>
                                <span class="gis-badge badge-blue-pill">
                                    <i class="fa-regular fa-calendar me-1"></i> Tahun {{ $filterTahun }}
                                </span>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="gis-matrix-table">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;" class="text-center">No</th>
                                        <th>Nama Program Pelatihan / Judul Diklat</th>
                                        <th style="width: 150px;" class="text-center">Kategori SDM</th>
                                        <th style="width: 160px;" class="text-center">Kebutuhan (IKP)</th>
                                        <th style="width: 160px;" class="text-center">Target / Kuota</th>
                                        <th style="width: 160px;" class="text-center">Realisasi Alumni</th>
                                        <th style="width: 160px;" class="text-center">Capaian / Target</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($selectedSummaryTable as $idx => $row)
                                        <tr>
                                            <td class="text-center font-monospace fw-bold text-muted">
                                                {{ $idx + 1 }}</td>
                                            <td>
                                                <strong class="text-dark">{{ $row['nama_diklat'] }}</strong>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="badge {{ $row['jenis_sdm'] === 'sdm_koperasi' ? 'bg-primary-subtle text-primary border-primary-subtle' : 'bg-success-subtle text-success border-success-subtle' }}"
                                                    style="font-size: 0.68rem; font-weight: 600; padding: 3px 8px; border-radius: 6px; text-transform: uppercase;">
                                                    {{ $row['jenis_sdm'] === 'sdm_koperasi' ? 'SDM Koperasi' : 'SDM UMKM' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="fw-bold text-primary">{{ number_format($row['kebutuhan']) }}
                                                    Orang</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="fw-bold text-warning">{{ number_format($row['target']) }}
                                                    Orang</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="fw-bold text-success">{{ number_format($row['alumni']) }}
                                                    Alumni</span>
                                            </td>
                                            <td class="text-center">
                                                @if ($row['target'] > 0)
                                                    @php $pctTrg = round(($row['alumni'] / $row['target']) * 100); @endphp
                                                    <span
                                                        class="gis-status-pill {{ $pctTrg >= 100 ? 'pill-success' : ($pctTrg > 0 ? 'pill-info' : 'pill-muted') }}">
                                                        {{ $pctTrg }}% Target
                                                    </span>
                                                @else
                                                    <span class="gis-status-pill pill-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">
                                                Belum ada data rincian program diklat untuk
                                                {{ $selectedWilayah->nama }} pada Tahun {{ $filterTahun }}.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                @if ($selectedSummaryTable->count() > 0)
                                    <tfoot>
                                        <tr class="fw-bold bg-light">
                                            <td colspan="3" class="text-end text-dark pe-3">TOTAL RINCIAN WILAYAH
                                                {{ strtoupper($selectedWilayah->nama) }}:</td>
                                            <td class="text-center text-primary fs-6">
                                                {{ number_format($selectedSummaryTable->sum('kebutuhan')) }} Orang</td>
                                            <td class="text-center text-warning fs-6">
                                                {{ number_format($selectedSummaryTable->sum('target')) }} Orang</td>
                                            <td class="text-center text-success fs-6">
                                                {{ number_format($selectedSummaryTable->sum('alumni')) }} Alumni</td>
                                            <td class="text-center">
                                                @php
                                                    $totTrg = $selectedSummaryTable->sum('target');
                                                    $totAlm = $selectedSummaryTable->sum('alumni');
                                                    $totPct = $totTrg > 0 ? round(($totAlm / $totTrg) * 100) : 0;
                                                @endphp
                                                <span
                                                    class="gis-status-pill {{ $totPct >= 100 ? 'pill-success' : 'pill-info' }}">
                                                    {{ $totPct }}% Total
                                                </span>
                                            </td>
                                        </tr>
                                    </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                @endif

                <!-- TABEL DATA REKAPITULASI PER WILAYAH -->
                <div class="gis-summary-matrix-card" wire:key="rekap-wilayah-table-{{ $filterTahun }}">
                    <div class="gis-summary-header mb-3">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-map-location-dot text-primary fs-4"></i>
                                <div>
                                    <h5 class="fw-bold text-dark mb-0">Rekapitulasi Data Diklat Per Wilayah T.A.
                                        {{ $filterTahun }}</h5>
                                    <small class="text-muted">Perbandingan Responden, Kebutuhan IKP, Target/Kuota, dan
                                        Realisasi Alumni di 13 Kabupaten/Kota</small>
                                </div>
                            </div>
                            <span class="gis-badge badge-blue-pill">
                                <i class="fa-solid fa-earth-asia me-1"></i> 13 Kab/Kota Kalsel
                            </span>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="gis-matrix-table">
                            <thead>
                                <tr>
                                    <th style="width: 50px;" class="text-center">No</th>
                                    <th>Kabupaten / Kota</th>
                                    <th style="width: 160px;" class="text-center">Responden</th>
                                    <th style="width: 160px;" class="text-center">Kebutuhan (IKP)</th>
                                    <th style="width: 160px;" class="text-center">Target / Kuota</th>
                                    <th style="width: 160px;" class="text-center">Realisasi / Alumni</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($mapData as $idx => $m)
                                    <tr style="cursor: pointer;" wire:click="selectWilayah({{ $m['id_wilayah'] }})"
                                        class="gis-row-hover {{ $selectedWilayahId == $m['id_wilayah'] ? 'table-primary fw-bold' : '' }}">
                                        <td class="text-center font-monospace fw-bold text-muted">{{ $idx + 1 }}
                                        </td>
                                        <td>
                                            <strong class="text-dark">{{ $m['nama'] }}</strong>
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-bold text-primary">{{ number_format($m['responden']) }}
                                                Orang</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-bold text-info">{{ number_format($m['kebutuhan']) }}
                                                Orang</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-bold text-warning">{{ number_format($m['target']) }}
                                                Orang</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-bold text-success">{{ number_format($m['realisasi']) }}
                                                Alumni</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            Belum ada data wilayah untuk Tahun {{ $filterTahun }}.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if (count($mapData) > 0)
                                <tfoot>
                                    <tr class="fw-bold bg-light">
                                        <td colspan="2" class="text-end text-dark pe-3">TOTAL:</td>
                                        <td class="text-center text-primary fs-6">
                                            {{ number_format(collect($mapData)->sum('responden')) }} Orang</td>
                                        <td class="text-center text-info fs-6">
                                            {{ number_format(collect($mapData)->sum('kebutuhan')) }} Orang</td>
                                        <td class="text-center text-warning fs-6">
                                            {{ number_format(collect($mapData)->sum('target')) }} Orang</td>
                                        <td class="text-center text-success fs-6">
                                            {{ number_format(collect($mapData)->sum('realisasi')) }} Alumni</td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD PERBANDINGAN PER PROGRAM DIKLAT (PALING BAWAH HALAMAN) -->
        <div class="gis-detail-card mb-4" wire:key="perbandingan-program-card-{{ $filterTahun }}">
            <div class="gis-capaian-hero-card">
                <!-- HEADER CARD -->
                <div class="gis-capaian-hero-header mb-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="gis-icon-circle-badge bg-info bg-opacity-10 text-info">
                                <i class="fa-solid fa-chart-bar"></i>
                            </span>
                            <div>
                                <h5 class="fw-bold text-dark mb-0">Perbandingan Kebutuhan, Target/Kuota & Realisasi Per
                                    Judul Diklat</h5>
                                <small class="text-muted">Rincian grafik perbandingan usulan kebutuhan, jumlah
                                    responden, dan realisasi alumni per judul diklat T.A. {{ $filterTahun }}</small>
                            </div>
                        </div>
                        <span class="gis-badge badge-blue-pill">
                            <i class="fa-solid fa-list-check me-1"></i> {{ $overallSummaryTable->count() }} Kegiatan
                            Diklat
                        </span>
                    </div>
                </div>

                <!-- PROGRAM BARCHART LIST (2 JUDUL DIKLAT PER BARIS) -->
                <div class="gis-capaian-main-block py-2">
                    @if ($overallSummaryTable->count() > 0)
                        <div class="gis-hbar-grid">
                            @foreach ($overallSummaryTable as $item)
                                @php
                                    $kVal = (int) ($item['kebutuhan'] ?? 0);
                                    $tVal = (int) ($item['target'] ?? 0);
                                    $rVal = (int) ($item['alumni'] ?? 0);
                                    $barMax = max($kVal, $tVal, $rVal, 1);

                                    $pctK = round(($kVal / $barMax) * 100, 1);
                                    $pctT = round(($tVal / $barMax) * 100, 1);
                                    $pctR = round(($rVal / $barMax) * 100, 1);

                                    $isOddLast = $loop->last && $loop->count % 2 !== 0;
                                @endphp

                                <div class="gis-hbar-card {{ $isOddLast ? 'gis-hbar-card-last-odd' : '' }}">
                                    <!-- Judul Diklat (Tanpa Ikon) & Badge Kategori SDM (Biru = Koperasi, Hijau = UMKM) -->
                                    <div class="d-flex align-items-start justify-content-between gap-2 mb-3">
                                        <h6 class="fw-bold text-dark mb-0 lh-sm"
                                            style="font-size: 0.98rem; color: #0f172a;">
                                            {{ $item['nama_diklat'] }}
                                        </h6>
                                        <span
                                            class="badge {{ $item['jenis_sdm'] === 'sdm_koperasi' ? 'bg-primary-subtle text-primary border-primary-subtle' : 'bg-success-subtle text-success border-success-subtle' }} flex-shrink-0"
                                            style="font-size: 0.65rem; font-weight: 600; padding: 3px 8px; border-radius: 6px; text-transform: uppercase; letter-spacing: 0.03em;">
                                            {{ $item['jenis_sdm'] === 'sdm_koperasi' ? 'SDM Koperasi' : 'SDM UMKM' }}
                                        </span>
                                    </div>

                                    <!-- CHART ROWS -->
                                    <div class="gis-hbar-rows">

                                        <!-- KEBUTUHAN -->
                                        <div class="gis-hbar-row">
                                            <span class="gis-hbar-label">Kebutuhan</span>
                                            <div class="gis-hbar-track">
                                                <div class="gis-hbar-fill gis-hbar-cyan"
                                                    style="width: {{ $pctK }}%;">
                                                </div>
                                            </div>
                                            <span class="gis-hbar-val">{{ number_format($kVal, 0, ',', '.') }}</span>
                                        </div>

                                        <!-- TARGET -->
                                        <div class="gis-hbar-row">
                                            <span class="gis-hbar-label">Target</span>
                                            <div class="gis-hbar-track">
                                                <div class="gis-hbar-fill gis-hbar-blue"
                                                    style="width: {{ $pctT }}%;">
                                                </div>
                                            </div>
                                            <span class="gis-hbar-val">{{ number_format($tVal, 0, ',', '.') }}</span>
                                        </div>

                                        <!-- REALISASI -->
                                        <div class="gis-hbar-row">
                                            <span class="gis-hbar-label">Realisasi</span>
                                            <div class="gis-hbar-track">
                                                <div class="gis-hbar-fill gis-hbar-green"
                                                    style="width: {{ $pctR }}%;">
                                                </div>
                                            </div>
                                            <span class="gis-hbar-val">{{ number_format($rVal, 0, ',', '.') }}</span>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-muted small">
                            <i class="fa-solid fa-folder-open d-block mb-1 fs-5"></i>
                            Belum ada data perbandingan program diklat untuk Tahun {{ $filterTahun }}.
                        </div>
                    @endif
                </div>

            </div>
        </div>

        <!-- CARD BARCHART TINGGI PERBANDINGAN 4 INDIKATOR (PALING BAWAH HALAMAN) -->
        <div class="gis-detail-card mb-4" wire:key="barchart-tinggi-card-{{ $filterTahun }}">
            <div class="gis-vbar-card">
                <!-- HEADER CARD -->
                <div class="gis-summary-header mb-3">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="gis-icon-circle-badge bg-primary bg-opacity-10 text-primary">
                                <i class="fa-solid fa-chart-column"></i>
                            </span>
                            <div>
                                <h5 class="fw-bold text-dark mb-0">Grafik Akumulasi Perbandingan 4 Indikator Utama T.A.
                                    {{ $filterTahun }}</h5>
                                <small class="text-muted">Visualisasi grafik batang tinggi perbandingan Total
                                    Responden, Usulan Kebutuhan IKP, Kuota APBD, dan Realisasi Alumni</small>
                            </div>
                        </div>
                        <span class="gis-badge badge-blue-pill">
                            <i class="fa-solid fa-chart-pie me-1"></i> Akumulasi T.A. {{ $filterTahun }}
                        </span>
                    </div>
                </div>

                @php
                    $vMax = max($totalResponden, $totalKebutuhan, $totalTargetPeserta, $totalPeserta, 1);
                    $pctResp = ($totalResponden / $vMax) * 100;
                    $pctKebut = ($totalKebutuhan / $vMax) * 100;
                    $pctTarget = ($totalTargetPeserta / $vMax) * 100;
                    $pctRealisasi = ($totalPeserta / $vMax) * 100;

                    // Ensure minimum visual height floor of 12% so low numbers stand tall & clear
                    $hResp = max($totalResponden > 0 ? 12 : 0, round($pctResp));
                    $hKebut = max($totalKebutuhan > 0 ? 12 : 0, round($pctKebut));
                    $hTarget = max($totalTargetPeserta > 0 ? 12 : 0, round($pctTarget));
                    $hRealisasi = max($totalPeserta > 0 ? 12 : 0, round($pctRealisasi));
                @endphp

                <!-- CHART AREA (4 PURE SOLID VERTICAL BARS) -->
                <div class="gis-vbar-chart-area">
                    <!-- BAR 1: RESPONDEN -->
                    <div class="gis-vbar-col">
                        <span
                            class="gis-vbar-val-top text-primary">{{ number_format($totalResponden, 0, ',', '.') }}</span>
                        <div class="gis-vbar-pure-bar vbar-fill-responden" style="height: {{ $hResp }}%;">
                        </div>
                        <div class="gis-vbar-label-block">
                            <span class="gis-vbar-badge-icon bg-primary bg-opacity-10 text-primary">
                                <i class="fa-solid fa-users"></i>
                            </span>
                            <div class="gis-vbar-title">Responden</div>
                            <div class="gis-vbar-sub">Survei IKP</div>
                        </div>
                    </div>

                    <!-- BAR 2: KEBUTUHAN -->
                    <div class="gis-vbar-col">
                        <span
                            class="gis-vbar-val-top text-info">{{ number_format($totalKebutuhan, 0, ',', '.') }}</span>
                        <div class="gis-vbar-pure-bar vbar-fill-kebutuhan" style="height: {{ $hKebut }}%;">
                        </div>
                        <div class="gis-vbar-label-block">
                            <span class="gis-vbar-badge-icon bg-info bg-opacity-10 text-info">
                                <i class="fa-solid fa-clipboard-list"></i>
                            </span>
                            <div class="gis-vbar-title">Kebutuhan</div>
                            <div class="gis-vbar-sub">Usulan IKP</div>
                        </div>
                    </div>

                    <!-- BAR 3: KUOTA APBD / TARGET -->
                    <div class="gis-vbar-col">
                        <span
                            class="gis-vbar-val-top text-warning">{{ number_format($totalTargetPeserta, 0, ',', '.') }}</span>
                        <div class="gis-vbar-pure-bar vbar-fill-target" style="height: {{ $hTarget }}%;"></div>
                        <div class="gis-vbar-label-block">
                            <span class="gis-vbar-badge-icon bg-warning bg-opacity-10 text-warning">
                                <i class="fa-solid fa-bullseye"></i>
                            </span>
                            <div class="gis-vbar-title">Kuota APBD</div>
                            <div class="gis-vbar-sub">Target Peserta</div>
                        </div>
                    </div>

                    <!-- BAR 4: REALISASI ALUMNI -->
                    <div class="gis-vbar-col">
                        <span
                            class="gis-vbar-val-top text-success">{{ number_format($totalPeserta, 0, ',', '.') }}</span>
                        <div class="gis-vbar-pure-bar vbar-fill-realisasi" style="height: {{ $hRealisasi }}%;">
                        </div>
                        <div class="gis-vbar-label-block">
                            <span class="gis-vbar-badge-icon bg-success bg-opacity-10 text-success">
                                <i class="fa-solid fa-user-check"></i>
                            </span>
                            <div class="gis-vbar-title">Realisasi</div>
                            <div class="gis-vbar-sub">Alumni Terlatih</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- EMPTY STATE NOTICE REQUIRING YEAR SELECTION -->
        <div class="gis-detail-card mb-4 text-center py-5">
            <div class="py-4 px-3" style="max-width: 650px; margin: 0 auto;">
                <div class="mb-4">
                    <span
                        class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle shadow-sm"
                        style="width: 84px; height: 84px; font-size: 2.4rem;">
                        <i class="fa-regular fa-calendar-check"></i>
                    </span>
                </div>
                <h4 class="fw-bold text-dark mb-2">Silakan Pilih Tahun Anggaran Terlebih Dahulu</h4>
                <p class="text-muted mb-4 fs-6">
                    Untuk menampilkan data Responden Survei Kebutuhan (IKP), Target Kuota Peserta, Realisasi Alumni,
                    Peta Sebaran Wilayah, dan Rekapitulasi Diklat, silakan tentukan <strong>Filter Tahun</strong>
                    terlebih dahulu pada dropdown di atas.
                </p>
                <div
                    class="d-inline-flex align-items-center gap-2 px-4 py-2 bg-light rounded-pill text-secondary small border">
                    <i class="fa-solid fa-arrow-up text-primary me-1"></i> Gunakan pilihan <strong>Filter
                        Tahun</strong> di atas untuk melihat data
                </div>
            </div>
        </div>
    @endif

    <!-- EMBED SCRIPT TO PASS DATA TO LEAFLET JS -->
    <script>
        const renderGisMap = (customMapData) => {
            const mapData = customMapData || @json($mapData);
            if (window.initGisMap && mapData && mapData.length > 0) {
                setTimeout(() => {
                    window.initGisMap(mapData, @this);
                }, 150);
            }
        };

        document.addEventListener('livewire:initialized', () => renderGisMap());
        document.addEventListener('livewire:navigated', () => renderGisMap());

        document.addEventListener('DOMContentLoaded', () => {
            renderGisMap();
        });

        window.addEventListener('initGisMap', (event) => {
            const detail = Array.isArray(event.detail) ? event.detail[0] : event.detail;
            const mapData = detail?.mapData || detail;
            renderGisMap(mapData);
        });
    </script>
</div>
