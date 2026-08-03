<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Dibatasi Sementara (429) | Balatkop-UK Prov. Kalsel</title>
    <meta name="description" content="Perangkat Anda mengirimkan terlalu banyak permintaan dalam waktu singkat. Silakan tunggu sebentar dan coba lagi.">
    <meta name="robots" content="noindex, nofollow">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Standalone Error CSS -->
    <link rel="stylesheet" href="{{ asset('websites/css/error-pages.css') }}">
</head>

<body class="error-page-body">

    <!-- ===== STANDALONE HEADER (sepenuhnya statis, tanpa query DB/storage) ===== -->
    <header class="error-header">
        <div class="error-header-container">
            <!-- Kiri: Branding teks statis -->
            <a href="{{ url('/') }}" class="error-brand-link">
                <div>
                    <div class="error-brand-title">BALATKOP-UK</div>
                    <div class="error-brand-sub">Prov. Kalimantan Selatan</div>
                </div>
            </a>
            <!-- Kanan: Tombol Beranda -->
            <a href="{{ url('/') }}" class="error-header-btn">
                <i class="fa-solid fa-house"></i> Beranda
            </a>
        </div>
    </header>

    <!-- ===== HERO BANNER ===== -->
    <div class="error-hero-banner">
        <div class="error-breadcrumb">
            <a href="{{ url('/') }}"><i class="fa-solid fa-house"></i> Home</a>
            <span>&rsaquo;</span>
            <span>Error 429</span>
        </div>
        <h1 class="error-hero-title">Akses Dibatasi Sementara</h1>
    </div>

    <!-- ===== MAIN CONTENT ===== -->
    <main class="error-main-wrapper">
        <div class="error-card">

            <!-- Icon -->
            <div class="error-icon-box">
                <i class="fa-solid fa-screwdriver-wrench"></i>
            </div>

            <!-- Status Badge -->
            <div class="error-status-pill">
                <span class="error-dot"></span>
                Akses Dibatasi &mdash; HTTP 429
            </div>

            <!-- Heading -->
            <h2 class="error-heading">Sistem Sedang Membatasi Akses</h2>

            <!-- Description -->
            <p class="error-description">
                Perangkat Anda terdeteksi mengirimkan terlalu banyak permintaan atau pencarian dalam waktu singkat.
                Demi menjaga keandalan server dan kenyamanan seluruh pengguna, akses Anda dibatasi untuk sementara.
                Silakan tunggu sebelum mencoba kembali.
            </p>

            <!-- Info Grid -->
            <div class="error-info-grid">
                <div class="error-info-item">
                    <div class="error-info-icon">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                    <div>
                        <div style="font-size:0.72rem;color:#64748b;font-weight:700;text-transform:uppercase;margin-bottom:2px;">Waktu Tunggu</div>
                        <div style="font-size:0.9rem;font-weight:700;color:#0f172a;">
                            Tersisa: <span id="error-countdown" data-seconds="60">1 menit</span>
                        </div>
                    </div>
                </div>
                <div class="error-info-item">
                    <div class="error-info-icon">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <div style="font-size:0.72rem;color:#64748b;font-weight:700;text-transform:uppercase;margin-bottom:2px;">Perlindungan</div>
                        <div style="font-size:0.9rem;font-weight:700;color:#0f172a;">Anti-Spam Server</div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="error-btn-group">
                <a href="{{ url('/') }}" class="error-btn-main">
                    <i class="fa-solid fa-house"></i> Kembali ke Beranda
                </a>
                <button id="btn-reload" onclick="location.reload()" class="error-btn-sub">
                    <i class="fa-solid fa-rotate-right"></i> Muat Ulang Halaman
                </button>
            </div>

        </div>
    </main>

    <!-- ===== STANDALONE FOOTER (statis) ===== -->
    <footer class="error-footer">
        &copy; {{ date('Y') }} Balai Pelatihan Koperasi &amp; Usaha Kecil Provinsi Kalimantan Selatan. Semua hak dilindungi.
    </footer>

    <!-- Standalone Error JS (countdown, reload) -->
    <script src="{{ asset('websites/js/error-pages.js') }}"></script>

</body>
</html>
