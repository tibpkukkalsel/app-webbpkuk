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

        $siteName = 'BALATKOP-UK PROV. KALSEL';
        $siteBrand = 'Balatkop-UK Prov. Kalsel';
        $siteNameFull = isset($identitas)
            ? ($identitas->firstWhere('nama', 'Title Website')?->keterangan ?? 'Balai Pelatihan Koperasi & Usaha Kecil Prov. Kalsel')
            : 'Balai Pelatihan Koperasi & Usaha Kecil Prov. Kalsel';
            
        $defaultDesc =
            'Website Resmi Balai Pelatihan Koperasi & Usaha Kecil Provinsi Kalimantan Selatan. Temukan informasi publik, layanan koperasi, layanan usaha kecil, dan info pelatihan.';

        $defaultLogo = null;
        if (isset($identitas) && ($logoItem = $identitas->firstWhere('nama', 'Logo Website'))) {
            $defaultLogo = asset('storage/header/' . $logoItem->keterangan);
        }

        // Professional Frontend Page Title Generator
        $yieldTitle = trim($__env->yieldContent('title'));

        if (!empty($yieldTitle) && $yieldTitle !== 'Beranda') {
            $metaTitle = $yieldTitle . ' | ' . $siteBrand;
        } elseif (isset($post) && !empty($post->judul)) {
            $metaTitle = $post->judul . ' | ' . $siteBrand;
        } elseif (isset($agenda) && !empty($agenda->nama)) {
            $metaTitle = $agenda->nama . ' - Agenda Kegiatan | ' . $siteBrand;
        } else {
            $metaTitle = 'Website Resmi ' . $siteNameFull;
        }

        // Dynamic Meta Description & Image
        if (isset($post)) {
            $rawSummary = !empty(trim($post->ringkasan ?? ''))
                ? $post->ringkasan
                : (!empty(trim($post->isi ?? ''))
                    ? $post->isi
                    : $post->judul);
            
            $datePrefix = $post->created_at ? $post->created_at->format('d/m/Y') . ' - ' : '';
            $metaDesc = $datePrefix . Str::limit(strip_tags($rawSummary), 150);

            if (!empty($post->thumbnail)) {
                $metaImage = asset('storage/post/thumbnail/' . $post->thumbnail);
            } elseif ($post->galeri && $post->galeri->first()?->gambar) {
                $metaImage = asset('storage/post/galeri/' . $post->galeri->first()->gambar);
            } else {
                $metaImage = $defaultLogo;
            }
        } elseif (isset($agenda)) {
            $metaDesc = Str::limit(strip_tags($agenda->deskripsi ?? $agenda->nama), 150);
            $metaImage = $defaultLogo;
        } else {
            $metaDesc = $defaultDesc;
            $metaImage = $defaultLogo;
        }
    @endphp

    <!-- Preload Hero Image Pertama Agar Tampil Seketika / Cepat -->
    @if(!empty($heroImages))
        <link rel="preload" as="image" href="{{ $heroImages[0] }}">
    @endif

    <title>{!! $metaTitle !!}</title>

    <link rel="shortcut icon" type="image/png"
        @if (isset($identitas) && ($shortcut = $identitas->firstWhere('nama', 'Logo Shortcut'))) href="{{ asset('storage/header/' . $shortcut->keterangan) }}" @endif />
    <meta name="description" content="{{ $metaDesc }}">

    <!-- OPEN GRAPH / WHATSAPP / FACEBOOK SHARE META TAGS -->
    <meta property="og:type" content="{{ isset($post) ? 'article' : 'website' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDesc }}">
    @if ($metaImage)
        <meta property="og:image" content="{{ $metaImage }}">
        <meta property="og:image:secure_url" content="{{ $metaImage }}">
    @endif
    <meta property="og:site_name" content="{{ $siteName }}">
    @if (isset($post) && $post->created_at)
        <meta property="article:published_time" content="{{ $post->created_at->toIso8601String() }}">
    @endif

    <!-- TWITTER / X CARD META TAGS -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDesc }}">
    @if ($metaImage)
        <meta name="twitter:image" content="{{ $metaImage }}">
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
