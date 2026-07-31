@extends('layouts.websites')

@section('title', 'Profil Tentang')

@section('content')
    <!-- PAGE BANNER / BREADCRUMB HEADER -->
    <div class="profile-page-banner"
        style="background-image: url('{{ asset('storage/profileweb/' . $tentang->firstWhere('status', 'file')?->keterangan) }}');">
        <div class="profile-banner-overlay"></div>
        <div class="profile-banner-container">
            <div class="profile-breadcrumb">
                <a href="{{ url('/') }}"><i class="fa-solid fa-house"></i> HOME</a>
                <span class="separator">/</span>
                <span class="current">TENTANG</span>
            </div>
            <h1 class="profile-banner-title">Tentang</h1>
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
                                <a href="{{ url('/profil/tentang') }}" class="profile-menu-item active">
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

                <!-- Right Column: Main Content (Loaded from 'tentang' Database Table) -->
                <main class="profile-content-area">
                    <div class="profile-content-card">
                        <h2 class="profile-content-heading">
                            TENTANG BALAI PELATIHAN KOPERASI DAN USAHA KECIL PROVINSI KALIMANTAN SELATAN
                        </h2>

                        <div class="profile-content-body">
                            @forelse ($tentang as $item)
                                <div class="profile-item-block">
                                    @if ($item->status == 'file')
                                        @if ($item->keterangan)
                                            <div class="profile-image-wrap">
                                                <img src="{{ asset('storage/profileweb/' . $item->keterangan) }}"
                                                    alt="{{ $item->nama ?? 'Gambar Profil Balatkop' }}"
                                                    class="profile-media-img">
                                            </div>
                                        @endif
                                    @else
                                        @if ($item->nama && !in_array(strtolower($item->nama), ['tentang', 'profil', 'deskripsi']))
                                            <h3 class="profile-subheading">{{ $item->nama }}</h3>
                                        @endif
                                        <div class="profile-text-paragraph">
                                            {!! nl2br(e($item->keterangan)) !!}
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="profile-item-block">
                                    <p class="profile-text-paragraph">
                                        Balai Pelatihan Koperasi dan Usaha Kecil Provinsi Kalimantan Selatan merupakan unit
                                        pelaksana teknis (UPT) di lingkungan Dinas Koperasi dan Usaha Kecil Menengah
                                        Provinsi Kalimantan Selatan yang bertugas menyelenggarakan pelatihan teknis,
                                        manajerial, serta kewirausahaan bagi sumber daya manusia Koperasi dan Usaha Kecil
                                        Menengah di seluruh wilayah Provinsi Kalimantan Selatan.
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
