<div class="gis-wrapper">
    <!-- HERO TITLE & SUBTITLE -->
    <div class="gis-header-box mb-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <span class="gis-subtitle-badge mb-2">
                    <i class="fa-solid fa-map-location-dot"></i> SIG Dashboard Diklat
                </span>
                <h2 class="gis-main-title mb-1">
                    Sistem Informasi Geografis Kebutuhan & Realisasi Diklat
                </h2>
                <p class="gis-main-desc mb-0">
                    Balai Pelatihan Koperasi dan Usaha Kecil Provinsi Kalimantan Selatan
                </p>
            </div>
        </div>
    </div>

    <!-- 3 SUMMARY KPI STATS CARDS -->
    <div class="gis-kpi-grid mb-4">
        <!-- 1. Total Responden IKP (KIRI) -->
        <div class="gis-kpi-card card-blue">
            <div class="gis-kpi-icon-box">
                <i class="fa-solid fa-people-group"></i>
            </div>
            <div class="gis-kpi-info">
                <span class="gis-kpi-label">Responden Survei IKP</span>
                <h3 class="gis-kpi-value">{{ number_format($totalResponden) }}</h3>
                <span class="gis-kpi-badge">Identifikasi Kebutuhan Pelatihan</span>
            </div>
        </div>

        <!-- 2. Target Tahun Anggaran (DITENGAH) -->
        <div class="gis-kpi-card card-amber">
            <div class="gis-kpi-icon-box">
                <i class="fa-solid fa-bullseye"></i>
            </div>
            <div class="gis-kpi-info">
                <span class="gis-kpi-label">Target Tahun Anggaran</span>
                <h3 class="gis-kpi-value">{{ number_format($totalTargetPeserta) }}</h3>
                <span class="gis-kpi-badge">Target Kuota Peserta Diklat</span>
            </div>
        </div>

        <!-- 3. Total Peserta Dilatih (KANAN) -->
        <div class="gis-kpi-card card-green">
            <div class="gis-kpi-icon-box">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
            <div class="gis-kpi-info">
                <span class="gis-kpi-label">Peserta Telah Dilatih</span>
                <h3 class="gis-kpi-value">{{ number_format($totalPeserta) }}</h3>
                <span class="gis-kpi-badge">Realisasi Alumni</span>
            </div>
        </div>
    </div>

    <!-- FILTER BAR CARD -->
    <div class="gis-filter-card mb-4">
        <div
            class="gis-filter-grid {{ $filterTahun || $filterJenisSdm || $filterWilayahId || $selectedWilayahId ? 'mb-3' : '' }}">
            <div class="gis-filter-item">
                <label class="gis-filter-label"><i class="fa-regular fa-calendar"></i> Filter Tahun</label>
                <select class="gis-filter-select" wire:model.live="filterTahun">
                    <option value="">Semua</option>
                    @foreach ($tahunOptions as $th)
                        <option value="{{ $th }}">Tahun {{ $th }}</option>
                    @endforeach
                </select>
            </div>

            <div class="gis-filter-item">
                <label class="gis-filter-label"><i class="fa-solid fa-users-gear"></i> Filter Kategori SDM</label>
                <select class="gis-filter-select" wire:model.live="filterJenisSdm">
                    <option value="">Semua</option>
                    <option value="sdm_koperasi">SDM Koperasi</option>
                    <option value="sdm_umkm">SDM UMKM</option>
                </select>
            </div>

            <div class="gis-filter-item">
                <label class="gis-filter-label"><i class="fa-solid fa-location-dot"></i> Filter Kabupaten / Kota</label>
                <select class="gis-filter-select" wire:model.live="filterWilayahId">
                    <option value="">Semua</option>
                    @foreach ($wilayahs as $w)
                        <option value="{{ $w->id_wilayah }}">{{ $w->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @if ($filterTahun || $filterJenisSdm || $filterWilayahId || $selectedWilayahId)
            <div class="gis-filter-actions pt-3 border-top d-flex justify-content-end align-items-center gap-2">
                <span class="text-muted small"><i class="fa-solid fa-filter me-1"></i> Filter aktif</span>
                <button type="button" class="gis-btn-outline" wire:click="resetFilters">
                    <i class="fa-solid fa-arrow-rotate-left"></i> Reset Filter Data
                </button>
            </div>
        @endif
    </div>

    <!-- TARGET TABLE SECTION (POSISI SEMULA DI BAWAH FILTER BAR) -->
    @if ($filterTahun)
        <div class="gis-detail-card mb-4" wire:key="target-table-top-{{ $filterTahun }}">
            <div class="gis-summary-matrix-card">
                <div class="gis-summary-header mb-3">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-bullseye text-warning fs-4"></i>
                            <div>
                                <h5 class="fw-bold text-dark mb-0">Tabel Target Kuota Diklat T.A. {{ $filterTahun }}</h5>
                                <small class="text-muted">Target kuota peserta pelatihan Balatkop Kalsel untuk Tahun Anggaran {{ $filterTahun }}</small>
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
                                <th>Nama Program Pelatihan / Diklat Target</th>
                                <th style="width: 150px;" class="text-center">Kategori SDM</th>
                                <th style="width: 180px;" class="text-center">Target Kuota Peserta</th>
                                <th>Status / Keterangan Alokasi</th>
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
                                        <span class="gis-badge {{ $tRow['jenis_sdm'] === 'sdm_koperasi' ? 'badge-blue-pill' : 'badge-green-pill' }}">
                                            {{ $tRow['jenis_sdm'] === 'sdm_koperasi' ? 'SDM KOP' : 'SDM UMKM' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="fw-bold text-warning fs-6">
                                            <i class="fa-solid fa-users me-1"></i>{{ number_format($tRow['target']) }} Orang
                                        </span>
                                    </td>
                                    <td class="small text-muted">
                                        Target Kuota APBD T.A. {{ $filterTahun }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        Belum ada data target kuota peserta diklat untuk Tahun {{ $filterTahun }}.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if ($targetList->count() > 0)
                            <tfoot>
                                <tr class="fw-bold bg-light">
                                    <td colspan="3" class="text-end text-dark pe-3">TOTAL TARGET KUOTA PESERTA T.A. {{ $filterTahun }}:</td>
                                    <td class="text-center text-warning fs-6">
                                        {{ number_format($targetList->sum('target')) }} Peserta
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- MAP CONTAINER & QUICK SELECTOR ROW -->
    <div class="gis-map-row mb-4">
        <!-- GIS LEAFLET MAP COL -->
        <div class="gis-map-col">
            <div class="gis-map-wrapper">
                <div class="gis-map-header">
                    <div class="gis-flex-center gap-2">
                        <i class="fa-solid fa-earth-asia text-primary"></i>
                        <span class="fw-bold text-dark">Peta Kalimantan Selatan</span>
                    </div>
                    <small class="text-muted"><i class="fa-solid fa-hand-pointer me-1"></i> Klik penanda lokasi pada
                        peta untuk rincian</small>
                </div>

                <!-- LEAFLET MAP ELEMENT -->
                <div id="gisMap" class="gis-map-container" wire:ignore></div>
            </div>
        </div>

        <!-- KALSEL REGION QUICK GRID SIDEBAR -->
        <div class="gis-sidebar-col">
            <div class="gis-region-sidebar">
                <div class="gis-sidebar-header">
                    <h5 class="fw-bold mb-1 text-dark"><i class="fa-solid fa-list-check text-primary"></i> 13 Kab/Kota
                        Prov. Kalsel</h5>
                    <p class="small text-muted mb-0">Pilih salah satu nama wilayah untuk melihat rincian</p>
                </div>

                <div class="gis-region-list">
                    @foreach ($mapData as $m)
                        <div class="gis-region-item {{ $selectedWilayahId == $m['id_wilayah'] ? 'active' : '' }}"
                            wire:click="selectWilayah({{ $m['id_wilayah'] }})">
                            <div class="gis-region-item-top mb-2">
                                <span class="gis-region-name">{{ $m['nama'] }}</span>
                            </div>
                            <div class="gis-region-stats-row">
                                <div class="stat-item">
                                    <i class="fa-solid fa-users text-primary"></i>
                                    <span><strong>{{ number_format($m['responden']) }}</strong> Responden</span>
                                </div>
                                <div class="stat-item">
                                    <i class="fa-solid fa-graduation-cap text-success"></i>
                                    <span><strong>{{ number_format($m['peserta']) }}</strong> Alumni</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- SELECTED REGION DETAILED BREAKDOWN SECTION -->
    <div id="regionDetailSection">
        @if ($selectedWilayah)
            <div class="gis-detail-card mb-4" wire:key="detail-{{ $selectedWilayah->id_wilayah }}">
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
                                <span class="gis-bps-text">&bull; Kode BPS:
                                    {{ $selectedWilayah->kode_bps ?: '-' }}</span>
                            </div>
                            <h3 class="gis-detail-title">{{ $selectedWilayah->nama }}</h3>
                        </div>
                    </div>
                    <button type="button" class="gis-btn-close"
                        wire:click="selectWilayah({{ $selectedWilayah->id_wilayah }})">
                        <i class="fa-solid fa-xmark"></i> Tutup Rincian
                    </button>
                </div>

                <!-- 2 COLUMNS GRID FOR SELECTED REGION: IDENTIFIKASI & REALISASI -->
                <div class="gis-detail-grid mb-4">
                    <!-- 1. Identifikasi Kebutuhan Pelatihan (IKP) -->
                    <div class="gis-detail-col">
                        <div class="gis-sub-box">
                            <div class="gis-sub-header text-primary mb-3">
                                <i class="fa-solid fa-clipboard-list text-primary"></i>
                                <h5 class="gis-sub-title text-primary">Identifikasi Kebutuhan Pelatihan (IKP)</h5>
                            </div>

                            @forelse ($selectedIdentifikasis as $sIdnt)
                                <div class="gis-item-card mb-3">
                                    <div class="gis-card-header-bar mb-3">
                                        <span
                                            class="gis-badge {{ $sIdnt->jenis_sdm === 'sdm_koperasi' ? 'badge-blue-pill' : 'badge-green-pill' }}">
                                            <i
                                                class="fa-solid {{ $sIdnt->jenis_sdm === 'sdm_koperasi' ? 'fa-building-columns' : 'fa-store' }}"></i>
                                            {{ $sIdnt->jenis_sdm === 'sdm_koperasi' ? 'SDM Koperasi' : 'SDM UMKM' }}
                                        </span>
                                        <span class="gis-badge badge-year-pill">
                                            Tahun {{ $sIdnt->tahun }}
                                        </span>
                                    </div>

                                    <div class="gis-program-block mt-2">
                                        <span class="gis-program-block-label mb-2"><i
                                                class="fa-solid fa-list-check text-primary"></i> Hasil Survei Kebutuhan
                                            Diklat:</span>
                                        <div class="gis-program-list">
                                            @foreach ($sIdnt->details as $dt)
                                                <div class="gis-program-item py-2 border-bottom">
                                                    <h6 class="gis-realisasi-program-title mb-1">
                                                        {{ $dt->jenisDiklat->nama ?? 'Diklat' }}
                                                    </h6>
                                                    <div>
                                                        <span class="text-primary fw-bold small">
                                                            <i class="fa-solid fa-users text-primary"></i>
                                                            {{ number_format($dt->jumlah_responden) }} Responden Usulan
                                                        </span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="gis-empty-box py-4">
                                    <i class="fa-solid fa-folder-open text-muted d-block mb-2"></i>
                                    Belum ada data identifikasi kebutuhan untuk {{ $selectedWilayah->nama }}.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- 2. REALISASI DIKLAT -->
                    <div class="gis-detail-col">
                        <div class="gis-sub-box">
                            <div class="gis-sub-header text-success mb-3">
                                <i class="fa-solid fa-award text-success"></i>
                                <h5 class="gis-sub-title text-success">Realisasi Pelaksanaan Diklat</h5>
                            </div>

                            @forelse ($selectedRealisasis as $sReal)
                                <div class="gis-item-card mb-3">
                                    <div class="gis-card-header-bar mb-3">
                                        <span
                                            class="gis-badge {{ ($sReal->jenisDiklat->jenis_sdm ?? '') === 'sdm_koperasi' ? 'badge-blue-pill' : 'badge-green-pill' }}">
                                            <i
                                                class="fa-solid {{ ($sReal->jenisDiklat->jenis_sdm ?? '') === 'sdm_koperasi' ? 'fa-building-columns' : 'fa-store' }}"></i>
                                            {{ ($sReal->jenisDiklat->jenis_sdm ?? '') === 'sdm_koperasi' ? 'SDM Koperasi' : 'SDM UMKM' }}
                                        </span>
                                        <span class="gis-badge badge-year-pill">
                                            Tahun {{ $sReal->tahun }}
                                        </span>
                                    </div>
                                    <h6 class="gis-realisasi-program-title">
                                        {{ $sReal->jenisDiklat->nama ?? 'Diklat' }}</h6>
                                    @if ($sReal->keterangan)
                                        <p class="gis-realisasi-location text-muted small mt-1 mb-2">
                                            {{ $sReal->keterangan }}
                                        </p>
                                    @endif

                                    <div class="mt-3">
                                        <span class="text-success fw-bold small">
                                            <i class="fa-solid fa-user-graduate text-success"></i>
                                            {{ number_format($sReal->jumlah_peserta) }} Alumni Terlatih
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="gis-empty-box py-4">
                                    <i class="fa-solid fa-calendar-xmark text-muted d-block mb-2"></i>
                                    Belum ada data realisasi pelatihan untuk {{ $selectedWilayah->nama }}.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- SUMMARY BALANCE MATRIX TABLE -->
                <div class="gis-summary-matrix-card border-top pt-4">
                    <div class="gis-summary-header mb-3">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-table text-primary fs-5"></i>
                                <div>
                                    <h5 class="fw-bold text-dark mb-0">Tabel Diklat</h5>
                                    <small class="text-muted">Kalkulasi data Kebutuhan Diklat Responden dengan
                                        Realisasi Alumni di {{ $selectedWilayah->nama }}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="gis-matrix-table">
                            <thead>
                                <tr>
                                    <th style="width: 50px;" class="text-center">No</th>
                                    <th>Nama Program Pelatihan / Diklat</th>
                                    <th style="width: 150px;" class="text-center">Kategori SDM</th>
                                    <th style="width: 160px;" class="text-center">Survei (IKP)</th>
                                    <th style="width: 160px;" class="text-center">Realisasi Alumni</th>
                                    <th style="width: 180px;" class="text-center">Tingkat Pemenuhan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($selectedSummaryTable as $idx => $row)
                                    <tr>
                                        <td class="text-center font-monospace fw-bold text-muted">{{ $idx + 1 }}
                                        </td>
                                        <td>
                                            <strong class="text-dark">{{ $row['nama_diklat'] }}</strong>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="gis-badge {{ $row['jenis_sdm'] === 'sdm_koperasi' ? 'badge-blue-pill' : 'badge-green-pill' }}">
                                                {{ $row['jenis_sdm'] === 'sdm_koperasi' ? 'SDM KOP' : 'SDM UMKM' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-bold text-primary">{{ number_format($row['responden']) }}
                                                Responden</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-bold text-success">{{ number_format($row['alumni']) }}
                                                Alumni</span>
                                        </td>
                                        <td class="text-center">
                                            @if ($row['persen'] >= 100)
                                                <span class="gis-status-pill pill-success"><i
                                                        class="fa-solid fa-circle-check text-success me-1"></i>
                                                    {{ $row['persen'] }}% Terpenuhi</span>
                                            @elseif ($row['persen'] > 0)
                                                <span class="gis-status-pill pill-info"><i
                                                        class="fa-solid fa-chart-line text-primary me-1"></i>
                                                    {{ $row['persen'] }}% Terpenuhi</span>
                                            @else
                                                <span class="gis-status-pill pill-muted"><i
                                                        class="fa-solid fa-clock text-muted me-1"></i> 0% Belum
                                                    Realisasi</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            Belum ada data kalkulasi untuk wilayah ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if ($selectedSummaryTable->count() > 0)
                                <tfoot>
                                    <tr class="fw-bold bg-light">
                                        <td colspan="3" class="text-end text-dark pe-3">TOTAL KESELURUHAN:</td>
                                        <td class="text-center text-primary fs-6">
                                            {{ number_format($selectedSummaryTable->sum('responden')) }} Responden</td>
                                        <td class="text-center text-success fs-6">
                                            {{ number_format($selectedSummaryTable->sum('alumni')) }} Alumni</td>
                                        <td class="text-center">
                                            @php
                                                $totResp = $selectedSummaryTable->sum('responden');
                                                $totAlum = $selectedSummaryTable->sum('alumni');
                                                $totPersen =
                                                    $totResp > 0
                                                        ? round(($totAlum / $totResp) * 100)
                                                        : ($totAlum > 0
                                                            ? 100
                                                            : 0);
                                            @endphp
                                            <span
                                                class="gis-status-pill {{ $totPersen >= 100 ? 'pill-success' : 'pill-info' }}">
                                                {{ $totPersen }}% Total Ratio
                                            </span>
                                        </td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>

            </div>
        @else
            <!-- OVERALL SUMMARY MATRIX TABLE WHEN NO REGION IS SELECTED -->
            <div class="gis-detail-card mb-4">
                <div class="gis-summary-matrix-card">
                    <div class="gis-summary-header mb-3">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-table text-primary fs-5"></i>
                                <div>
                                    <h5 class="fw-bold text-dark mb-0">Tabel Rekapitulasi Diklat (Keseluruhan
                                        Kalimantan Selatan)</h5>
                                    <small class="text-muted">Kalkulasi gabungan data Kebutuhan Diklat (IKP) Responden
                                        dengan Realisasi Alumni se-Provinsi Kalimantan Selatan</small>
                                </div>
                            </div>
                            <span class="gis-badge badge-blue-pill">
                                <i class="fa-solid fa-earth-asia me-1"></i> Data 13 Kab/Kota
                            </span>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="gis-matrix-table">
                            <thead>
                                <tr>
                                    <th style="width: 50px;" class="text-center">No</th>
                                    <th>Nama Program Pelatihan / Diklat</th>
                                    <th style="width: 150px;" class="text-center">Kategori SDM</th>
                                    <th style="width: 160px;" class="text-center">Kebutuhan (IKP)</th>
                                    <th style="width: 160px;" class="text-center">Realisasi Alumni</th>
                                    <th style="width: 180px;" class="text-center">Tingkat Pemenuhan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($overallSummaryTable as $idx => $row)
                                    <tr>
                                        <td class="text-center font-monospace fw-bold text-muted">{{ $idx + 1 }}
                                        </td>
                                        <td>
                                            <strong class="text-dark">{{ $row['nama_diklat'] }}</strong>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="gis-badge {{ $row['jenis_sdm'] === 'sdm_koperasi' ? 'badge-blue-pill' : 'badge-green-pill' }}">
                                                {{ $row['jenis_sdm'] === 'sdm_koperasi' ? 'SDM KOP' : 'SDM UMKM' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-bold text-primary">{{ number_format($row['responden']) }}
                                                Responden</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-bold text-success">{{ number_format($row['alumni']) }}
                                                Alumni</span>
                                        </td>
                                        <td class="text-center">
                                            @if ($row['persen'] >= 100)
                                                <span class="gis-status-pill pill-success"><i
                                                        class="fa-solid fa-circle-check text-success me-1"></i>
                                                    {{ $row['persen'] }}% Terpenuhi</span>
                                            @elseif ($row['persen'] > 0)
                                                <span class="gis-status-pill pill-info"><i
                                                        class="fa-solid fa-chart-line text-primary me-1"></i>
                                                    {{ $row['persen'] }}% Terpenuhi</span>
                                            @else
                                                <span class="gis-status-pill pill-muted"><i
                                                        class="fa-solid fa-clock text-muted me-1"></i> 0% Belum
                                                    Realisasi</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            Belum ada data kalkulasi keseluruhan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if ($overallSummaryTable->count() > 0)
                                <tfoot>
                                    <tr class="fw-bold bg-light">
                                        <td colspan="3" class="text-end text-dark pe-3">TOTAL KESELURUHAN:
                                        </td>
                                        <td class="text-center text-primary fs-6">
                                            {{ number_format($overallSummaryTable->sum('responden')) }} Responden</td>
                                        <td class="text-center text-success fs-6">
                                            {{ number_format($overallSummaryTable->sum('alumni')) }} Alumni</td>
                                        <td class="text-center">
                                            @php
                                                $totResp = $overallSummaryTable->sum('responden');
                                                $totAlum = $overallSummaryTable->sum('alumni');
                                                $totPersen =
                                                    $totResp > 0
                                                        ? round(($totAlum / $totResp) * 100)
                                                        : ($totAlum > 0
                                                            ? 100
                                                            : 0);
                                            @endphp
                                            <span
                                                class="gis-status-pill {{ $totPersen >= 100 ? 'pill-success' : 'pill-info' }}">
                                                {{ $totPersen }}% Total Ratio
                                            </span>
                                        </td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- TABEL KESIMPULAN PENYANDINGAN 3 DATA (IKP vs TARGET ANGGARAN vs REALISASI ALUMNI) DI PALING BAWAH HALAMAN -->
    @if ($filterTahun)
        <div class="gis-detail-card mb-4" wire:key="kesimpulan-table-bottom-{{ $filterTahun }}">
            <div class="gis-summary-matrix-card">
                <div class="gis-summary-header mb-3">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-chart-pie text-primary fs-4"></i>
                            <div>
                                <h5 class="fw-bold text-dark mb-0">Tabel Kesimpulan Matriks Evaluasi & Sanding Data Diklat T.A. {{ $filterTahun }}</h5>
                                <small class="text-muted">Penyandingan 3 Data Utama: Usulan Kebutuhan (IKP) vs Target Kuota Anggaran vs Realisasi Alumni Terlatih</small>
                            </div>
                        </div>
                        <span class="gis-badge badge-blue-pill">
                            <i class="fa-solid fa-layer-group me-1"></i> Matriks Monev T.A. {{ $filterTahun }}
                        </span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="gis-matrix-table">
                        <thead>
                            <tr>
                                <th style="width: 50px;" class="text-center">No</th>
                                <th>Nama Program Pelatihan / Diklat</th>
                                <th style="width: 140px;" class="text-center">Kategori SDM</th>
                                <th style="width: 150px;" class="text-center">Kebutuhan (IKP)</th>
                                <th style="width: 150px;" class="text-center">Target Anggaran</th>
                                <th style="width: 150px;" class="text-center">Realisasi Alumni</th>
                                <th style="width: 160px;" class="text-center">Capaian / Target</th>
                                <th style="width: 160px;" class="text-center">Pemenuhan IKP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($overallSummaryTable as $idx => $row)
                                <tr>
                                    <td class="text-center font-monospace fw-bold text-muted">{{ $idx + 1 }}</td>
                                    <td>
                                        <strong class="text-dark">{{ $row['nama_diklat'] }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <span class="gis-badge {{ $row['jenis_sdm'] === 'sdm_koperasi' ? 'badge-blue-pill' : 'badge-green-pill' }}">
                                            {{ $row['jenis_sdm'] === 'sdm_koperasi' ? 'SDM KOP' : 'SDM UMKM' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="fw-bold text-primary">{{ number_format($row['responden']) }} Responden</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="fw-bold text-warning">{{ number_format($row['target']) }} Target</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="fw-bold text-success">{{ number_format($row['alumni']) }} Alumni</span>
                                    </td>
                                    <td class="text-center">
                                        @if ($row['target'] > 0)
                                            @php $pctTrg = round(($row['alumni'] / $row['target']) * 100); @endphp
                                            <span class="gis-status-pill {{ $pctTrg >= 100 ? 'pill-success' : ($pctTrg > 0 ? 'pill-info' : 'pill-muted') }}">
                                                {{ $pctTrg }}% Target
                                            </span>
                                        @else
                                            <span class="gis-status-pill pill-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($row['responden'] > 0)
                                            @php $pctIkp = round(($row['alumni'] / $row['responden']) * 100); @endphp
                                            <span class="gis-status-pill {{ $pctIkp >= 100 ? 'pill-success' : ($pctIkp > 0 ? 'pill-info' : 'pill-muted') }}">
                                                {{ $pctIkp }}% IKP
                                            </span>
                                        @else
                                            <span class="gis-status-pill pill-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        Belum ada data kesimpulan matriks untuk Tahun {{ $filterTahun }}.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if ($overallSummaryTable->count() > 0)
                            <tfoot>
                                <tr class="fw-bold bg-light">
                                    <td colspan="3" class="text-end text-dark pe-3">TOTAL KESELURUHAN T.A. {{ $filterTahun }}:</td>
                                    <td class="text-center text-primary fs-6">
                                        {{ number_format($overallSummaryTable->sum('responden')) }} Responden
                                    </td>
                                    <td class="text-center text-warning fs-6">
                                        {{ number_format($overallSummaryTable->sum('target')) }} Target
                                    </td>
                                    <td class="text-center text-success fs-6">
                                        {{ number_format($overallSummaryTable->sum('alumni')) }} Alumni
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $totTrg = $overallSummaryTable->sum('target');
                                            $totAlm = $overallSummaryTable->sum('alumni');
                                            $totPctTrg = $totTrg > 0 ? round(($totAlm / $totTrg) * 100) : 0;
                                        @endphp
                                        <span class="gis-status-pill {{ $totPctTrg >= 100 ? 'pill-success' : 'pill-info' }}">
                                            {{ $totPctTrg }}% Target Ratio
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $totResp = $overallSummaryTable->sum('responden');
                                            $totPctIkp = $totResp > 0 ? round(($totAlm / $totResp) * 100) : 0;
                                        @endphp
                                        <span class="gis-status-pill {{ $totPctIkp >= 100 ? 'pill-success' : 'pill-info' }}">
                                            {{ $totPctIkp }}% IKP Ratio
                                        </span>
                                    </td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- EMBED SCRIPT TO PASS DATA TO LEAFLET JS -->
    <script>
        document.addEventListener('livewire:initialized', () => {
            const mapData = @json($mapData);
            if (window.initGisMap) {
                window.initGisMap(mapData, @this);
            }
        });

        document.addEventListener('livewire:navigated', () => {
            const mapData = @json($mapData);
            if (window.initGisMap) {
                window.initGisMap(mapData, @this);
            }
        });
    </script>
</div>
