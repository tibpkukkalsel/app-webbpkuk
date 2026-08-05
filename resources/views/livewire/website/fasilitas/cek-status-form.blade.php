<div id="cek-status-top">

    <!-- HERO HEADER -->
    <div class="catalog-hero-header mb-4">
        <div class="catalog-hero-left">
            <div class="catalog-hero-icon-box"
                style="background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); color: #0284c7;">
                <i class="fa-solid fa-magnifying-glass-location"></i>
            </div>
            <div>
                <span class="catalog-hero-subtitle" style="color: #0284c7;">Lacak Real-Time</span>
                <h2 class="catalog-hero-title">Cek Status Pemesanan Fasilitas</h2>
            </div>
        </div>
    </div>

    <!-- SEARCH FORM CARD (Hidden when search results are found) -->
    @if (!($searchExecuted && $foundPemesanId && $foundPemesan))
        <div class="booking-form-card mb-4">
            <form wire:submit.prevent="cariStatus">
                <!-- HONEYPOT HIDDEN FIELD FOR BOT PROTECTION -->
                <div style="display:none !important; opacity:0; position:absolute; left:-9999px;" aria-hidden="true">
                    <input type="text" wire:model="fax_hp" tabindex="-1" autocomplete="off" placeholder="Leave empty">
                </div>

                <h3 class="form-section-title mb-2">
                    Verifikasi Pemesanan Anda
                </h3>
                <p class="form-section-desc mb-3">
                    Masukkan <strong>Nomor Booking</strong> resmi dan salah satu data verifikasi —
                    <strong>NIK KTP</strong>, <strong>Nomor WhatsApp</strong>, atau <strong>Email</strong>
                    yang Anda daftarkan saat pemesanan.
                </p>

                <div class="form-grid-2col">
                    <div class="form-item-group">
                        <label class="form-item-label">Nomor Booking Resmi <span class="text-red">*</span></label>
                        <input type="text" class="form-item-input @error('nomor_booking') is-invalid @enderror"
                            placeholder="Contoh: BK-20260801-0001" wire:model="nomor_booking"
                            style="font-family: 'Courier New', monospace; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase;">
                        @error('nomor_booking')
                            <span class="form-error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-item-group">
                        <label class="form-item-label">NIK KTP / Nomor WA / Email <span class="text-red">*</span></label>
                        <input type="text" class="form-item-input @error('verifikasi') is-invalid @enderror"
                            placeholder="Masukkan salah satu sebagai verifikasi" wire:model="verifikasi">
                        @error('verifikasi')
                            <span class="form-error-msg">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3 mt-4">
                    <button type="submit" class="btn-pesan-primary" wire:loading.attr="disabled">
                        <span wire:loading.remove><i class="fa-solid fa-magnifying-glass me-2"></i> Cari</span>
                        <span wire:loading><i class="fa-solid fa-spinner fa-spin me-2"></i> Memeriksa Data...</span>
                    </button>
                    @if ($searchExecuted)
                        <button type="button" class="btn-pesan-secondary" wire:click="resetCari">
                            <i class="fa-solid fa-rotate-left me-2"></i> Cari Lagi
                        </button>
                    @endif
                </div>
            </form>
        </div>
    @endif

    {{-- NOT FOUND --}}
    @if ($searchExecuted && $errorMessage)
        <div class="status-not-found-alert">
            <div class="status-not-found-icon">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-1" style="color: #b91c1c;">Data Pemesanan Tidak Ditemukan</h5>
                <p class="mb-0 text-muted" style="font-size: 0.88rem;">{{ $errorMessage }}</p>
            </div>
        </div>
    @endif

    {{-- RESULT INLINE --}}
    @if ($searchExecuted && $foundPemesanId && $foundPemesan)
        @php
            $stBg = '#fef3c7';
            $stColor = '#d97706';
            $stBorder = '#fde68a';
            $stIcon = 'fa-clock';
            $stTitle = 'Menunggu Konfirmasi Admin';

            $statusLower = strtolower($foundPemesan->status);

            if (in_array($statusLower, ['disetujui', 'diterima', 'approved'])) {
                $stBg = '#dcfce7';
                $stColor = '#15803d';
                $stBorder = '#86efac';
                $stIcon = 'fa-circle-check';
                $stTitle = 'Pengajuan Disetujui';
            } elseif (in_array($statusLower, ['ditolak', 'rejected'])) {
                $stBg = '#fee2e2';
                $stColor = '#b91c1c';
                $stBorder = '#fca5a5';
                $stIcon = 'fa-circle-xmark';
                $stTitle = 'Pengajuan Ditolak';
            } elseif ($statusLower === 'selesai') {
                $stBg = '#dbeafe';
                $stColor = '#1d4ed8';
                $stBorder = '#93c5fd';
                $stIcon = 'fa-flag-checkered';
                $stTitle = 'Pemesanan Selesai';
            }

            $step2Done = !in_array($statusLower, ['menunggu konfirmasi', 'menunggu']);
            $step3Done = in_array($statusLower, ['disetujui', 'diterima', 'approved', 'selesai']);
            $step3Rej = in_array($statusLower, ['ditolak', 'rejected']);
        @endphp

        <br>
        {{-- STATUS BADGE --}}
        <div class="csr-status-banner mt-2 mb-4"
            style="background: {{ $stBg }}; border: 1.5px solid {{ $stBorder }};">
            <div class="csr-status-icon" style="color: {{ $stColor }};">
                <i class="fa-solid {{ $stIcon }}"></i>
            </div>
            <div class="csr-status-text">
                <span class="csr-status-label" style="color: {{ $stColor }};">{{ $stTitle }}</span>
                <span class="csr-booking-number">{{ $foundPemesan->nomor_booking }}</span>
            </div>
            <div class="csr-status-date">
                Diajukan: {{ \Carbon\Carbon::parse($foundPemesan->created_at)->format('d/m/Y H:i') }} WITA
            </div>
        </div>

        <br>

        {{-- STEP TRACKER --}}
        <div class="csr-tracker-wrap mb-5">
            {{-- Step 1 --}}
            <div class="csr-step done">
                <div class="csr-dot"><i class="fa-solid fa-check"></i></div>
                <span class="csr-step-label">Pengajuan Dikirim</span>
            </div>
            <div class="csr-line {{ $step2Done ? 'done' : '' }}"></div>
            {{-- Step 2 --}}
            <div class="csr-step {{ $step2Done ? 'done' : 'pending' }}">
                <div class="csr-dot">
                    <i class="fa-solid {{ $step2Done ? 'fa-check' : 'fa-hourglass-half' }}"></i>
                </div>
                <span class="csr-step-label">Verifikasi Admin</span>
            </div>
            <div class="csr-line {{ $step3Done || $step3Rej ? 'done' : '' }}"></div>
            {{-- Step 3 --}}
            <div class="csr-step {{ $step3Done ? 'done' : ($step3Rej ? 'rejected' : '') }}">
                <div class="csr-dot">
                    <i
                        class="fa-solid {{ $step3Done ? 'fa-circle-check' : ($step3Rej ? 'fa-circle-xmark' : 'fa-minus') }}"></i>
                </div>
                <span class="csr-step-label">Keputusan Akhir</span>
            </div>
        </div>

        {{-- CATATAN ADMIN (tampil untuk semua status) --}}
        @if ($foundPemesan->catatan)
            @php
                if ($step3Rej) {
                    $noteBg = '#fef2f2';
                    $noteBorder = '#fca5a5';
                    $noteAccent = '#dc2626';
                    $noteIcon = 'fa-circle-xmark';
                    $noteLabel = 'Alasan Penolakan';
                } elseif ($step3Done) {
                    $noteBg = '#f0fdf4';
                    $noteBorder = '#86efac';
                    $noteAccent = '#16a34a';
                    $noteIcon = 'fa-circle-check';
                    $noteLabel = 'Catatan Persetujuan';
                } elseif ($statusLower === 'selesai') {
                    $noteBg = '#eff6ff';
                    $noteBorder = '#93c5fd';
                    $noteAccent = '#1d4ed8';
                    $noteIcon = 'fa-flag-checkered';
                    $noteLabel = 'Catatan Penyelesaian';
                } else {
                    $noteBg = '#fffbeb';
                    $noteBorder = '#fde68a';
                    $noteAccent = '#d97706';
                    $noteIcon = 'fa-comment-dots';
                    $noteLabel = 'Catatan Admin';
                }
            @endphp
            <br>
            <div class="csr-catatan-box mb-5"
                style="background: {{ $noteBg }}; border-left: 4px solid {{ $noteAccent }}; border: 1px solid {{ $noteBorder }}; border-left: 4px solid {{ $noteAccent }};">
                <div class="csr-catatan-body">
                    <span class="csr-catatan-label" style="color: {{ $noteAccent }};">{{ $noteLabel }}</span>
                    <p class="csr-catatan-text">{{ $foundPemesan->catatan }}</p>
                </div>
            </div>
        @endif

        <br>

        {{-- DATA PEMOHON --}}
        <div class="csr-section-label mb-3">
            <i class="fa-solid fa-user me-2"></i> Rincian Data Pemohon
        </div>


        <div class="csr-data-grid mb-5">
            <div class="csr-data-item">
                <span class="srm-data-label">Nama Pemohon</span>
                <span class="srm-data-value fw-bold">{{ $foundPemesan->nama_pemohon }}</span>
            </div>
            <div class="csr-data-item">
                <span class="srm-data-label">Instansi / Organisasi</span>
                <span class="srm-data-value">{{ $foundPemesan->instansi ?: '-' }}</span>
            </div>
            <div class="csr-data-item">
                <span class="srm-data-label">Jadwal Pemakaian</span>
                <span class="srm-data-value fw-bold">
                    {{ \Carbon\Carbon::parse($foundPemesan->tanggal_mulai)->format('d/m/Y') }}
                    &mdash;
                    {{ \Carbon\Carbon::parse($foundPemesan->tanggal_selesai)->format('d/m/Y') }}
                </span>
            </div>
            <div class="csr-data-item">
                <span class="srm-data-label">Jam Kegiatan</span>
                <span class="srm-data-value">{{ $foundPemesan->jam_mulai }} s.d {{ $foundPemesan->jam_selesai }}
                    WITA</span>
            </div>
            <div class="csr-data-item" style="grid-column: 1 / -1;">
                <span class="srm-data-label">Keperluan / Tujuan</span>
                <span class="srm-data-value">{{ $foundPemesan->keperluan }}</span>
            </div>
        </div>

        <br>

        {{-- FASILITAS TABLE --}}
        <div class="csr-section-label mb-3">
            <i class="fa-solid fa-building me-2"></i> Fasilitas yang Dipesan
        </div>


        <div class="summary-table-wrap mb-5">
            <table class="summary-item-table">
                <thead>
                    <tr>
                        <th style="text-align: center !important;">Nama Fasilitas</th>
                        <th style="text-align: center !important;">Jumlah Unit</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($foundPemesan->details as $dt)
                        <tr>
                            <td style="text-align: center !important;"><strong>{{ $dt->fasilitas ? $dt->fasilitas->nama : 'Fasilitas' }}</strong></td>
                            <td style="text-align: center !important;">{{ $dt->jumlah }} Unit</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" style="text-align: center !important;" class="text-muted py-3">
                                <i class="fa-solid fa-inbox me-2"></i> Tidak ada detail fasilitas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="d-flex gap-3 flex-wrap pt-2">
            <button type="button" class="btn-pesan-secondary" wire:click="resetCari"
                onclick="setTimeout(()=>document.getElementById('cek-status-top').scrollIntoView({behavior:'smooth',block:'start'}),150)">
                <i class="fa-solid fa-arrow-left me-2"></i> Kembali
            </button>
        </div>

    @endif

</div>
