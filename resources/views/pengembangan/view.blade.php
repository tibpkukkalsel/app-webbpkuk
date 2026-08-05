@extends('layouts.websites')

@section('title', 'Halaman Sedang Dalam Pembaruan - Balatkop-UK Prov. Kalsel')

@section('content')
    <!-- DEDICATED PENGEMBANGAN CSS -->
    <link rel="stylesheet" href="{{ asset('websites/css/pengembangan.css') }}?v={{ time() }}">

    <div class="uc-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">
                    <div class="uc-content-center">

                        <!-- 1. Top Badges Bar -->
                        <div class="uc-top-badge-bar">
                            <span class="uc-badge-yellow">
                                <span
                                    style="width: 8px; height: 8px; background: #fbbf24; border-radius: 50%; display: inline-block;"></span>
                                System Update
                            </span>
                            <span class="uc-badge-sub">&bull; PEMBARUAN SISTEM &amp; DATA RESMI</span>
                        </div>

                        <!-- 2. Main Title (Teks Umum) -->
                        <h1 class="uc-heading">
                            Halaman Ini<br>
                            <span>Sedang Dalam Pembaruan.</span>
                        </h1>

                        <!-- 3. Main Description (Teks Umum) -->
                        <p class="uc-description">
                            Kami sedang memperbarui dan menyelaraskan data pada halaman ini agar informasi yang disajikan selalu akurat, mutakhir, dan resmi — sesuai dengan standar pelayanan publik Balai Pelatihan Koperasi dan Usaha Kecil Prov. Kalsel.
                        </p>

                        <!-- 4. Action Buttons (Teks Umum) -->
                        <div class="uc-btn-group">
                            <a href="{{ url('/') }}" class="uc-btn-primary">
                                <i class="fa-solid fa-house"></i> Kembali ke Beranda
                            </a>
                            <button onclick="history.back()" class="uc-btn-secondary">
                                <i class="fa-solid fa-arrow-left"></i> Halaman Sebelumnya
                            </button>
                        </div>

                        <!-- 5. Footer Tagline -->
                        <div class="mb-4"
                            style="font-size: 0.82rem; font-family: 'JetBrains Mono', monospace; color: #64748b;">
                            // Kebanggaan kami bisa melayani dengan baik &bull; Balatkop-UK Prov. Kalsel
                        </div>
                        <br>

                        <!-- 6. Terminal Card & Live Countdown Grid -->
                        <div class="uc-terminal-card">
                            <div class="uc-terminal-header">
                                <div class="uc-window-dots">
                                    <span class="uc-dot red"></span>
                                    <span class="uc-dot yellow"></span>
                                    <span class="uc-dot green"></span>
                                </div>
                                <div class="uc-terminal-title">balatkopuk@build:~</div>
                                <div class="uc-terminal-title">zsh</div>
                            </div>
                            <div class="uc-terminal-body">
                                <div><span class="uc-cmd-prompt">$</span> php artisan system:build</div>
                                <div><span class="uc-cmd-success">&check;</span> assets compiled [inter, jetbrains-mono]
                                </div>
                                <div><span class="uc-cmd-success">&check;</span> pages: [modules, views, components] &mdash;
                                    0.82s</div>
                                <div><span class="uc-cmd-success">&check;</span> security check: auth &amp; ssl passed</div>
                                <div><span class="uc-cmd-prompt">$</span> deploying to <span
                                        style="color: #38bdf8;">balatkopuk.kalselprov.go.id</span> ...</div>

                                <div class="uc-progress-wrap">
                                    <div class="uc-progress-header">
                                        <span>BUILD PROGRESS</span>
                                        <span style="color: #38bdf8;">30%</span>
                                    </div>
                                    <div class="uc-progress-bar-bg">
                                        <div class="uc-progress-bar-fill"></div>
                                    </div>
                                </div>

                                <!-- Live Countdown Grid -->
                                <div class="uc-timer-grid">
                                    <div class="uc-timer-box">
                                        <div class="uc-timer-num" id="uc-days">40</div>
                                        <div class="uc-timer-label">HARI</div>
                                    </div>
                                    <div class="uc-timer-box">
                                        <div class="uc-timer-num" id="uc-hours">08</div>
                                        <div class="uc-timer-label">JAM</div>
                                    </div>
                                    <div class="uc-timer-box">
                                        <div class="uc-timer-num" id="uc-minutes">42</div>
                                        <div class="uc-timer-label">MENIT</div>
                                    </div>
                                    <div class="uc-timer-box">
                                        <div class="uc-timer-num" id="uc-seconds">15</div>
                                        <div class="uc-timer-label">DETIK</div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DEDICATED PENGEMBANGAN JS -->
    <script src="{{ asset('websites/js/pengembangan.js') }}?v={{ time() }}"></script>
@endsection
