@extends('layouts.websites')

@section('title', 'Dashboard Diklat - Balatkop-uk Prov. Kalsel')

@section('content')
    <!-- DEDICATED GIS DIKLAT & LEAFLET CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="{{ asset('websites/css/gis-diklat.css') }}?v={{ time() }}">

    <!-- PAGE BANNER / BREADCRUMB HEADER -->
    <div class="profile-page-banner"
        style="background-image: url('{{ asset('storage/profileweb/' . $tentang->firstWhere('status', 'file')?->keterangan) }}');">
        <div class="profile-banner-overlay"></div>
        <div class="profile-banner-container">
            <div class="profile-breadcrumb">
                <a href="{{ url('/') }}"><i class="fa-solid fa-house"></i> BERANDA</a>
                <span class="separator">/</span>
                <a href="#">LAYANAN</a>
                <span class="separator">/</span>
                <span class="current">DASHBOARD DIKLAT</span>
            </div>
            <h1 class="profile-banner-title">
                Dashboard Pendidikan dan Pelatihan
            </h1>
        </div>
    </div>

    <!-- MAIN DASHBOARD CONTAINER -->
    <section class="gis-main-section py-5">
        <div class="container">
            <livewire:website.diklat.dashboard />
        </div>
    </section>

    <!-- LEAFLET MAP JS & DEDICATED GIS SCRIPT -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="{{ asset('websites/js/kalsel-geojson.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('websites/js/gis-diklat.js') }}?v={{ time() }}"></script>
@endsection
