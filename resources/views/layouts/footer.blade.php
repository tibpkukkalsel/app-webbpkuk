<!-- FOOTER SECTION -->
<footer class="site-footer">
    <div class="footer-container">

        <!-- Main 4-Column Grid -->
        <div class="footer-grid">

            <!-- Col 1: Logos, Deskripsi & Google Maps Box -->
            <div class="footer-col col-tentang">
                <div class="footer-brand-logos">
                    @php
                        $logoPemprov = isset($identitas)
                            ? $identitas->firstWhere('nama', 'Logo Website 1') ??
                                ($identitas->firstWhere('nama', 'Logo Pemprov') ??
                                    $identitas->firstWhere('nama', 'Logo Website'))
                            : null;
                        $logoBalatkop = isset($identitas)
                            ? $identitas->firstWhere('nama', 'Logo Balatkop Primary') ??
                                $identitas->firstWhere('nama', 'Logo Balatkop Sec')
                            : null;
                    @endphp
                    @if ($logoPemprov)
                        <img src="{{ asset('storage/header/' . $logoPemprov->keterangan) }}" alt="Logo Pemprov Kalsel"
                            class="footer-brand-img emblem">
                    @endif
                    @if ($logoBalatkop)
                        <img src="{{ asset('storage/header/' . $logoBalatkop->keterangan) }}" alt="Logo Balatkop Kalsel"
                            class="footer-brand-img balatkop">
                    @endif
                    <div class="footer-brand-text">
                        <span class="brand-dinas">Dinas Koperasi & UKM</span>
                        <span class="brand-balai">Balai Pelatihan Koperasi dan Usaha Kecil</span>
                        <span class="brand-prov">Provinsi Kalimantan Selatan</span>
                    </div>
                </div>

                <!-- Mobile Mottos (3 Side-by-side above Alamat Card) -->
                @php
                    $mottos = isset($footer) ? $footer->where('jenis', 'Motto') : collect();
                @endphp
                @if ($mottos->count() > 0)
                    <div class="footer-mottos-mobile">
                        @foreach ($mottos as $motto)
                            @if ($motto->keterangan)
                                @if ($motto->link)
                                    <a href="{{ $motto->link }}" target="_blank" rel="noopener noreferrer" class="motto-mobile-item">
                                        <img src="{{ asset('storage/footer/' . $motto->keterangan) }}" alt="{{ $motto->nama ?? 'Motto' }}" class="motto-mobile-img">
                                    </a>
                                @else
                                    <div class="motto-mobile-item">
                                        <img src="{{ asset('storage/footer/' . $motto->keterangan) }}" alt="{{ $motto->nama ?? 'Motto' }}" class="motto-mobile-img">
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                @endif

                <!-- Google Maps Card Box -->
                @php
                    $alamat = isset($identitas) ? $identitas->firstWhere('nama', 'Alamat') : null;
                @endphp
                <a href="{{ $alamat?->link ?? '#' }}"
                    @if ($alamat?->link) target="_blank" rel="noopener noreferrer" @endif
                    class="maps-card">
                    <div class="maps-icon-box">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div class="maps-info">
                        <h4 class="maps-title">Alamat</h4>
                        <span
                            class="maps-address">{{ $alamat?->keterangan ?? 'Jl. Ahmad Yani KM. 18.200 Kec. Liang Anggang Kota Banjarbaru' }}</span>
                    </div>
                </a>

                <!-- Email & Social Media Section -->
                @php
                    $emailItem = isset($identitas) ? $identitas->firstWhere('nama', 'Email') : null;
                    $emailAddr = $emailItem?->keterangan ?? 'web.balatkopuk@gmail.com';
                    $emailLink = $emailItem?->link ?: 'mailto:' . $emailAddr;

                    $instaItem = isset($identitas) ? ($identitas->firstWhere('nama', 'Instagram') ?? $identitas->firstWhere('nama', 'instagram')) : null;
                    $instaLink = $instaItem?->link ?: 'https://www.instagram.com/balatkop.provkalsel/';

                    $ytItem = isset($identitas) ? ($identitas->firstWhere('nama', 'Youtube') ?? $identitas->firstWhere('nama', 'YouTube') ?? $identitas->firstWhere('nama', 'youtube')) : null;
                    $ytLink = $ytItem?->link ?: 'https://www.youtube.com';
                @endphp
                <div class="footer-contacts-inline">
                    <a href="{{ $emailLink }}" class="footer-email-link" title="Kirim Email">
                        <span class="social-icon-btn email">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <span class="email-text">{{ $emailAddr }}</span>
                    </a>
                    <a href="{{ $instaLink }}" target="_blank" rel="noopener noreferrer" class="social-icon-btn instagram" title="Instagram">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="{{ $ytLink }}" target="_blank" rel="noopener noreferrer" class="social-icon-btn youtube" title="YouTube">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                </div>
            </div>

            <!-- Col 2: Profil -->
            <div class="footer-col col-profil">
                <h3 class="footer-heading">Profil</h3>
                <ul class="footer-links">
                    <li><a href="#">Tentang</a></li>
                    <li><a href="#">Visi dan Misi</a></li>
                    <li><a href="#">Struktur Organisasi</a></li>
                    <li><a href="#">Fasilitas</a></li>
                </ul>
            </div>

            <!-- Col 3: Layanan -->
            <div class="footer-col col-layanan">
                <h3 class="footer-heading">Layanan</h3>
                <ul class="footer-links">
                    <li><a href="{{ url('/layanan/dashboard-diklat') }}">Dashboard Diklat</a></li>
                    <li><a href="{{ url('/layanan/pemanfaatan-fasilitas') }}">Pemanfaatan Fasilitas</a></li>
                    <li><a href="https://pusatlayanankemasankalsel.com/" target="_blank">Layanan Kemasan</a></li>
                    <li><a href="{{ url('/layanan/identifikasi-kebutuhan-diklat') }}">Identifikasi Kebutuhan Pelatihan</a></li>
                    <li><a href="{{ url('/layanan/sertifikat-elektronik') }}">Sertifikat Elektronik</a></li>
                    <li><a href="{{ url('/layanan/survei-kepuasan-diklat') }}">Survei Kepuasan Diklat</a></li>
                </ul>
            </div>

            <!-- Col 4: Informasi -->
            <div class="footer-col col-informasi">
                <h3 class="footer-heading">Informasi</h3>
                <ul class="footer-links">
                    <li><a href="{{ url('/informasi?jenis=Berita') }}">Berita</a></li>
                    <li><a href="{{ url('/informasi?jenis=Artikel') }}">Artikel</a></li>
                    <li><a href="{{ url('/informasi?jenis=Tips') }}">Info dan Tips</a></li>
                    <li><a href="{{ url('/informasi') }}">Semua Informasi</a></li>
                </ul>
            </div>

            <!-- Col 5: Motto (From Footer Table) -->
            <div class="footer-col col-badges">
                @php
                    $mottos = isset($footer) ? $footer->where('jenis', 'Motto') : collect();
                @endphp
                @foreach ($mottos as $motto)
                    @if ($motto->keterangan)
                        @if ($motto->link)
                            <a href="{{ $motto->link }}" target="_blank" rel="noopener noreferrer" class="motto-link">
                                <img src="{{ asset('storage/footer/' . $motto->keterangan) }}" alt="{{ $motto->nama ?? 'Motto' }}" class="motto-img">
                            </a>
                        @else
                            <img src="{{ asset('storage/footer/' . $motto->keterangan) }}" alt="{{ $motto->nama ?? 'Motto' }}" class="motto-img">
                        @endif
                    @endif
                @endforeach
            </div>

        </div>

        <!-- Footer Bottom Line & Copyright -->
        <div class="footer-bottom-bar">
            <div class="copyright-text">
                @php
                    $footer_tahun = isset($footer) ? $footer->firstWhere('nama', 'Tahun Dibuat') : null;
                    $footer_pembuat = isset($footer) ? $footer->firstWhere('nama', 'Nama Pembuat') : null;
                @endphp
                Copyright &copy; <span class="year-purple">{{ $footer_tahun?->keterangan ?? '' }}</span>
                by {{ $footer_pembuat?->keterangan ?? '' }}
            </div>
        </div>

    </div>
</footer>
