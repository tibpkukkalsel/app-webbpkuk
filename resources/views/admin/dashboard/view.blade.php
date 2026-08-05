@extends('layouts.admins')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('admins/css/dashboard-admin.css') }}?v={{ time() }}">
    @endpush

    @php
        $user = Auth::user();
        $isSuperadmin = $user->hasRole('Superadmin');
        $isAdminWebsite = $user->hasRole('Admin Website');
        $isAdminFasilitas = $user->hasRole('Admin Fasilitas');
        $isAdminDiklat = $user->hasRole('Admin Diklat');
        $isAdminKemasan = $user->hasRole('Admin Layanan Kemasan');
        $isAdminHelpdesk = $user->hasRole('Admin Helpdesk');

        $canSeePosts = $isSuperadmin || $isAdminWebsite || $isAdminKemasan;
        $canSeeKontak = $isSuperadmin || $isAdminHelpdesk;
        $canSeeFasilitas = $isSuperadmin || $isAdminFasilitas;
        $canSeeDiklat = $isSuperadmin || $isAdminDiklat;
        $canSeeProdukCard = $isAdminKemasan && !$isSuperadmin;

        $visibleStatCardsCount = ($canSeePosts ? 1 : 0) + ($canSeeKontak ? 1 : 0) + ($canSeeFasilitas ? 1 : 0) + ($canSeeDiklat ? 1 : 0) + ($canSeeProdukCard ? 1 : 0);

        if ($visibleStatCardsCount == 1) {
            $statColClass = 'col-12';
        } elseif ($visibleStatCardsCount == 2) {
            $statColClass = 'col-12 col-md-6';
        } elseif ($visibleStatCardsCount == 3) {
            $statColClass = 'col-12 col-md-4';
        } else {
            $statColClass = 'col-md-6 col-xl-3';
        }

        $showLeftCol = $canSeePosts || $canSeeFasilitas;
        $showRightCol = $canSeeKontak || $canSeeDiklat || $isSuperadmin;

        $leftColClass = ($showLeftCol && !$showRightCol) ? 'col-lg-12' : 'col-lg-7';
        $rightColClass = (!$showLeftCol && $showRightCol) ? 'col-lg-12' : 'col-lg-5';
    @endphp

    <!-- Welcome Colorful Hero Card -->
    <div class="card dash-hero-card text-white mb-4 border-0">
        <div class="card-body p-4 p-lg-5 position-relative" style="z-index: 2;">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
                        <span class="badge glass-pill px-3 py-2 rounded-pill fs-2">
                            <i class="ti ti-calendar me-1"></i>
                            {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
                        </span>
                        <span class="badge bg-success text-white px-3 py-2 rounded-pill fs-2 shadow-sm">
                            <i class="ti ti-circle-check me-1"></i> System Online
                        </span>
                        <span class="badge bg-white text-dark px-3 py-2 rounded-pill fs-2 shadow-sm">
                            <i class="ti ti-user-check me-1"></i> Role: {{ $user->roles->first()->name ?? 'Administrator' }}
                        </span>
                    </div>
                    <h2 class="fw-extrabold text-white mb-2 display-6" style="letter-spacing: -0.5px;">
                        Selamat Datang, {{ $user->name ?? 'Administrator' }}!
                    </h2>
                    <p class="mb-4 text-white text-opacity-90 fs-4" style="max-width: 680px; line-height: 1.5;">
                        Control Panel Resmi Balai Pelatihan Koperasi dan Usaha Kecil Provinsi Kalimantan Selatan. Pantau
                        informasi publik, kelola reservasi fasilitas, dan update data diklat.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        @hasanyrole('Superadmin|Admin Website|Admin Layanan Kemasan')
                            <a href="{{ route('berita.create') }}"
                                class="btn btn-white text-primary fw-bold px-4 py-2 rounded-3 shadow-sm bg-white">
                                <i class="ti ti-plus me-1"></i> Buat Berita Baru
                            </a>
                        @endhasanyrole
                        <a href="{{ url('/') }}" target="_blank"
                            class="btn glass-pill text-white fw-semibold px-4 py-2 rounded-3">
                            <i class="ti ti-external-link me-1"></i> Website Publik ↗
                        </a>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block text-end">
                    <img src="{{ asset('admins/images/welcome_vector.png') }}" alt="Selamat Datang Admin"
                        class="img-fluid me-2"
                        style="max-height: 290px; width: auto; filter: drop-shadow(0 14px 28px rgba(0,0,0,0.35)); margin-top: -20px; margin-bottom: -20px;">
                </div>
            </div>
        </div>
    </div>

    <!-- VIVID GRADIENT STAT METRIC CARDS (ALL METRICS COMBINED IN ONE SEAMLESS ROW) -->
    <div class="row g-3 mb-4">
        <!-- Card 1: Total Postingan Konten -->
        @hasanyrole('Superadmin|Admin Website|Admin Layanan Kemasan')
        <div class="{{ $statColClass }}">
            <div class="card stat-card-gradient-1 h-100 border-0 p-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="glass-icon-box">
                        <i class="ti ti-article"></i>
                    </div>
                    <span class="badge glass-pill px-3 py-1 rounded-pill fs-2">
                        Publikasi Content
                    </span>
                </div>
                <h1 class="fw-extrabold mb-1 text-white display-5">{{ number_format($totalSemuaPost) }}</h1>
                <p class="text-white text-opacity-80 fs-3 mb-3 fw-medium">Total Postingan Konten</p>
                <div class="d-flex align-items-center gap-2 pt-2 border-top border-white border-opacity-25">
                    <span class="badge bg-white text-primary fw-bold fs-2 px-2 py-1 rounded-2">
                        {{ $postPublish }} Publish
                    </span>
                    <span class="badge glass-pill fw-semibold fs-2 px-2 py-1 rounded-2">
                        {{ $postDraft }} Draft
                    </span>
                </div>
            </div>
        </div>
        @endhasanyrole

        <!-- Card 2: Pesan Kontak & Helpdesk -->
        @hasanyrole('Superadmin|Admin Helpdesk')
        <div class="{{ $statColClass }}">
            <div class="card stat-card-gradient-2 h-100 border-0 p-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="glass-icon-box">
                        <i class="ti ti-mail-opened"></i>
                    </div>
                    @if ($kontakMenunggu > 0)
                        <span class="badge bg-white text-danger fw-bold fs-2 px-3 py-1 rounded-pill shadow-sm">
                            🔥 {{ $kontakMenunggu }} Pesan Baru
                        </span>
                    @else
                        <span class="badge glass-pill px-3 py-1 rounded-pill fs-2">
                            Semua Terjawab
                        </span>
                    @endif
                </div>
                <h1 class="fw-extrabold mb-1 text-white display-5">{{ number_format($totalKontak) }}</h1>
                <p class="text-white text-opacity-80 fs-3 mb-3 fw-medium">Pesan Kontak Masuk</p>
                <div class="d-flex align-items-center gap-2 pt-2 border-top border-white border-opacity-25">
                    @can('kontak.view')
                        <a href="{{ route('kontak.view') }}"
                            class="badge bg-white text-danger fw-bold fs-2 px-2 py-1 rounded-2 text-decoration-none">
                            <i class="ti ti-arrow-right me-1"></i> Respon Pesan Inbox
                        </a>
                    @else
                        <span class="badge glass-pill fs-2">Inbox Helpdesk</span>
                    @endcan
                </div>
            </div>
        </div>
        @endhasanyrole

        <!-- Card 3: Reservasi Sewa Fasilitas -->
        @hasanyrole('Superadmin|Admin Fasilitas')
        <div class="{{ $statColClass }}">
            <div class="card stat-card-gradient-3 h-100 border-0 p-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="glass-icon-box">
                        <i class="ti ti-building"></i>
                    </div>
                    @if ($pemesanMenunggu > 0)
                        <span class="badge bg-amber text-dark bg-white fw-bold fs-2 px-3 py-1 rounded-pill shadow-sm"
                            style="color: #b45309 !important;">
                            ⚡ {{ $pemesanMenunggu }} Menunggu
                        </span>
                    @else
                        <span class="badge glass-pill px-3 py-1 rounded-pill fs-2">
                            Terproses
                        </span>
                    @endif
                </div>
                <h1 class="fw-extrabold mb-1 text-white display-5">{{ number_format($totalPemesanFasilitas) }}</h1>
                <p class="text-white text-opacity-80 fs-3 mb-3 fw-medium">Permohonan Sewa Fasilitas</p>
                <div class="d-flex align-items-center gap-2 pt-2 border-top border-white border-opacity-25">
                    <a href="{{ route('fasilitas.pemesan.view') }}"
                        class="badge bg-white text-info fw-bold fs-2 px-2 py-1 rounded-2 text-decoration-none">
                        <i class="ti ti-eye me-1"></i> Kelola Pemesan
                    </a>
                </div>
            </div>
        </div>
        @endhasanyrole

        <!-- Card 4: Realisasi Alumni Diklat GIS -->
        @hasanyrole('Superadmin|Admin Diklat')
        <div class="{{ $statColClass }}">
            <div class="card stat-card-gradient-4 h-100 border-0 p-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="glass-icon-box">
                        <i class="ti ti-user-check"></i>
                    </div>
                    <span class="badge glass-pill px-3 py-1 rounded-pill fs-2">
                        Alumni Diklat
                    </span>
                </div>
                <h1 class="fw-extrabold mb-1 text-white display-5">{{ number_format($totalRealisasiDiklat) }}</h1>
                <p class="text-white text-opacity-80 fs-3 mb-3 fw-medium">Total Alumni Terlatih</p>
                <div
                    class="d-flex align-items-center justify-content-between pt-2 border-top border-white border-opacity-25">
                    <span class="badge glass-pill fs-2">Target: {{ number_format($totalTargetDiklat) }}</span>
                    <span class="badge glass-pill fs-2">IKP: {{ number_format($totalRespondenIKP) }}</span>
                </div>
            </div>
        </div>
        @endhasanyrole

        <!-- Card 5: Produk UMKM (Integrated into top stat row for Admin Layanan Kemasan) -->
        @if ($canSeeProdukCard)
        <div class="{{ $statColClass }}">
            <div class="card stat-card-gradient-4 h-100 border-0 p-3" style="background: linear-gradient(135deg, #8b5cf6, #6d28d9) !important;">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="glass-icon-box">
                        <i class="ti ti-shopping-cart"></i>
                    </div>
                    <span class="badge glass-pill px-3 py-1 rounded-pill fs-2">
                        Layanan Kemasan
                    </span>
                </div>
                <h1 class="fw-extrabold mb-1 text-white display-5">{{ number_format($totalProdukUmkm) }}</h1>
                <p class="text-white text-opacity-80 fs-3 mb-3 fw-medium">Produk UMKM Terdaftar</p>
                <div class="d-flex align-items-center gap-2 pt-2 border-top border-white border-opacity-25">
                    <a href="{{ route('produk-umkm.view') }}"
                        class="badge bg-white text-purple fw-bold fs-2 px-2 py-1 rounded-2 text-decoration-none"
                        style="color: #6d28d9 !important;">
                        <i class="ti ti-eye me-1"></i> Kelola Etalase Produk
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- COLORFUL SUB-METRICS ROW FOR SUPERADMIN -->
    @hasrole('Superadmin')
    <div class="row g-3 mb-4">
        <!-- Card 1: Data Pegawai -->
        <div class="col-6 col-md-3">
            <div class="card quick-badge-card bg-white p-3 shadow-sm border-start border-4 border-teal"
                style="border-left-color: #14b8a6 !important;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-2 text-white" style="background: linear-gradient(135deg, #0d9488, #0f766e);">
                        <i class="ti ti-users fs-6"></i>
                    </div>
                    <div>
                        <div class="fs-2 text-muted fw-semibold">Data Pegawai</div>
                        <h4 class="fw-bold text-dark mb-0">{{ number_format($totalPegawai) }} <small
                                class="fs-2 text-muted fw-normal">Orang</small></h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Agenda Kegiatan -->
        <div class="col-6 col-md-3">
            <div class="card quick-badge-card bg-white p-3 shadow-sm border-start border-4 border-amber"
                style="border-left-color: #f59e0b !important;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-2 text-white" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                        <i class="ti ti-calendar fs-6"></i>
                    </div>
                    <div>
                        <div class="fs-2 text-muted fw-semibold">Agenda Kegiatan</div>
                        <h4 class="fw-bold text-dark mb-0">{{ number_format($totalAgenda) }} <small
                                class="fs-2 text-muted fw-normal">Agenda</small></h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Produk UMKM -->
        <div class="col-6 col-md-3">
            <div class="card quick-badge-card bg-white p-3 shadow-sm border-start border-4 border-purple"
                style="border-left-color: #8b5cf6 !important;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-2 text-white" style="background: linear-gradient(135deg, #a855f7, #7c3aed);">
                        <i class="ti ti-shopping-cart fs-6"></i>
                    </div>
                    <div>
                        <div class="fs-2 text-muted fw-semibold">Produk UMKM</div>
                        <h4 class="fw-bold text-dark mb-0">{{ number_format($totalProdukUmkm) }} <small
                                class="fs-2 text-muted fw-normal">Produk</small></h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: Pengguna Sistem -->
        <div class="col-6 col-md-3">
            <div class="card quick-badge-card bg-white p-3 shadow-sm border-start border-4 border-pink"
                style="border-left-color: #ec4899 !important;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-2 text-white" style="background: linear-gradient(135deg, #ec4899, #be185d);">
                        <i class="ti ti-user-cog fs-6"></i>
                    </div>
                    <div>
                        <div class="fs-2 text-muted fw-semibold">Pengguna Sistem</div>
                        <h4 class="fw-bold text-dark mb-0">{{ number_format($totalUser) }} <small
                                class="fs-2 text-muted fw-normal">User</small></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endhasrole

    <!-- COLORFUL MAIN CONTENT GRID -->
    <div class="row g-4 mb-4">

        <!-- LEFT COLUMN: POSTINGAN TERBARU & SEWA FASILITAS -->
        @if($showLeftCol)
        <div class="{{ $leftColClass }}">

            <!-- Card 1: Postingan Konten Terbaru -->
            @hasanyrole('Superadmin|Admin Website|Admin Layanan Kemasan')
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div
                    class="card-header table-header-blue py-3 px-4 d-flex align-items-center justify-content-between border-0">
                    <div class="d-flex align-items-center gap-2">
                        <div class="p-2 bg-primary text-white rounded-3">
                            <i class="ti ti-file-text fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-primary-emphasis">Postingan Terbaru</h5>
                            <small class="text-muted">Status berita, artikel, dan info & tips publikasi website</small>
                        </div>
                    </div>
                    <a href="{{ route('berita.view') }}" class="btn btn-sm btn-primary fw-semibold px-3 rounded-pill">
                        Lihat Semua ↗
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr class="fs-2 text-muted">
                                    <th class="ps-4">JUDUL KONTEN</th>
                                    <th class="text-center">JENIS</th>
                                    <th class="text-center">STATUS</th>
                                    <th class="text-end pe-4">TANGGAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestPosts as $post)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center gap-3">
                                                @if (!empty($post->thumbnail))
                                                    <img src="{{ asset('storage/post/thumbnail/' . $post->thumbnail) }}"
                                                        alt="thumb" class="rounded-3 shadow-sm" width="44"
                                                        height="34" style="object-fit: cover;">
                                                @else
                                                    <div class="bg-primary-subtle text-primary rounded-3 d-flex align-items-center justify-content-center"
                                                        style="width:44px; height:34px;">
                                                        <i class="ti ti-photo fs-4"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <a href="{{ route('berita.view') }}"
                                                        class="fw-bold text-dark text-decoration-none d-block text-truncate"
                                                        style="max-width: 230px;" title="{{ $post->judul }}">
                                                        {{ $post->judul }}
                                                    </a>
                                                    <small class="text-muted fs-1"><i
                                                            class="ti ti-tag me-1"></i>{{ $post->kategori?->nama_kategori ?? 'Umum' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if ($post->jenis == 'Berita')
                                                <span
                                                    class="badge bg-primary-subtle text-primary fw-bold rounded-pill px-3 py-1">Berita</span>
                                            @elseif($post->jenis == 'Artikel')
                                                <span
                                                    class="badge bg-info-subtle text-info fw-bold rounded-pill px-3 py-1">Artikel</span>
                                            @else
                                                <span
                                                    class="badge bg-warning-subtle text-warning fw-bold rounded-pill px-3 py-1">Info
                                                    & Tips</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($post->status == 2)
                                                <span
                                                    class="badge bg-success text-white fw-bold rounded-pill px-3 py-1 shadow-sm"><i
                                                        class="ti ti-check me-1"></i>Publish</span>
                                            @elseif($post->status == 1)
                                                <span
                                                    class="badge bg-info text-white fw-bold rounded-pill px-3 py-1">Terkirim</span>
                                            @else
                                                <span
                                                    class="badge bg-secondary-subtle text-secondary fw-bold rounded-pill px-3 py-1">Draft</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4 text-muted fs-2">
                                            {{ $post->created_at ? $post->created_at->format('d/m/Y') : '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted fs-3">
                                            Belum ada data postingan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endhasanyrole

            <!-- Card 2: Permohonan Sewa Fasilitas Terbaru -->
            @hasanyrole('Superadmin|Admin Fasilitas')
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div
                    class="card-header table-header-cyan py-3 px-4 d-flex align-items-center justify-content-between border-0">
                    <div class="d-flex align-items-center gap-2">
                        <div class="p-2 bg-info text-white rounded-3">
                            <i class="ti ti-building fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-info-emphasis">Pemesanan Fasilitas Terbaru</h5>
                            <small class="text-muted">Permohonan reservasi sewa ruang & gedung</small>
                        </div>
                    </div>
                    <a href="{{ route('fasilitas.pemesan.view') }}"
                        class="btn btn-sm btn-info text-white fw-semibold px-3 rounded-pill">
                        Kelola Pemesan ↗
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr class="fs-2 text-muted">
                                    <th class="ps-4">BOOKING / PEMOHON</th>
                                    <th>INSTANSI & KEPERLUAN</th>
                                    <th class="text-center">STATUS</th>
                                    <th class="text-end pe-4">TANGGAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestPemesan as $pemesan)
                                    <tr>
                                        <td class="ps-4">
                                            <span
                                                class="badge bg-light text-dark border fw-bold fs-2 d-inline-block mb-1">{{ $pemesan->nomor_booking }}</span>
                                            <span
                                                class="text-primary fw-bold fs-2 d-block">{{ $pemesan->nama_pemohon }}</span>
                                        </td>
                                        <td>
                                            <span class="d-block text-truncate fs-2 fw-semibold text-dark"
                                                style="max-width: 200px;">{{ $pemesan->instansi ?: 'Perorangan' }}</span>
                                            <small class="text-muted fs-1 d-block text-truncate"
                                                style="max-width: 200px;">{{ $pemesan->keperluan }}</small>
                                        </td>
                                        <td class="text-center">
                                            @if ($pemesan->status == 'Disetujui' || $pemesan->status == 'Selesai')
                                                <span
                                                    class="badge bg-success text-white fw-bold rounded-pill px-3 py-1 shadow-sm">{{ $pemesan->status }}</span>
                                            @elseif($pemesan->status == 'Ditolak')
                                                <span
                                                    class="badge bg-danger text-white fw-bold rounded-pill px-3 py-1">Ditolak</span>
                                            @else
                                                <span
                                                    class="badge bg-warning text-dark fw-bold rounded-pill px-3 py-1 shadow-sm">Menunggu</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4 text-muted fs-2">
                                            {{ $pemesan->created_at ? $pemesan->created_at->format('d/m/Y') : '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted fs-3">
                                            Belum ada permohonan sewa fasilitas.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endhasanyrole

        </div>
        @endif

        <!-- RIGHT COLUMN: INBOX KONTAK & COLORFUL SHORTCUTS -->
        @if($showRightCol)
        <div class="{{ $rightColClass }}">

            <!-- Card 1: Pesan Kontak Masuk Inbox -->
            @hasanyrole('Superadmin|Admin Helpdesk')
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div
                    class="card-header table-header-rose py-3 px-4 d-flex align-items-center justify-content-between border-0">
                    <div class="d-flex align-items-center gap-2">
                        <div class="p-2 bg-rose text-white rounded-3" style="background: #e11d48;">
                            <i class="ti ti-mail-opened fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-rose-emphasis">Pesan Kontak Masuk</h5>
                            <small class="text-muted">Surat & pertanyaan terbaru publik</small>
                        </div>
                    </div>
                    @can('kontak.view')
                        <a href="{{ route('kontak.view') }}" class="btn btn-sm btn-danger fw-semibold px-3 rounded-pill"
                            style="background: #e11d48; border-color: #e11d48;">
                            Inbox ↗
                        </a>
                    @endcan
                </div>
                <div class="card-body p-4">
                    <div class="list-group list-group-flush gap-2">
                        @forelse($latestKontak as $kontak)
                            <a href="{{ route('kontak.view') }}"
                                class="list-group-item list-group-item-action p-3 rounded-3 border mb-1">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <h6 class="fw-bold text-dark mb-0 fs-3">{{ $kontak->nama }}</h6>
                                    <small
                                        class="text-muted fs-1">{{ $kontak->created_at ? $kontak->created_at->locale('id')->diffForHumans() : '' }}</small>
                                </div>
                                <p class="text-muted fs-2 mb-2 text-truncate" style="max-width: 320px;">
                                    <strong class="text-dark">Subjek:</strong> {{ $kontak->subjek }}
                                </p>
                                <div class="d-flex align-items-center justify-content-between">
                                    @if ($kontak->status == 'belum')
                                        <span class="badge bg-danger text-white rounded-pill fs-1 px-3 py-1 shadow-sm"><i
                                                class="ti ti-bell me-1"></i>Belum Dibaca</span>
                                    @else
                                        <span class="badge bg-success-subtle text-success rounded-pill fs-1 px-3 py-1"><i
                                                class="ti ti-check me-1"></i>Terbaca / Direspon</span>
                                    @endif
                                    <span class="text-primary fs-1 fw-bold">Buka Pesan ↗</span>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-4 text-muted fs-3">
                                Belum ada pesan kontak masuk.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            @endhasanyrole

            <!-- Card 2: COLORFUL PINTASAN AKSES CEAPAT -->
            @hasanyrole('Superadmin|Admin Diklat|Admin Layanan Kemasan')
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header table-header-purple py-3 px-4 border-0">
                    <div class="d-flex align-items-center gap-2">
                        <div class="p-2 bg-purple text-white rounded-3" style="background: #7c3aed;">
                            <i class="ti ti-layout-grid fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-purple-emphasis">Pintasan Akses Cepat</h5>
                            <small class="text-muted">Klik ikon untuk navigasi langsung ke menu</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        @hasrole('Superadmin')
                        <div class="col-6">
                            <a href="{{ route('identitas.view') }}"
                                class="card shortcut-card text-decoration-none p-3 h-100 shadow-sm">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="p-3 text-white rounded-3 shadow-sm"
                                        style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">
                                        <i class="ti ti-id-badge fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold fs-3 text-dark">Identitas</div>
                                        <small class="text-muted fs-1">Logo & Kontak</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endhasrole

                        @hasanyrole('Superadmin|Admin Diklat')
                        <div class="col-6">
                            <a href="{{ route('layanan.view', ['tab' => 'target']) }}"
                                class="card shortcut-card text-decoration-none p-3 h-100 shadow-sm">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="p-3 text-white rounded-3 shadow-sm"
                                        style="background: linear-gradient(135deg, #10b981, #047857);">
                                        <i class="ti ti-target fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold fs-3 text-dark">Target Diklat</div>
                                        <small class="text-muted fs-1">Kuota Pelatihan</small>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-6">
                            <a href="{{ route('layanan.view', ['tab' => 'realisasi']) }}"
                                class="card shortcut-card text-decoration-none p-3 h-100 shadow-sm">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="p-3 text-white rounded-3 shadow-sm"
                                        style="background: linear-gradient(135deg, #0ea5e9, #0369a1);">
                                        <i class="ti ti-chart-line fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold fs-3 text-dark">Realisasi</div>
                                        <small class="text-muted fs-1">Alumni Diklat</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endhasanyrole

                        @hasanyrole('Superadmin|Admin Layanan Kemasan')
                        <div class="col-6">
                            <a href="{{ route('produk-umkm.view') }}"
                                class="card shortcut-card text-decoration-none p-3 h-100 shadow-sm">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="p-3 text-white rounded-3 shadow-sm"
                                        style="background: linear-gradient(135deg, #f59e0b, #b45309);">
                                        <i class="ti ti-shopping-cart fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold fs-3 text-dark">Produk UMKM</div>
                                        <small class="text-muted fs-1">Etalase UMKM</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endhasanyrole

                        @hasrole('Superadmin')
                        <div class="col-6">
                            <a href="{{ route('pegawai.view') }}"
                                class="card shortcut-card text-decoration-none p-3 h-100 shadow-sm">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="p-3 text-white rounded-3 shadow-sm"
                                        style="background: linear-gradient(135deg, #8b5cf6, #6d28d9);">
                                        <i class="ti ti-users fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold fs-3 text-dark">Data Pegawai</div>
                                        <small class="text-muted fs-1">Struktur SDM</small>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-6">
                            <a href="{{ route('hero-banner.view') }}"
                                class="card shortcut-card text-decoration-none p-3 h-100 shadow-sm">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="p-3 text-white rounded-3 shadow-sm"
                                        style="background: linear-gradient(135deg, #ec4899, #be185d);">
                                        <i class="ti ti-photo fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold fs-3 text-dark">Hero Banner</div>
                                        <small class="text-muted fs-1">Banner Beranda</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endhasrole
                    </div>
                </div>
            </div>
            @endhasanyrole

        </div>
        @endif

    </div>
@endsection
