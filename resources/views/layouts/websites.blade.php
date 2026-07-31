<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $heroImages = [];
        $fallbackImages = [
            'https://images.unsplash.com/photo-1577495508048-b635879837f1?q=80&w=1920&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=1920&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=1920&auto=format&fit=crop',
        ];

        if (isset($heroBanners) && count($heroBanners) > 0) {
            $heroImages = $heroBanners->map(fn($b) => asset('storage/hero-banner/' . $b->gambar))->toArray();
        } else {
            $heroImages = $fallbackImages;
        }

        $siteTitle = isset($identitas)
            ? ($identitas->firstWhere('nama', 'Title Website')?->keterangan ?? 'Balai Pelatihan Koperasi & Usaha Kecil Prov. Kalsel')
            : 'Balai Pelatihan Koperasi & Usaha Kecil Prov. Kalsel';
            
        $siteDesc =
            'Website Resmi Balai Pelatihan Koperasi & Usaha Kecil Provinsi Kalimantan Selatan. Temukan informasi publik, layanan koperasi, layanan usaha kecil, dan info pelatihan.';

        $shareLogo = null;
        if (isset($identitas) && ($logoItem = $identitas->firstWhere('nama', 'Logo Website'))) {
            $shareLogo = asset('storage/header/' . $logoItem->keterangan);
        }
    @endphp

    <!-- Preload Hero Image Pertama Agar Tampil Seketika / Cepat -->
    @if(!empty($heroImages))
        <link rel="preload" as="image" href="{{ $heroImages[0] }}">
    @endif

    <title>{{ $siteTitle }}</title>

    <link rel="shortcut icon" type="image/png"
        @if (isset($identitas) && ($shortcut = $identitas->firstWhere('nama', 'Logo Shortcut'))) href="{{ asset('storage/header/' . $shortcut->keterangan) }}" @endif />
    <meta name="description" content="{{ $siteDesc }}">

    <!-- OPEN GRAPH / WHATSAPP / FACEBOOK SHARE META TAGS -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $siteTitle }}">
    <meta property="og:description" content="{{ $siteDesc }}">
    @if ($shareLogo)
        <meta property="og:image" content="{{ $shareLogo }}">
        <meta property="og:image:secure_url" content="{{ $shareLogo }}">
        <meta property="og:image:type" content="image/png">
    @endif
    <meta property="og:site_name" content="BALATKOP-UK KALSEL">

    <!-- TWITTER / X CARD META TAGS -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ $siteTitle }}">
    <meta name="twitter:description" content="{{ $siteDesc }}">
    @if ($shareLogo)
        <meta name="twitter:image" content="{{ $shareLogo }}">
    @endif

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Lora:ital,wght@0,600;0,700;1,600&family=Montserrat:wght@800;900&display=swap"
        rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tabler Icons for icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="stylesheet" href="{{ asset('websites/css/style.css') }}?v={{ time() }}">
    @stack('styles')
</head>

<body>

    <!-- Sticky Header Navigation -->
    @include('layouts.header')

    <!-- Main Dynamic Content -->
    @yield('content')

    <!-- Site Footer -->
    @include('layouts.footer')

    <script src="{{ asset('websites/js/script.js') }}"></script>
    @stack('scripts')
</body>

</html>
