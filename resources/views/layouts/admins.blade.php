<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    @livewireStyles
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="shortcut icon" type="image/png" href="{{ asset('admins/images/logos/favicon.png') }}" />

    <link rel="stylesheet" href="{{ asset('admins/css/styles.css') }}" />

    <title>Cp Balatkop-uk Prov. Kalsel</title>
    <link rel="stylesheet" href="{{ asset('admins/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" />
    {{-- Sweetalert 2 --}}
    <link rel="stylesheet" href="{{ asset('admins/libs/sweetalert2/dist/sweetalert2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admins/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}" />
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admins/libs/magnific-popup/dist/magnific-popup.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
</head>

<body>
    <div class="preloader">
        <img src="{{ asset('admins/images/logos/pre.png') }}" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <div id="main-wrapper">
        <aside class="left-sidebar with-vertical">
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="#" class="text-nowrap logo-img">
                        <img src="{{ asset('admins/images/logos/dark_logo.png') }}" class="dark-logo" alt="Logo-Dark" />
                        <img src="{{ asset('admins/images/logos/light_logo.png') }}" class="light-logo"
                            alt="Logo-light" />
                    </a>
                    <a href="javascript:void(0)"
                        class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
                        <i class="ti ti-x"></i>
                    </a>
                </div>

                <nav class="sidebar-nav scroll-sidebar" data-simplebar>
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Home</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="#" id="get-url" aria-expanded="false">
                                <span>
                                    <i class="ti ti-dashboard"></i>
                                </span>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>

                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Master Data</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->routeIs('identitas*') ? 'active' : '' }}"
                                href="{{ route('identitas.view') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-id-badge"></i>
                                </span>
                                <span class="hide-menu">Identitas</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->routeIs('kategori*') ? 'active' : '' }}"
                                href="{{ route('kategori.view') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-category"></i>
                                </span>
                                <span class="hide-menu">Kategori</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->routeIs('hashtag*') ? 'active' : '' }}"
                                href="{{ route('hashtag.view') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-hash"></i>
                                </span>
                                <span class="hide-menu">Hashtag</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow {{ request()->routeIs('seksi*', 'jabatan*', 'pegawai*') ? 'active' : '' }}"
                                href="javascript:void(0)" aria-expanded="false">
                                <span class="d-flex">
                                    <i class="ti ti-user-check"></i>
                                </span>
                                <span class="hide-menu">Data Pegawai</span>
                            </a>
                            <ul aria-expanded="false"
                                class="collapse first-level {{ request()->routeIs('seksi*', 'jabatan*', 'pegawai*') ? 'in' : '' }}">
                                <li class="sidebar-item">
                                    <a class="sidebar-link {{ request()->routeIs('seksi*') ? 'active' : '' }}"
                                        href="{{ route('seksi.view') }}" aria-expanded="false">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Seksi</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link {{ request()->routeIs('jabatan*') ? 'active' : '' }}"
                                        href="{{ route('jabatan.view') }}" aria-expanded="false">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Jabatan</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link {{ request()->routeIs('pegawai*') ? 'active' : '' }}"
                                        href="{{ route('pegawai.view') }}" aria-expanded="false">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Pegawai</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('pengguna.view') }}"
                                class="sidebar-link {{ request()->routeIs('pengguna*') ? 'active' : '' }}">
                                <span>
                                    <i class="ti ti-users"></i>
                                </span>
                                <span class="hide-menu">Pengguna</span>
                            </a>
                        </li>
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Master Page</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <span class="d-flex">
                                    <i class="ti ti-home"></i>
                                </span>
                                <span class="hide-menu">Beranda</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    <a class="sidebar-link {{ request()->routeIs('hero-banner*') ? 'active' : '' }}"
                                        href="{{ route('hero-banner.view') }}" aria-expanded="false">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-photo"></i>
                                        </div>
                                        <span class="hide-menu">Hero Banner</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link {{ request()->routeIs('infografis*') ? 'active' : '' }}"
                                        href="{{ route('infografis.view') }}" aria-expanded="false">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Info Grafis</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link {{ request()->routeIs('mitra*') ? 'active' : '' }}"
                                        href="{{ route('mitra.view') }}" aria-expanded="false">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Link Terkait</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link {{ request()->routeIs('tajuktentang*') ? 'active' : '' }}"
                                        href="{{ route('tajuktentang.view') }}" aria-expanded="false">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Tajuk Tentang</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link {{ request()->routeIs('tajukcard*') ? 'active' : '' }}"
                                        href="{{ route('tajukcard.view') }}" aria-expanded="false">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Tajuk Card</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link {{ request()->routeIs('kalimattajuk*') ? 'active' : '' }}"
                                        href="{{ route('kalimattajuk.view') }}" aria-expanded="false">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Kalimat Tajuk</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->routeIs('footer*') ? 'active' : '' }}"
                                href="{{ route('footer.view') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-layout-sidebar"></i>
                                </span>
                                <span class="hide-menu">Footer</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->routeIs('agenda*') ? 'active' : '' }}"
                                href="{{ route('agenda.view') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-calendar"></i>
                                </span>
                                <span class="hide-menu">Agenda</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <span class="d-flex">
                                    <i class="ti ti-building"></i>
                                </span>
                                <span class="hide-menu">Profile</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    <a class="sidebar-link {{ request()->routeIs('tentang*') ? 'active' : '' }}"
                                        href="{{ route('tentang.view') }}" aria-expanded="false">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Tentang</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link {{ request()->routeIs('visimisi*') ? 'active' : '' }}"
                                        href="{{ route('visimisi.view') }}" aria-expanded="false">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Visi dan Misi</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link {{ request()->routeIs('storganisasi*') ? 'active' : '' }}"
                                        href="{{ route('storganisasi.view') }}" aria-expanded="false">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Struktur Organisasi</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Layanan</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow {{ request()->routeIs('layanan*') ? 'active' : '' }}"
                                href="javascript:void(0)" aria-expanded="false">
                                <span>
                                    <i class="ti ti-map-2"></i>
                                </span>
                                <span class="hide-menu">Dashboard Diklat</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level {{ request()->routeIs('layanan*') ? 'in' : '' }}">
                                <li class="sidebar-item">
                                    <a class="sidebar-link {{ request()->routeIs('layanan*') && request()->get('tab', 'wilayah') === 'wilayah' ? 'active' : '' }}"
                                        href="{{ route('layanan.view', ['tab' => 'wilayah']) }}" aria-expanded="false">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Data Wilayah Kalsel</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link {{ request()->get('tab') === 'jenis_diklat' ? 'active' : '' }}"
                                        href="{{ route('layanan.view', ['tab' => 'jenis_diklat']) }}" aria-expanded="false">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Jenis Diklat SDM</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link {{ request()->get('tab') === 'identifikasi' ? 'active' : '' }}"
                                        href="{{ route('layanan.view', ['tab' => 'identifikasi']) }}" aria-expanded="false">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Identifikasi Kebutuhan</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link {{ request()->get('tab') === 'target' ? 'active' : '' }}"
                                        href="{{ route('layanan.view', ['tab' => 'target']) }}" aria-expanded="false">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Target Diklat</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link {{ request()->get('tab') === 'realisasi' ? 'active' : '' }}"
                                        href="{{ route('layanan.view', ['tab' => 'realisasi']) }}" aria-expanded="false">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Realisasi Diklat</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow {{ request()->routeIs('fasilitas*') ? 'active' : '' }}"
                                href="javascript:void(0)" aria-expanded="false">
                                <span>
                                    <i class="ti ti-building"></i>
                                </span>
                                <span class="hide-menu">Fasilitas</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level {{ request()->routeIs('fasilitas*') ? 'in' : '' }}">
                                <li class="sidebar-item">
                                    <a class="sidebar-link {{ request()->routeIs('fasilitas.view') ? 'active' : '' }}"
                                        href="{{ route('fasilitas.view') }}" aria-expanded="false">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Data Fasilitas</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link {{ request()->routeIs('fasilitas.halaman*') ? 'active' : '' }}" href="{{ route('fasilitas.halaman.view') }}" aria-expanded="false">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Kelola Halaman</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link {{ request()->routeIs('fasilitas.pemesan*') ? 'active' : '' }}" href="{{ route('fasilitas.pemesan.view') }}" aria-expanded="false">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Data Pemesan</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link {{ request()->routeIs('fasilitas.riwayat*') ? 'active' : '' }}" href="{{ route('fasilitas.riwayat.view') }}" aria-expanded="false">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle"></i>
                                        </div>
                                        <span class="hide-menu">Riwayat</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->routeIs('produk-umkm*') ? 'active' : '' }}"
                                href="{{ route('produk-umkm.view') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-shopping-cart"></i>
                                </span>
                                <span class="hide-menu">Produk UMKM</span>
                            </a>
                        </li>
                        @can('kontak.view')
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->routeIs('kontak*') ? 'active' : '' }}"
                                href="{{ route('kontak.view') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-mail-opened"></i>
                                </span>
                                <span class="hide-menu">Kontak & Helpdesk</span>
                            </a>
                        </li>
                        @endcan
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Page</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->routeIs('berita*') ? 'active' : '' }}"
                                href="{{ route('berita.view') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-article"></i>
                                </span>
                                <span class="hide-menu">Berita</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->routeIs('artikel*') ? 'active' : '' }}"
                                href="{{ route('artikel.view') }}" aria-expanded="false">
                                <span class="d-flex">
                                    <i class="ti ti-file-text"></i>
                                </span>
                                <span class="hide-menu">Artikel</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->routeIs('info*') ? 'active' : '' }}"
                                href="{{ route('info.view') }}" aria-expanded="false">
                                <span class="d-flex">
                                    <i class="ti ti-bulb"></i>
                                </span>
                                <span class="hide-menu">Info dan Tips</span>
                            </a>
                        </li>
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Media</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link {{ request()->routeIs('video*') ? 'active' : '' }}"
                                href="{{ route('video.view') }}" aria-expanded="false">
                                <span class="d-flex">
                                    <i class="ti ti-video"></i>
                                </span>
                                <span class="hide-menu">Video</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <div class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded mt-3">
                    <div class="hstack gap-3">
                        <div class="john-title">
                            <h6 class="mb-0 fs-2 fw-semibold">Control Panel Balatkop-uk</h6>
                            <span class="fs-2">Copyright © 2026 BPKUK Kalsel</span>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
        <div class="page-wrapper">
            <header class="topbar">
                <div class="with-vertical">
                    <nav class="navbar navbar-expand-lg p-0">
                        <ul class="navbar-nav">
                            <li class="nav-item nav-icon-hover-bg rounded-circle ms-n2">
                                <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                                    <i class="ti ti-menu-2"></i>
                                </a>
                            </li>
                        </ul>

                        <div class="d-block d-lg-none py-4">
                            <a href="#" class="text-nowrap logo-img">
                                <img src="{{ asset('admins/images/logos/dark_logo.png') }}" class="dark-logo"
                                    alt="Logo-Dark" />
                                <img src="{{ asset('admins/images/logos/light_logo.png') }}" class="light-logo"
                                    alt="Logo-light" />
                            </a>
                        </div>
                        <a class="navbar-toggler nav-icon-hover-bg rounded-circle p-0 mx-0 border-0"
                            href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="ti ti-dots fs-7"></i>
                        </a>
                        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                            <div class="d-flex align-items-center justify-content-between">
                                <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                                    <li class="nav-item nav-icon-hover-bg rounded-circle">
                                        <a class="nav-link moon dark-layout" href="javascript:void(0)">
                                            <i class="ti ti-moon moon"></i>
                                        </a>
                                        <a class="nav-link sun light-layout" href="javascript:void(0)">
                                            <i class="ti ti-sun sun"></i>
                                        </a>
                                    </li>

                                    <li class="nav-item nav-icon-hover-bg rounded-circle dropdown">
                                        <a class="nav-link position-relative" href="javascript:void(0)"
                                            id="drop2" aria-expanded="false">
                                            <i class="ti ti-bell-ringing"></i>
                                            <div class="notification bg-primary rounded-circle"></div>
                                        </a>
                                        <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                            aria-labelledby="drop2">
                                            <div class="d-flex align-items-center justify-content-between py-3 px-7">
                                                <h5 class="mb-0 fs-5 fw-semibold">Notifications</h5>
                                                <span class="badge text-bg-primary rounded-4 px-3 py-1 lh-sm">5
                                                    new</span>
                                            </div>
                                            <div class="message-body" data-simplebar>
                                                <a href="javascript:void(0)"
                                                    class="py-6 px-7 d-flex align-items-center dropdown-item">
                                                    <span class="me-3">
                                                        <img src="{{ asset('admins/images/profile/user-2.jpg') }}"
                                                            alt="user" class="rounded-circle" width="48"
                                                            height="48" />
                                                    </span>
                                                    <div class="w-100">
                                                        <h6 class="mb-1 fw-semibold lh-base">Roman Joined the Team!
                                                        </h6>
                                                        <span class="fs-2 d-block text-body-secondary">Congratulate
                                                            him</span>
                                                    </div>
                                                </a>
                                                <a href="javascript:void(0)"
                                                    class="py-6 px-7 d-flex align-items-center dropdown-item">
                                                    <span class="me-3">
                                                        <img src="{{ asset('admins/images/profile/user-3.jpg') }}"
                                                            alt="user" class="rounded-circle" width="48"
                                                            height="48" />
                                                    </span>
                                                    <div class="w-100">
                                                        <h6 class="mb-1 fw-semibold lh-base">New message</h6>
                                                        <span class="fs-2 d-block text-body-secondary">Salma sent you
                                                            new message</span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="py-6 px-7 mb-1">
                                                <button class="btn btn-outline-primary w-100">See All
                                                    Notifications</button>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="nav-item dropdown">
                                        <a class="nav-link pe-0" href="javascript:void(0)" id="drop1"
                                            aria-expanded="false">
                                            <div class="d-flex align-items-center">
                                                <div class="user-profile-img">
                                                    <img src="{{ asset('admins/images/profile/user-1.jpg') }}"
                                                        class="rounded-circle" width="35" height="35"
                                                        alt="modernize-img" />
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                            aria-labelledby="drop1">
                                            <div class="profile-dropdown position-relative" data-simplebar>
                                                <div class="py-3 px-7 pb-0">
                                                    <h5 class="mb-0 fs-5 fw-semibold">Admin Profile</h5>
                                                </div>
                                                <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                                    <img src="{{ asset('admins/images/profile/user-1.jpg') }}"
                                                        class="rounded-circle" width="80" height="80"
                                                        alt="modernize-img" />
                                                    <div class="ms-3">
                                                        <h5 class="mb-1 fs-3">Asfar Rian</h5>
                                                        <span class="mb-1 d-block">Admin</span>
                                                        <p class="mb-0 d-flex align-items-center gap-2">
                                                            <i class="ti ti-mail fs-4"></i> sahrulasfarianoor@gmail.com
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="d-grid py-4 px-7 pt-8">
                                                    <form method="POST" action="{{ route('logout') }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-primary w-100">
                                                            Keluar
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </header>
            <div class="body-wrapper">
                <div class="container-fluid">
                    <x-alert />
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <div class="dark-transparent sidebartoggler"></div>
    <script src="{{ asset('admins/js/vendor.min.js') }}"></script>
    <script src="{{ asset('admins/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admins/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('admins/js/theme/app.init.js') }}"></script>
    <script src="{{ asset('admins/js/theme/theme.js') }}"></script>
    <script src="{{ asset('admins/js/theme/sidebarmenu.js') }}"></script>
    <script src="{{ asset('admins/js/theme/app.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <script src="{{ asset('admins/libs/owl.carousel/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('admins/libs/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('admins/js/forms/sweet-alert.init.js') }}"></script>
    <script src="{{ asset('admins/libs/magnific-popup/dist/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('admins/js/plugins/meg.init.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>

    <script>
        function handleColorTheme(e) {
            document.documentElement.setAttribute("data-color-theme", e);
        }
        document.addEventListener('DOMContentLoaded', function() {

            const activeMenu = document.querySelector('.sidebar-link.active');

            if (activeMenu) {
                activeMenu.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }

        });
    </script>
    <script>
        document.addEventListener('livewire:init', () => {

            Livewire.on('swal', (event) => {

                Swal.fire({
                    icon: event.icon,
                    title: event.title,
                    text: event.text,
                    timer: 2000,
                    showConfirmButton: false
                });

            });

        });
    </script>

    @stack('myscript')

    @livewireScripts
</body>

</html>
