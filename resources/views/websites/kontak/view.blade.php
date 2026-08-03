@extends('layouts.websites')

@section('title', 'Kontak & Helpdesk - Balatkop UKM Kalsel')

@section('content')
    <!-- DEDICATED KONTAK CSS -->
    <link rel="stylesheet" href="{{ asset('websites/css/kontak.css') }}?v={{ time() }}">

    <!-- PAGE BANNER / BREADCRUMB HEADER -->
    <div class="profile-page-banner"
        style="background-image: url('{{ asset('storage/profileweb/' . ($tentang->firstWhere('status', 'file')?->keterangan ?? '')) }}');">
        <div class="profile-banner-overlay"></div>
        <div class="profile-banner-container">
            <div class="profile-breadcrumb">
                <a href="{{ url('/') }}"><i class="fa-solid fa-house"></i> BERANDA</a>
                <span class="separator">/</span>
                <span class="current">KONTAK & HELPDESK</span>
            </div>
            <h1 class="profile-banner-title">Kontak & Helpdesk</h1>
        </div>
    </div>

    <!-- MAIN SECTION WITH DEDICATED KONTAK GRID -->
    <section class="kt-page-wrapper">
        <div class="kt-container">
            <div class="kt-grid-layout">

                <!-- LEFT SIDEBAR: CONTACT INFO -->
                <aside class="kt-sidebar">
                    @php
                        $teleponItem = isset($identitas) ? $identitas->firstWhere('nama', 'Telepon') : null;
                        $teleponNum = $teleponItem?->keterangan ?? '08123456789';
                        $teleponLink = $teleponItem?->link ?? ('https://wa.me/' . preg_replace('/[^0-9]/', '', $teleponNum));

                        $emailItem = isset($identitas) ? $identitas->firstWhere('nama', 'Email') : null;
                        $emailAddr = $emailItem?->keterangan ?? 'bpkuk.provkalsel@gmail.com';

                        $alamatItem = isset($identitas) ? $identitas->firstWhere('nama', 'Alamat') : null;
                        $alamatText = $alamatItem?->keterangan ?? 'Jl. Ahmad Yani KM. 18.200 Kec. Liang Anggang Kota Banjarbaru, Kalimantan Selatan 70722';
                        $mapsLink = $alamatItem?->link ?? 'https://maps.google.com/?q=' . urlencode($alamatText);
                    @endphp

                    <!-- INFORMASI KANTOR CARD -->
                    <div class="kt-card" id="info-kontak-section">
                        <div class="kt-sidebar-nav-title mb-3">
                            <i class="fa-solid fa-building me-1"></i> Informasi Kontak Resmi
                        </div>

                        <div class="kt-info-group">
                            <!-- HOTLINE WA -->
                            <div class="kt-info-item">
                                <div class="kt-info-icon icon-wa">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </div>
                                <div class="kt-info-content">
                                    <span class="kt-info-label">Hotline WhatsApp</span>
                                    <a href="{{ $teleponLink }}" target="_blank" rel="noopener noreferrer" class="kt-info-val-link text-success">
                                        {{ $teleponNum }}
                                    </a>
                                </div>
                            </div>

                            <!-- EMAIL RESMI -->
                            <div class="kt-info-item">
                                <div class="kt-info-icon icon-mail">
                                    <i class="fa-regular fa-envelope"></i>
                                </div>
                                <div class="kt-info-content">
                                    <span class="kt-info-label">Email Resmi</span>
                                    <a href="mailto:{{ $emailAddr }}" class="kt-info-val-link">
                                        {{ $emailAddr }}
                                    </a>
                                </div>
                            </div>

                            <!-- ALAMAT (KLIK BUKA GOOGLE MAPS) -->
                            <div class="kt-info-item">
                                <div class="kt-info-icon icon-loc">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <div class="kt-info-content">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="kt-info-label">Alamat Kantor</span>
                                        <span class="kt-maps-badge">Maps ↗</span>
                                    </div>
                                    <a href="{{ $mapsLink }}" target="_blank" rel="noopener noreferrer" class="kt-info-val-link">
                                        {{ $alamatText }}
                                    </a>
                                </div>
                            </div>

                            <!-- WAKTU PELAYANAN -->
                            <div class="kt-info-item">
                                <div class="kt-info-icon icon-time">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <div class="kt-info-content">
                                    <span class="kt-info-label">Waktu Pelayanan</span>
                                    <span class="kt-info-val-text">
                                        Senin - Jumat: 08.00 - 16.00 WITA
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </aside>

                <!-- RIGHT MAIN CONTENT CARD -->
                <main class="kt-main-card" id="form-kontak-section">
                    
                    <!-- HERO HEADER CARD -->
                    <div class="kt-hero-header">
                        <div class="kt-hero-left">
                            <div class="kt-hero-icon">
                                <i class="fa-solid fa-headset"></i>
                            </div>
                             <div>
                                 <div class="kt-hero-sub">Helpdesk & Pengaduan Resmi</div>
                                 <h2 class="kt-hero-title">Formulir Pesan & Hubungi Kami</h2>
                             </div>
                         </div>
                     </div>

                    <!-- FORM CONTENT -->
                    <div class="kt-form-title">
                        <i class="fa-solid fa-envelope-open-text text-primary"></i> Kirim Pesan atau Pertanyaan Anda
                    </div>
                    <p class="kt-form-desc">
                        Silakan lengkapi formulir pesan di bawah ini. Balasan resmi dari Admin Helpdesk Balatkop UKM Kalsel akan dikirimkan langsung ke alamat email Anda.
                    </p>

                    @if (session('success_kontak'))
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    title: 'Pesan Berhasil Terkirim!',
                                    text: "{{ session('success_kontak') }}",
                                    icon: 'success',
                                    confirmButtonText: 'Selesai & Terima Kasih',
                                    confirmButtonColor: '#0284c7',
                                    allowOutsideClick: true,
                                    customClass: {
                                        popup: 'rounded-4 shadow-lg'
                                    }
                                });
                            });
                        </script>
                    @endif

                    @if (isset($errors) && $errors->any())
                        <div class="kt-alert-danger">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            <div>
                                <strong>Pengiriman Gagal!</strong>
                                <div>Mohon periksa kembali form pengisian Anda di bawah ini.</div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('website.kontak.kirim') }}" method="POST" id="formKontakPublic">
                        @csrf

                        <!-- HONEYPOT HIDDEN FIELD FOR ANTI-BOT / ANTI-SPAM PROTECTION -->
                        <div style="display:none !important; opacity:0; position:absolute; left:-9999px;" aria-hidden="true">
                            <input type="text" name="fax_hp" tabindex="-1" autocomplete="off" placeholder="Leave empty">
                        </div>

                        <!-- ROW 1: NAMA & EMAIL -->
                        <div class="kt-form-row">
                            <div class="kt-form-group">
                                <label for="nama" class="kt-label">Nama Lengkap <span class="kt-req">*</span></label>
                                <input type="text" 
                                       name="nama" 
                                       id="nama" 
                                       class="kt-input @error('nama') is-invalid @enderror" 
                                       placeholder="Masukkan nama lengkap Anda" 
                                       value="{{ old('nama') }}" 
                                       required>
                                @error('nama')
                                    <div class="kt-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="kt-form-group">
                                <label for="email" class="kt-label">Alamat Email Aktif <span class="kt-req">*</span></label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       class="kt-input @error('email') is-invalid @enderror" 
                                       placeholder="contoh@gmail.com" 
                                       value="{{ old('email') }}" 
                                       required>
                                @error('email')
                                    <div class="kt-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- ROW 2: TELEPON & SUBJEK -->
                        <div class="kt-form-row">
                            <div class="kt-form-group">
                                <label for="telepon" class="kt-label">Nomor HP / WhatsApp</label>
                                <input type="text" 
                                       name="telepon" 
                                       id="telepon" 
                                       inputmode="numeric"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                       class="kt-input @error('telepon') is-invalid @enderror" 
                                       placeholder="081234567890" 
                                       value="{{ old('telepon') }}">
                                @error('telepon')
                                    <div class="kt-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="kt-form-group">
                                <label for="subjek" class="kt-label">Subjek Pesan <span class="kt-req">*</span></label>
                                <input type="text" 
                                       name="subjek" 
                                       id="subjek" 
                                       class="kt-input @error('subjek') is-invalid @enderror" 
                                       placeholder="Topik / Judul Pertanyaan Anda" 
                                       value="{{ old('subjek') }}" 
                                       required>
                                @error('subjek')
                                    <div class="kt-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- ROW 3: PESAN TEXTAREA -->
                        <div class="kt-form-group">
                            <label for="pesan" class="kt-label">Isi Pesan / Pertanyaan <span class="kt-req">*</span></label>
                            <textarea name="pesan" 
                                      id="pesan" 
                                      rows="5" 
                                      class="kt-input @error('pesan') is-invalid @enderror" 
                                      placeholder="Tuliskan pertanyaan, saran, atau permohonan informasi Anda di sini..." 
                                      required>{{ old('pesan') }}</textarea>
                            @error('pesan')
                                <div class="kt-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- SUBMIT BUTTON WITH SPINNER ANIMATION -->
                        <div class="kt-form-actions">
                            <button type="submit" class="kt-btn-submit" id="btnSubmitKontak">
                                <span id="btnSubmitText">
                                    <i class="fa-solid fa-paper-plane"></i> Kirim Pesan Online
                                </span>
                                <span id="btnSubmitLoading" style="display: none;">
                                    <i class="fa-solid fa-circle-notch fa-spin"></i> Mengirim Pesan...
                                </span>
                            </button>
                        </div>
                    </form>

                </main>

            </div>
        </div>
    </section>

    <!-- SWEETALERT2 LIBRARY & LOADING SCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('formKontakPublic');
            const btn = document.getElementById('btnSubmitKontak');
            const btnText = document.getElementById('btnSubmitText');
            const btnLoading = document.getElementById('btnSubmitLoading');

            if (form && btn) {
                form.addEventListener('submit', function() {
                    // Turn button icon to spinning loading icon
                    btn.disabled = true;
                    if (btnText && btnLoading) {
                        btnText.style.display = 'none';
                        btnLoading.style.display = 'inline-flex';
                        btnLoading.style.alignItems = 'center';
                        btnLoading.style.gap = '8px';
                    }

                    // Popup SweetAlert Loading spinner overlay before server responds
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Mengirim Pesan...',
                            text: 'Mohon tunggu sebentar, pesan Anda sedang dikirimkan ke Admin Helpdesk Balatkop Kalsel.',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    }
                });
            }
        });
    </script>
@endsection
