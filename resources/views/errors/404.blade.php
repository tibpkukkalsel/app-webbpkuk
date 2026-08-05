<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Ditemukan (404) | Balatkop-UK Prov. Kalsel</title>
    <meta name="description" content="Halaman yang Anda cari tidak ditemukan. Mungkin URL salah atau halaman telah dipindahkan.">
    <meta name="robots" content="noindex, nofollow">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Standalone Error CSS -->
    <link rel="stylesheet" href="{{ asset('websites/css/error-pages.css') }}">

    <style>
        /* Override warna khusus 404 (biru abu, bukan kuning/orange) */
        .error-404 .error-icon-box {
            background: #eff6ff;
            border-color: #bfdbfe;
            color: #2563eb;
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.18);
        }
        .error-404 .error-status-pill {
            background: #eff6ff;
            color: #1d4ed8;
            border-color: #bfdbfe;
        }
        .error-404 .error-dot {
            background-color: #3b82f6;
        }
        .error-404 .error-hero-banner {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%);
        }
        .error-404-code {
            font-size: 7rem;
            font-weight: 900;
            line-height: 1;
            background: linear-gradient(135deg, #bfdbfe, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -4px;
            margin-bottom: 4px;
            display: block;
        }
        .error-info-icon.blue { color: #2563eb; }
    </style>
</head>

<body class="error-page-body error-404">

    <!-- ===== STANDALONE HEADER (sepenuhnya statis) ===== -->
    <header class="error-header">
        <div class="error-header-container">
            <a href="{{ url('/') }}" class="error-brand-link">
                <div>
                    <div class="error-brand-title">BALATKOP-UK</div>
                    <div class="error-brand-sub">Prov. Kalimantan Selatan</div>
                </div>
            </a>
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
            <span>Error 404</span>
        </div>
        <h1 class="error-hero-title">Halaman Tidak Ditemukan</h1>
    </div>

    <!-- ===== MAIN CONTENT ===== -->
    <main class="error-main-wrapper">
        <div class="error-card">

            <!-- Kode Error Besar -->
            <span class="error-404-code">404</span>

            <!-- Icon -->
            <div class="error-icon-box" style="margin-top: 10px;">
                <i class="fa-solid fa-map-location-dot"></i>
            </div>

            <!-- Status Badge -->
            <div class="error-status-pill">
                <span class="error-dot"></span>
                Halaman Tidak Ditemukan &mdash; HTTP 404
            </div>

            <!-- Heading -->
            <h2 class="error-heading">Oops! Halaman ini tidak ada</h2>

            <!-- Description -->
            <p class="error-description">
                Halaman yang Anda cari tidak dapat ditemukan. Kemungkinan URL yang dimasukkan salah,
                halaman telah dipindahkan, atau konten sudah tidak tersedia.
                Silakan kembali ke beranda atau gunakan menu navigasi untuk menemukan informasi yang Anda butuhkan.
            </p>

            <!-- Info Grid -->
            <div class="error-info-grid">
                <div class="error-info-item">
                    <div class="error-info-icon blue">
                        <i class="fa-solid fa-link-slash"></i>
                    </div>
                    <div>
                        <div style="font-size:0.72rem;color:#64748b;font-weight:700;text-transform:uppercase;margin-bottom:2px;">Kemungkinan Penyebab</div>
                        <div style="font-size:0.9rem;font-weight:700;color:#0f172a;">URL Salah / Tidak Valid</div>
                    </div>
                </div>
                <div class="error-info-item">
                    <div class="error-info-icon blue">
                        <i class="fa-solid fa-rotate-left"></i>
                    </div>
                    <div>
                        <div style="font-size:0.72rem;color:#64748b;font-weight:700;text-transform:uppercase;margin-bottom:2px;">Solusi Cepat</div>
                        <div style="font-size:0.9rem;font-weight:700;color:#0f172a;">Kembali ke Beranda</div>
                    </div>
                </div>
            </div>



            <!-- Action Buttons -->
            <div class="error-btn-group">
                <a href="{{ url('/') }}" class="error-btn-main">
                    <i class="fa-solid fa-house"></i> Kembali ke Beranda
                </a>
                <button onclick="history.back()" class="error-btn-sub">
                    <i class="fa-solid fa-arrow-left"></i> Halaman Sebelumnya
                </button>
            </div>

        </div>
    </main>

    <!-- ===== STANDALONE FOOTER (statis) ===== -->
    <footer class="error-footer">
        &copy; {{ date('Y') }} Balai Pelatihan Koperasi &amp; Usaha Kecil Provinsi Kalimantan Selatan. Semua hak dilindungi.
    </footer>

    <!-- Standalone Error JS -->
    <script src="{{ asset('websites/js/error-pages.js') }}"></script>

</body>
</html>
