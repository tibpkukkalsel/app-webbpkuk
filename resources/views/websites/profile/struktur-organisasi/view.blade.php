@extends('layouts.websites')

@section('title', 'Struktur Organisasi')

@section('content')
    <!-- PAGE BANNER / BREADCRUMB HEADER -->
    <div class="profile-page-banner"
        style="background-image: url('{{ asset('storage/profileweb/' . $tentang->firstWhere('status', 'file')?->keterangan) }}');">
        <div class="profile-banner-overlay"></div>
        <div class="profile-banner-container">
            <div class="profile-breadcrumb">
                <a href="{{ url('/') }}"><i class="fa-solid fa-house"></i> HOME</a>
                <span class="separator">/</span>
                <span class="current">STRUKTUR ORGANISASI</span>
            </div>
            <h1 class="profile-banner-title">Struktur Organisasi</h1>
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
                                <a href="{{ url('/profil/visimisi') }}" class="profile-menu-item">
                                    <span class="num">02</span>
                                    <span class="label">Visi dan Misi</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/profil/struktur-organisasi') }}" class="profile-menu-item active">
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

                <!-- Right Column: Main Content (Loaded from 'storganisasi' Database Table) -->
                <main class="profile-content-area">
                    <div class="profile-content-card">
                        <h2 class="profile-content-heading">
                            STRUKTUR ORGANISASI BALAI PELATIHAN KOPERASI DAN USAHA KECIL PROVINSI KALIMANTAN SELATAN
                        </h2>

                        <div class="profile-content-body">
                            {{-- 1. Display Diagram / Chart Image (storganisasi status == file) --}}
                            @foreach ($storganisasi->where('status', 'file') as $imgItem)
                                @if ($imgItem->keterangan)
                                    <div class="profile-image-wrap text-center mb-4">
                                        <img src="{{ asset('storage/profileweb/' . $imgItem->keterangan) }}"
                                            alt="{{ $imgItem->nama ?? 'Bagan Struktur Organisasi Balatkop Kalsel' }}"
                                            class="profile-media-img" style="max-height: 650px; object-fit: contain; width: 100%;">
                                    </div>
                                @endif
                            @endforeach

                            {{-- 2. Display Text Explanation Cards Below --}}
                            @forelse ($storganisasi->where('status', '!=', 'file') as $item)
                                <div class="profile-item-block visimisi-card">
                                    @if ($item->nama)
                                        <div class="visimisi-title-shape shape-default">
                                            <div class="visimisi-icon-box">
                                                <i class="fa-solid fa-sitemap"></i>
                                            </div>
                                            <h3 class="visimisi-shape-text">{{ strtoupper($item->nama) }}</h3>
                                        </div>
                                    @endif
                                    <div class="profile-text-paragraph visimisi-text-box">
                                        {!! nl2br(e($item->keterangan)) !!}
                                    </div>
                                </div>
                            @empty
                                <div class="profile-item-block visimisi-card">
                                    <div class="visimisi-title-shape shape-default">
                                        <div class="visimisi-icon-box"><i class="fa-solid fa-sitemap"></i></div>
                                        <h3 class="visimisi-shape-text">PENJELASAN STRUKTUR ORGANISASI</h3>
                                    </div>
                                    <p class="profile-text-paragraph visimisi-text-box">
                                        Susunan Organisasi Balai Pelatihan Koperasi dan Usaha Kecil Provinsi Kalimantan Selatan :<br>
                                        a. Sub Bagian Tata Usaha;<br>
                                        b. Seksi Pendidikan dan Pelatihan SDM Koperasi;<br>
                                        c. Seksi Pendidikan dan Pelatihan SDM Usaha Kecil; dan<br>
                                        d. Kelompok Jabatan Fungsional.
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
