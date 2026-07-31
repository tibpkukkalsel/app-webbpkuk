@extends('layouts.websites')

@section('title', 'Visi & Misi')

@section('content')
    <!-- PAGE BANNER / BREADCRUMB HEADER -->
    <div class="profile-page-banner"
        style="background-image: url('{{ asset('storage/profileweb/' . $tentang->firstWhere('status', 'file')?->keterangan) }}');">
        <div class="profile-banner-overlay"></div>
        <div class="profile-banner-container">
            <div class="profile-breadcrumb">
                <a href="{{ url('/') }}"><i class="fa-solid fa-house"></i> HOME</a>
                <span class="separator">/</span>
                <span class="current">VISI DAN MISI</span>
            </div>
            <h1 class="profile-banner-title">Visi dan Misi</h1>
        </div>
    </div>

    <!-- MAIN PROFILE CONTENT (2 COLUMN SIDEBAR + CONTENT) -->
    <section class="profile-main-section">
        <div class="profile-container">
            <div class="profile-grid">

                <!-- Left Column: Sidebar Menu (Submenu Profil) -->
                <aside class="profile-sidebar">
                    <div class="profile-sidebar-card">
                        <!-- Mobile Minimalist Toggle Button -->
                        <button type="button" class="profile-sidebar-toggle" id="profileSidebarToggle">
                            <span class="toggle-text">Menu Profil</span>
                            <i class="fa-solid fa-bars toggle-icon"></i>
                        </button>

                        <ul class="profile-menu-list" id="profileMenuList">
                            <li>
                                <a href="{{ url('/profil/tentang') }}" class="profile-menu-item">
                                    <span class="num">01</span>
                                    <span class="label">Tentang</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/profil/visimisi') }}" class="profile-menu-item active">
                                    <span class="num">02</span>
                                    <span class="label">Visi dan Misi</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/profil/struktur-organisasi') }}" class="profile-menu-item">
                                    <span class="num">03</span>
                                    <span class="label">Struktur Organisasi</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/profil/pegawai') }}" class="profile-menu-item">
                                    <span class="num">04</span>
                                    <span class="label">Pegawai</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </aside>

                <!-- Right Column: Main Content (Loaded from 'visimisi' Database Table) -->
                <main class="profile-content-area">
                    <div class="profile-content-card">
                        <h2 class="profile-content-heading">
                            VISI DAN MISI GUBERNUR DAN WAKIL GUBERNUR KALIMANTAN SELATAN
                        </h2>

                        <div class="profile-content-body">
                            {{-- 1. Display Photo (Governor & Vice Governor) at the Top --}}
                            @foreach ($visimisi->where('status', 'file') as $imgItem)
                                @if ($imgItem->keterangan)
                                    <div class="profile-image-wrap text-center mb-4">
                                        <img src="{{ asset('storage/profileweb/' . $imgItem->keterangan) }}"
                                            alt="{{ $imgItem->nama ?? 'Foto Gubernur dan Wakil Gubernur Kalimantan Selatan' }}"
                                            class="profile-media-img" style="max-height: 420px; object-fit: contain;">
                                    </div>
                                @endif
                            @endforeach

                            {{-- 2. Display Visi, Misi, and Sinergi Text Cards Below --}}
                            @forelse ($visimisi->where('status', '!=', 'file') as $item)
                                @php
                                    $namaLower = strtolower($item->nama ?? '');
                                    $isVisi = str_contains($namaLower, 'visi');
                                    $isMisi = str_contains($namaLower, 'misi') && !$isVisi;
                                    $isSinergi = str_contains($namaLower, 'sinergi');

                                    if ($isVisi) {
                                        $iconClass = 'fa-solid fa-eye';
                                        $shapeClass = 'shape-visi';
                                    } elseif ($isMisi) {
                                        $iconClass = 'fa-solid fa-list-check';
                                        $shapeClass = 'shape-misi';
                                    } elseif ($isSinergi) {
                                        $iconClass = 'fa-solid fa-handshake-angle';
                                        $shapeClass = 'shape-sinergi';
                                    } else {
                                        $iconClass = 'fa-solid fa-bookmark';
                                        $shapeClass = 'shape-default';
                                    }
                                @endphp

                                <div class="profile-item-block visimisi-card">
                                    @if ($item->nama)
                                        <div class="visimisi-title-shape {{ $shapeClass }}">
                                            <div class="visimisi-icon-box">
                                                <i class="{{ $iconClass }}"></i>
                                            </div>
                                            <h3 class="visimisi-shape-text">{{ strtoupper($item->nama) }}</h3>
                                        </div>
                                    @endif
                                    <div class="profile-text-paragraph visimisi-text-box">
                                        {!! $item->keterangan !!}
                                    </div>
                                </div>
                            @empty
                                <div class="profile-item-block visimisi-card">
                                    <div class="visimisi-title-shape shape-visi">
                                        <div class="visimisi-icon-box"><i class="fa-solid fa-eye"></i></div>
                                        <h3 class="visimisi-shape-text">VISI</h3>
                                    </div>
                                    <p class="profile-text-paragraph visimisi-text-box">
                                        Mewujudkan Sumber Daya Manusia Koperasi dan Usaha Kecil Menengah Provinsi Kalimantan
                                        Selatan yang Berkualitas, Mandiri, Berdaya Saing, dan Berbasis Teknologi.
                                    </p>
                                </div>
                                <div class="profile-item-block visimisi-card">
                                    <div class="visimisi-title-shape shape-misi">
                                        <div class="visimisi-icon-box"><i class="fa-solid fa-list-check"></i></div>
                                        <h3 class="visimisi-shape-text">MISI</h3>
                                    </div>
                                    <p class="profile-text-paragraph visimisi-text-box">
                                        1. Membangun Sumber Daya Manusia yang Berkualitas dan Berbudi Pekerti Luhur;<br>
                                        2. Mendorong Pertumbuhan Ekonomi yang Merata;<br>
                                        3. Memperkuat Sarana Prasarana Dasar dan Perekonomian;<br>
                                        4. Tata Kelola Pemerintahan yang Lebih Fokus Pada Pelayanan Publik;<br>
                                        5. Menjaga Kelestarian Lingkungan Hidup dan Memperkuat Ketahanan Bencana.
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </main>

            </div>
        </div>
    </section>
@endsection
