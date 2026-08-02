<div id="pesan-form-top">
    <!-- HERO HEADER CARD FOR BOOKING FORM -->
    <div class="catalog-hero-header mb-4">
        <div class="catalog-hero-left">
            <div class="catalog-hero-icon-box"
                style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #d97706;">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div>
                <span class="catalog-hero-subtitle" style="color: #d97706;">Pesan Online Resmi</span>
                <h2 class="catalog-hero-title">Formulir Pemesanan Gedung & Ruang</h2>
            </div>
        </div>
    </div>

    <!-- HONEYPOT HIDDEN FIELD FOR BOT PROTECTION -->
    <div style="display:none !important; opacity:0; position:absolute; left:-9999px;" aria-hidden="true">
        <input type="text" wire:model="fax_hp" tabindex="-1" autocomplete="off" placeholder="Leave empty">
    </div>

    @if ($bookingBerhasil)
        <!-- SUCCESS BOOKING RESULT SCREEN -->
        <div class="booking-success-card text-center">
            <div class="success-icon-badge">
                <i class="fa-solid fa-check"></i>
            </div>

            <h2 class="success-title text-center my-3">Pengajuan Pemesanan Berhasil Dikirim!</h2>
            <p class="success-desc text-center mx-auto mb-4">
                Terima kasih, <strong>{{ $createdPemesan->nama_pemohon }}</strong>. Pengajuan sewa fasilitas Anda telah
                masuk ke sistem kami dan sedang menunggu verifikasi admin.
            </p>

            <div class="text-center my-4">
                <span class="badge-status-pending">
                    <i class="fa-solid fa-hourglass-half me-1"></i> Status: Menunggu Verifikasi Admin
                </span>
            </div>

            <!-- DIGITAL TICKET CARD -->
            <div class="booking-ticket-box">
                <div class="ticket-label">NOMOR BOOKING RESMI UNIK</div>
                <div class="ticket-number">{{ $createdNomorBooking }}</div>
                <p class="ticket-note">
                    <i class="fa-solid fa-circle-info text-blue me-1"></i> Simpan atau screenshot nomor booking ini
                    untuk pelacakan status sewa Anda.
                </p>
            </div>

            <!-- RECEIPT SUMMARY TABLE CARD -->
            <div class="receipt-summary-card">
                <div class="receipt-summary-title">
                    <span><i class="fa-solid fa-receipt text-blue me-2"></i> Rincian Bukti Pengajuan</span>
                    <span
                        class="badge bg-success bg-opacity-10 text-success fs-7 px-3 py-1 rounded-pill">Terkirim</span>
                </div>
                <table class="receipt-table w-100">
                    <tr>
                        <td>Nama Pemohon</td>
                        <td>: <strong>{{ $createdPemesan->nama_pemohon }}</strong></td>
                    </tr>
                    <tr>
                        <td>Instansi / Organisasi</td>
                        <td>: {{ $createdPemesan->instansi ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td>NIK KTP</td>
                        <td>: {{ $createdPemesan->nik }}</td>
                    </tr>
                    <tr>
                        <td>Kontak (Email / No. HP)</td>
                        <td>: {{ $createdPemesan->email }} / {{ $createdPemesan->no_hp }}</td>
                    </tr>
                    <tr>
                        <td>Jadwal Pemakaian</td>
                        <td>: <strong>{{ \Carbon\Carbon::parse($createdPemesan->tanggal_mulai)->format('d/m/Y') }} s.d
                                {{ \Carbon\Carbon::parse($createdPemesan->tanggal_selesai)->format('d/m/Y') }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>Jam Kegiatan</td>
                        <td>: {{ $createdPemesan->jam_mulai ?: '08:00' }} s.d
                            {{ $createdPemesan->jam_selesai ?: '16:00' }} WITA</td>
                    </tr>
                    <tr>
                        <td>Tujuan Pemakaian</td>
                        <td>: {{ $createdPemesan->keperluan }}</td>
                    </tr>
                    <tr class="border-top">
                        <td class="pt-3">Total Estimasi Biaya</td>
                        <td class="pt-3">: <strong class="text-green fs-5">Rp
                                {{ number_format($this->totalBiaya, 0, ',', '.') }}</strong></td>
                    </tr>
                </table>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="d-flex justify-content-center flex-wrap gap-3 mt-4">
                <a href="{{ url('/layanan/pemanfaatan-fasilitas') }}" class="btn-pesan-primary">
                    <i class="fa-solid fa-building me-2"></i> Kembali ke Katalog Fasilitas
                </a>
            </div>
        </div>
    @else
        <!-- MULTI-STEP WIZARD INDICATOR -->
        <div class="booking-wizard-steps mb-4">
            <div class="wizard-step-item {{ $currentStep == 1 ? 'active' : ($currentStep > 1 ? 'completed' : '') }}">
                <div class="step-icon">
                    @if ($currentStep > 1)
                        <i class="fa-solid fa-check"></i>
                    @else
                        1
                    @endif
                </div>
                <div class="step-label">
                    <span class="step-num">Langkah 1</span>
                    <span class="step-title">Identitas Pemohon</span>
                </div>
            </div>

            <div class="wizard-step-line {{ $currentStep > 1 ? 'completed' : '' }}"></div>

            <div class="wizard-step-item {{ $currentStep == 2 ? 'active' : ($currentStep > 2 ? 'completed' : '') }}">
                <div class="step-icon">
                    @if ($currentStep > 2)
                        <i class="fa-solid fa-check"></i>
                    @else
                        2
                    @endif
                </div>
                <div class="step-label">
                    <span class="step-num">Langkah 2</span>
                    <span class="step-title">Jadwal & Fasilitas</span>
                </div>
            </div>

            <div class="wizard-step-line {{ $currentStep > 2 ? 'completed' : '' }}"></div>

            <div class="wizard-step-item {{ $currentStep == 3 ? 'active' : '' }}">
                <div class="step-icon">3</div>
                <div class="step-label">
                    <span class="step-num">Langkah 3</span>
                    <span class="step-title">Konfirmasi & Kirim</span>
                </div>
            </div>
        </div>

        <!-- FORM CONTENT -->
        <div class="booking-form-card">

            <!-- STEP 1: IDENTITAS PEMOHON -->
            @if ($currentStep == 1)
                <div class="form-step-content">
                    <h3 class="form-section-title">
                        <i class="fa-solid fa-id-card text-blue me-2"></i> Data Identitas Pemohon & Instansi
                    </h3>
                    <p class="form-section-desc">Masukkan informasi identitas diri dan instansi yang bertanggung jawab
                        atas pemesanan fasilitas.</p>

                    <div class="form-grid-2col">
                        <!-- ROW 1 -->
                        <div class="form-item-group">
                            <label class="form-item-label">Nama Lengkap Pemohon <span class="text-red">*</span></label>
                            <input type="text" class="form-item-input @error('nama_pemohon') is-invalid @enderror"
                                placeholder="Contoh: H. Ahmad Ridwan, S.STP" wire:model="nama_pemohon">
                            @error('nama_pemohon')
                                <span class="form-error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-item-group">
                            <label class="form-item-label">Nomor Induk Kependudukan (NIK) <span
                                    class="text-red">*</span></label>
                            <input type="text" inputmode="numeric" maxlength="16"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                class="form-item-input @error('nik') is-invalid @enderror"
                                placeholder="16 Digit NIK KTP Anda" wire:model.live="nik">
                            @error('nik')
                                <span class="form-error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- ROW 2 -->
                        <div class="form-item-group">
                            <label class="form-item-label">Instansi / Organisasi / Pribadi <span
                                    class="text-red">*</span></label>
                            <input type="text" class="form-item-input @error('instansi') is-invalid @enderror"
                                placeholder="Contoh: Dinas Koperasi Kalsel / Nama Organisasi / Pribadi"
                                wire:model="instansi">
                            @error('instansi')
                                <span class="form-error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-item-group">
                            <label class="form-item-label">Email Aktif <span class="text-red">*</span></label>
                            <input type="email" class="form-item-input @error('email') is-invalid @enderror"
                                placeholder="pemohon@gmail.com" wire:model="email">
                            @error('email')
                                <span class="form-error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- ROW 3 -->
                        <div class="form-item-group">
                            <label class="form-item-label">Nomor HP / WhatsApp <span class="text-red">*</span></label>
                            <input type="text" inputmode="numeric" maxlength="15"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                class="form-item-input @error('no_hp') is-invalid @enderror"
                                placeholder="081234567890" wire:model.live="no_hp">
                            @error('no_hp')
                                <span class="form-error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-item-group">
                            <label class="form-item-label">Upload Foto KTP Pemohon <span
                                    class="text-red">*</span></label>
                            <input type="file" class="form-item-input @error('foto_ktp') is-invalid @enderror"
                                accept="image/png,image/jpeg,image/jpg,image/webp" wire:model="foto_ktp">
                            @error('foto_ktp')
                                <span class="form-error-msg">{{ $message }}</span>
                            @enderror
                            <div wire:loading wire:target="foto_ktp" class="text-blue mt-1">
                                <small><i class="fa-solid fa-spinner fa-spin me-1"></i> Mengunggah foto KTP...</small>
                            </div>

                            @if ($foto_ktp)
                                <div class="ktp-preview-box mt-2">
                                    <img src="{{ $foto_ktp->temporaryUrl() }}" alt="Preview KTP"
                                        class="ktp-img-preview">
                                    <span class="ktp-preview-tag"><i class="fa-solid fa-check me-1"></i> Foto KTP
                                        Siap</span>
                                </div>
                            @endif
                        </div>

                        <!-- ROW 4 -->
                        <div class="form-item-group">
                            <label class="form-item-label">Alamat Lengkap Pemohon / Instansi <span
                                    class="text-red">*</span></label>
                            <textarea rows="2" class="form-item-input @error('alamat') is-invalid @enderror"
                                placeholder="Alamat domisili atau alamat resmi instansi..." wire:model="alamat"></textarea>
                            @error('alamat')
                                <span class="form-error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-item-group">
                            <label class="form-item-label">Keperluan / Tujuan Pemanfaatan <span
                                    class="text-red">*</span></label>
                            <textarea rows="2" class="form-item-input @error('keperluan') is-invalid @enderror"
                                placeholder="Jelaskan jenis kegiatan/acara yang akan dilaksanakan..." wire:model="keperluan"></textarea>
                            @error('keperluan')
                                <span class="form-error-msg">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-action-footer mt-4">
                        <button type="button" class="btn-pesan-primary ms-auto" wire:click="nextStep">
                            Lanjut ke Jadwal & Fasilitas &nbsp; <i class="fa-solid fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>
            @endif

            <!-- STEP 2: JADWAL & MULTI-ITEM FASILITAS -->
            @if ($currentStep == 2)
                <div class="form-step-content">
                    <h3 class="form-section-title">
                        <i class="fa-solid fa-calendar-days text-blue me-2"></i> Jadwal & Pilihan Gedung/Ruangan
                    </h3>
                    <p class="form-section-desc">Tentukan waktu pemakaian dan pilih satu atau lebih fasilitas yang
                        ingin dipesan.</p>

                    <!-- JADWAL WAKTU (GRID 2-KOLOM SAMA SEPERTI STEP 1) -->
                    <div class="form-grid-2col">
                        <!-- ROW 1: TANGGAL -->
                        <div class="form-item-group">
                            <label class="form-item-label">Tanggal Mulai <span class="text-red">*</span></label>
                            <input type="date" min="{{ date('Y-m-d') }}"
                                class="form-item-input @error('tanggal_mulai') is-invalid @enderror"
                                wire:model.live="tanggal_mulai">
                            @error('tanggal_mulai')
                                <span class="form-error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-item-group">
                            <label class="form-item-label">Tanggal Selesai <span class="text-red">*</span></label>
                            <input type="date" min="{{ $tanggal_mulai }}"
                                class="form-item-input @error('tanggal_selesai') is-invalid @enderror"
                                wire:model.live="tanggal_selesai">
                            @error('tanggal_selesai')
                                <span class="form-error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- ROW 2: JAM -->
                        <div class="form-item-group">
                            <label class="form-item-label">Jam Mulai <span class="text-red">*</span></label>
                            <input type="time" class="form-item-input @error('jam_mulai') is-invalid @enderror"
                                wire:model="jam_mulai">
                            @error('jam_mulai')
                                <span class="form-error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-item-group">
                            <label class="form-item-label">Jam Selesai <span class="text-red">*</span></label>
                            <input type="time" class="form-item-input @error('jam_selesai') is-invalid @enderror"
                                wire:model="jam_selesai">
                            @error('jam_selesai')
                                <span class="form-error-msg">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- MULTI ITEM FASILITAS SELECTION -->
                    <div class="d-flex justify-content-between align-items-center mt-5 mb-4 pt-3 flex-wrap gap-3">
                        <h4 class="form-subsection-title mb-0">
                            <i class="fa-solid fa-boxes-stacked text-amber me-2"></i> Daftar Fasilitas yang Dipesan
                        </h4>
                        <br>
                        <button type="button" class="btn-add-item-custom ms-auto" wire:click="tambahItem">
                            <i class="fa-solid fa-plus me-1"></i> Tambah Fasilitas Lain
                        </button>
                    </div>

                    <br>
                    <div class="selected-items-wrapper">
                        @foreach ($selectedItems as $index => $item)
                            <div class="selected-item-card mb-4" wire:key="item-row-{{ $index }}">
                                <!-- ITEM HEADER WITH DEDICATED RIGHT TRASH BUTTON -->
                                <div
                                    class="selected-item-header d-flex justify-content-between align-items-center mb-3">
                                    <span class="selected-item-number"><i
                                            class="fa-solid fa-building text-blue me-2"></i> Fasilitas
                                        #{{ $index + 1 }}</span>
                                    @if (count($selectedItems) > 1)
                                        <button type="button" class="btn-remove-item ms-auto"
                                            wire:click="hapusItem({{ $index }})" title="Hapus Fasilitas">
                                            <i class="fa-solid fa-trash-can me-1"></i>
                                        </button>
                                    @endif
                                </div>

                                <!-- INPUT FIELDS GRID -->
                                <div class="row g-4">
                                    <!-- SELECT FASILITAS -->
                                    <div class="col-lg-6 col-12">
                                        <div class="form-item-group mb-3">
                                            <label class="form-item-label">Pilih Gedung / Sarana <span
                                                    class="text-red">*</span></label>
                                            <select class="form-item-input"
                                                wire:model.live="selectedItems.{{ $index }}.id_fasilitas">
                                                @foreach ($fasilitasAll as $fas)
                                                    <option value="{{ $fas->id_fasilitas }}">
                                                        {{ $fas->nama }} (Kapasitas: {{ $fas->kapasitas ?? '-' }}
                                                        orang)
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- JUMLAH UNIT & ESTIMASI TARIF -->
                                    <div class="col-lg-6 col-12">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <div class="form-item-group mb-3">
                                                    <label class="form-item-label text-center d-block">Jumlah
                                                        Unit</label>
                                                    <input type="number" min="1"
                                                        class="form-item-input text-center"
                                                        wire:model.live="selectedItems.{{ $index }}.jumlah">
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-item-group mb-3">
                                                    <label class="form-item-label">Estimasi Tarif per Unit</label>
                                                    <div class="subtotal-val-box">
                                                        <span class="subtotal-val">
                                                            Rp {{ number_format($item['tarif'] ?? 0, 0, ',', '.') }}
                                                            <small class="text-muted">/
                                                                {{ $item['satuan'] ?? 'hari' }}</small>
                                                        </span>
                                                        <span class="subtotal-calc">
                                                            Subtotal: <strong>Rp
                                                                {{ number_format(($item['jumlah'] ?? 1) * ($item['tarif'] ?? 0), 0, ',', '.') }}</strong>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- TOTAL ESTIMATED PRICE BANNER -->
                    <div class="total-estimate-card my-5">
                        <div>
                            <span class="estimate-label"><i class="fa-solid fa-calculator me-1"></i> Total Estimasi
                                Biaya Sewa</span>
                            <div class="estimate-note">Sesuai Peraturan Daerah (Perda) / Peraturan Gubernur Kalsel
                            </div>
                        </div>
                        <div class="estimate-value">
                            Rp {{ number_format($this->totalBiaya, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="form-action-footer mt-5 pt-4">
                        <button type="button" class="btn-pesan-secondary" wire:click="prevStep">
                            <i class="fa-solid fa-arrow-left me-2"></i> Kembali
                        </button>
                        <button type="button" class="btn-pesan-primary ms-auto" wire:click="nextStep">
                            Lanjut ke Konfirmasi &nbsp; <i class="fa-solid fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>
            @endif

            <!-- STEP 3: KONFIRMASI & KIRIM -->
            @if ($currentStep == 3)
                <div class="form-step-content">
                    <h3 class="form-section-title">
                        <i class="fa-solid fa-file-check text-blue me-2"></i> Konfirmasi Pengajuan Pemesanan
                    </h3>
                    <p class="form-section-desc">Mohon periksa kembali rincian pemesanan Anda sebelum mengirimkan
                        pengajuan sewa.</p>

                    <!-- SUMMARY GRID -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="summary-box">
                                <h4 class="summary-box-title"><i class="fa-solid fa-user me-2"></i> Data Pemohon</h4>
                                <table class="summary-table">
                                    <tr>
                                        <td>Nama Pemohon</td>
                                        <td>: <strong>{{ $nama_pemohon }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>NIK KTP</td>
                                        <td>: {{ $nik }}</td>
                                    </tr>
                                    <tr>
                                        <td>Instansi / Organisasi</td>
                                        <td>: {{ $instansi }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email / WhatsApp</td>
                                        <td>: {{ $email }} / {{ $no_hp }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tujuan Pemakaian</td>
                                        <td>: {{ $keperluan }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="summary-box">
                                <h4 class="summary-box-title"><i class="fa-solid fa-clock me-2"></i> Jadwal Pemakaian
                                </h4>
                                <table class="summary-table">
                                    <tr>
                                        <td>Tanggal Mulai</td>
                                        <td>:
                                            <strong>{{ \Carbon\Carbon::parse($tanggal_mulai)->format('d/m/Y') }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Selesai</td>
                                        <td>:
                                            <strong>{{ \Carbon\Carbon::parse($tanggal_selesai)->format('d/m/Y') }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jam Kegiatan</td>
                                        <td>: {{ $jam_mulai }} s.d {{ $jam_selesai }} WITA</td>
                                    </tr>
                                    <tr>
                                        <td>Total Fasilitas Dipesan</td>
                                        <td>: <strong>{{ count($selectedItems) }} Gedung / Ruang</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- SUMMARY ITEM LIST TABLE -->
                    <h4 class="form-subsection-title mt-6 mb-3 pt-3"><i
                            class="fa-solid fa-receipt text-blue me-2"></i> Rincian Fasilitas & Tarif Sewa</h4>
                    <div class="summary-table-wrap summary-section-spacer">
                        <table class="summary-item-table">
                            <thead>
                                <tr>
                                    <th>Fasilitas / Gedung</th>
                                    <th class="text-center">Jumlah Unit</th>
                                    <th class="text-end">Tarif per Unit</th>
                                    <th class="text-end">Subtotal Biaya</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($selectedItems as $st)
                                    @php
                                        $fObj = \App\Models\Fasilitas::find($st['id_fasilitas']);
                                        $sub = ($st['jumlah'] ?? 1) * ($st['tarif'] ?? 0);
                                    @endphp
                                    <tr>
                                        <td>
                                            <strong>{{ $fObj ? $fObj->nama : 'Fasilitas' }}</strong>
                                            @if ($fObj && $fObj->kapasitas)
                                                <small class="d-block text-muted">Kapasitas: {{ $fObj->kapasitas }}
                                                    Orang</small>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $st['jumlah'] ?? 1 }} Unit</td>
                                        <td class="text-end">Rp {{ number_format($st['tarif'] ?? 0, 0, ',', '.') }} /
                                            {{ $st['satuan'] ?? 'hari' }}</td>
                                        <td class="text-end font-bold text-green">Rp
                                            {{ number_format($sub, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">TOTAL ESTIMASI BIAYA SEWA:</th>
                                    <th class="text-end text-green font-bold fs-5">Rp
                                        {{ number_format($this->totalBiaya, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="form-action-footer mt-6 pt-4">
                        <button type="button" class="btn-pesan-secondary" wire:click="prevStep">
                            <i class="fa-solid fa-arrow-left me-2"></i> Kembali Edit
                        </button>
                        <button type="button" class="btn-pesan-submit ms-auto" wire:click="bukaModalKonfirmasi"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove><i class="fa-solid fa-paper-plane me-2"></i> Kirim Pengajuan
                                Pemesanan</span>
                            <span wire:loading><i class="fa-solid fa-spinner fa-spin me-2"></i> Memproses...</span>
                        </button>
                    </div>
                </div>
            @endif

        </div>
    @endif

    <!-- MODAL KONFIRMASI PENGIRIMAN ("Kirim Pengajuan Pemesanan?") -->
    @if ($showConfirmModal)
        <div class="custom-modal-overlay" wire:click.self="tutupModalKonfirmasi">
            <div class="custom-modal-card">
                <div class="confirm-modal-icon">
                    <i class="fa-solid fa-paper-plane"></i>
                </div>

                <h3 class="confirm-modal-title">Kirim Pengajuan Pemesanan?</h3>

                <p class="confirm-modal-desc">
                    Apakah Anda yakin data rincian pemesanan sudah benar? Pengajuan Anda akan segera dikirimkan ke
                    sistem UPTD Balatkop-UK Prov. Kalsel untuk diverifikasi admin.
                </p>

                <div class="confirm-modal-actions">
                    <button type="button" class="btn-pesan-secondary" wire:click="tutupModalKonfirmasi">
                        <i class="fa-solid fa-xmark me-2"></i> Batal / Edit
                    </button>
                    <button type="button" class="btn-pesan-submit" wire:click="kirimPemesanan"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove><i class="fa-solid fa-check me-2"></i> Ya, Kirim!</span>
                        <span wire:loading><i class="fa-solid fa-spinner fa-spin me-2"></i> Mengirim...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('scroll-to-form', () => {
            const el = document.getElementById('pesan-form-top');
            if (el) {
                const offset = 100;
                const bodyRect = document.body.getBoundingClientRect().top;
                const elementRect = el.getBoundingClientRect().top;
                const elementPosition = elementRect - bodyRect;
                const offsetPosition = elementPosition - offset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
</script>
