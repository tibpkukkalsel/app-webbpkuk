@extends('layouts.websites')

@section('content')
    @php
        $bgBanner = $post->thumbnail
            ? asset('storage/post/thumbnail/' . $post->thumbnail)
            : ($tentang->firstWhere('status', 'file')?->keterangan
                ? asset('storage/profileweb/' . $tentang->firstWhere('status', 'file')->keterangan)
                : 'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=1920&auto=format&fit=crop');

        $jenisIcon = 'fa-solid fa-newspaper';
        if (in_array(strtolower($post->jenis ?? ''), ['tips', 'info', 'info dan tips'])) {
            $jenisIcon = 'fa-solid fa-lightbulb';
        } elseif (strtolower($post->jenis ?? '') === 'artikel') {
            $jenisIcon = 'fa-solid fa-file-pen';
        }

        $galleryList = [];
        if ($post->galeri && $post->galeri->count() > 0) {
            foreach ($post->galeri->take(8) as $index => $gal) {
                $galleryList[] = [
                    'src' => asset('storage/post/galeri/' . $gal->gambar),
                    'caption' =>
                        'Foto ' . ($index + 1) . ' dari ' . min($post->galeri->count(), 8) . ' - ' . e($post->judul),
                ];
            }
        }
    @endphp

    <!-- PAGE BANNER / BREADCRUMB HEADER (THUMBNAIL BACKGROUND) -->
    <div class="profile-page-banner banner-compact" style="background-image: url('{{ $bgBanner }}');">
        <div class="profile-banner-overlay"></div>
        <div class="profile-banner-container">
            <div class="profile-breadcrumb">
                <a href="{{ url('/') }}"><i class="fa-solid fa-house me-1"></i> BERANDA</a>
                <span class="separator">/</span>
                <a href="{{ url('/informasi') }}">INFORMASI</a>
                <span class="separator">/</span>
                <span class="current" title="{{ $post->judul }}">{{ Str::limit($post->judul, 65, '...') }}</span>
            </div>

        </div>
    </div>


    <!-- MAIN INFORMASI DETAIL & SIDEBAR SECTION -->
    <section class="informasi-detail-section">
        <div class="informasi-detail-container">
            <div class="informasi-detail-grid">

                <!-- LEFT COLUMN: MAIN POST CONTENT CARD -->
                <article class="informasi-article-card">

                    <!-- 1. JUDUL POST -->
                    <h1 class="detail-post-title">{{ $post->judul }}</h1>

                    <!-- 2. METADATA POST (TANGGAL, JENIS, KATEGORI, PENULIS, VIEWS) -->
                    <div class="detail-post-meta">
                        <!-- Tanggal Post -->
                        <div class="meta-item">
                            <i class="fa-regular fa-calendar-days text-blue me-2"></i>
                            <span>{{ $post->created_at ? $post->created_at->format('d') . ' ' . bulan_indo_full($post->created_at) . ' ' . $post->created_at->format('Y') : '-' }}</span>
                        </div>

                        <!-- Jenis -->
                        <div class="meta-item">
                            <i class="{{ $jenisIcon }} text-blue me-2"></i>
                            <span>{{ strtoupper($post->jenis ?? 'BERITA') }}</span>
                        </div>

                        <!-- Kategori -->
                        @if ($post->kategori)
                            <div class="meta-item">
                                <i class="fa-solid fa-folder-open text-blue me-2"></i>
                                <span>{{ strtoupper($post->kategori->kategori) }}</span>
                            </div>
                        @endif

                        <!-- Penulis -->
                        <div class="meta-item">
                            <i class="fa-solid fa-user-pen text-blue me-2"></i>
                            @php
                                $rawAuthor = $post->user->name ?? ($post->user->username ?? 'Admin');
                                $authorName = in_array(strtolower(trim($rawAuthor)), ['superadmin', 'super admin'])
                                    ? 'Admin'
                                    : $rawAuthor;
                            @endphp
                            <span>{{ $authorName }}</span>
                        </div>

                        <!-- View Count -->
                        <div class="meta-item ms-auto">
                            <i class="fa-regular fa-eye me-2 text-muted"></i>
                            <span class="text-muted">{{ number_format($post->view_count ?? 0, 0, ',', '.') }}x
                                dilihat</span>
                        </div>
                    </div>

                    <!-- 3. GAMBAR THUMBNAIL POST -->
                    @if ($post->thumbnail)
                        <div class="detail-featured-image-box">
                            <img src="{{ asset('storage/post/thumbnail/' . $post->thumbnail) }}" alt="{{ $post->judul }}"
                                class="detail-featured-img">
                        </div>
                    @endif

                    <!-- 4. ISI POSTINGAN -->
                    <div class="detail-post-content prose">
                        {!! $post->isi !!}
                    </div>

                    <!-- HASHTAGS BADGES (IF ANY) -->
                    @if ($post->hashtags && $post->hashtags->count() > 0)
                        <div class="detail-hashtags-wrap">
                            <span class="hashtags-label"><i class="fa-solid fa-tags me-2"></i> Tag:</span>
                            @foreach ($post->hashtags as $hTag)
                                <a href="{{ url('/informasi?q=' . urlencode($hTag->hashtag)) }}"
                                    class="news-hashtag-badge">
                                    #{{ $hTag->hashtag }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <!-- 5. POST GALERI (MAKSIMAL 8 FOTO - 2 BARIS X 4 KOLOM - INTERAKTIF DETAIL & KEYBOARD NAV) -->
                    <!-- 5. POST GALERI (SLIDER 1 BARIS DENGAN TOMBOL NAVIGASI) -->
                    @if ($post->galeri && $post->galeri->count() > 0)
                        <div class="detail-gallery-section mb-4">
                            <div class="gallery-section-header">
                                <h3 class="gallery-section-title">
                                    <i class="fa-solid fa-images text-blue me-2"></i> Galeri Foto
                                </h3>
                                <div class="gallery-header-actions">
                                    <span class="gallery-count-text">{{ $post->galeri->count() }} Foto</span>
                                    <div class="slider-nav-btns">
                                        <button type="button" class="btn-slider-nav btn-slider-prev"
                                            onclick="slideGaleriTrack('infoGaleriTrack', -1)" title="Geser Kiri">
                                            <i class="fa-solid fa-chevron-left"></i>
                                        </button>
                                        <button type="button" class="btn-slider-nav btn-slider-next"
                                            onclick="slideGaleriTrack('infoGaleriTrack', 1)" title="Geser Kanan">
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="galeri-slider-row" id="infoGaleriTrack">
                                @foreach ($post->galeri as $galIndex => $gal)
                                    @php
                                        $galImgUrl = asset('storage/post/galeri/' . $gal->gambar);
                                    @endphp
                                    <div class="gallery-photo-card" onclick="openPhotoLightboxByIndex({{ $galIndex }})"
                                        title="Klik untuk memperbesar">
                                        <img src="{{ $galImgUrl }}" alt="Foto Galeri {{ $loop->iteration }}"
                                            loading="lazy">
                                        <div class="gallery-photo-overlay">
                                            <div class="zoom-icon-box">
                                                <i class="fa-solid fa-magnifying-glass-plus"></i>
                                            </div>
                                        </div>
                                        <div class="photo-icon-badge">
                                            <i class="fa-regular fa-image"></i>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif


                    <!-- 6. TOMBOL SHARE (WHATSAPP, FB, IG, SALIN LINK) -->

                    <div class="detail-share-section">
                        <span class="share-title"><i class="fa-solid fa-share-nodes me-2 text-blue"></i> Bagikan
                            Informasi:</span>
                        <div class="share-buttons-wrap">
                            @php
                                $shareUrl = url()->current();
                                $waText = rawurlencode($post->judul . "\n" . $shareUrl);
                                $fbUrl = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($shareUrl);
                                $waUrl = 'https://api.whatsapp.com/send?text=' . $waText;
                            @endphp
                            <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                                class="btn-share share-wa" title="Bagikan ke WhatsApp">
                                <i class="fa-brands fa-whatsapp me-2"></i>
                                <span>WhatsApp</span>
                            </a>
                            <a href="{{ $fbUrl }}" target="_blank" rel="noopener noreferrer"
                                class="btn-share share-fb" title="Bagikan ke Facebook">
                                <i class="fa-brands fa-facebook-f me-2"></i>
                                <span>Facebook</span>
                            </a>
                            <button type="button" class="btn-share share-ig" id="btnShareIg"
                                onclick="shareToInstagram('{{ $shareUrl }}')" title="Bagikan ke Instagram">
                                <i class="fa-brands fa-instagram me-2"></i>
                                <span>Instagram</span>
                            </button>
                            <button type="button" class="btn-share share-copy" id="btnCopyLink"
                                onclick="copyShareLink('{{ $shareUrl }}')" title="Salin Tautan">
                                <i class="fa-solid fa-link me-2" id="copyBtnIcon"></i>
                                <span id="copyBtnText">Salin Link</span>
                            </button>
                        </div>
                    </div>

                </article>

                <!-- RIGHT COLUMN: SIDEBAR (5 INFORMASI TERBARU + TAG POPULER) -->
                <aside class="informasi-sidebar-wrap">

                    <!-- WIDGET 1: 5 INFORMASI TERBARU -->
                    <div class="sidebar-widget-card">
                        <div class="widget-header">
                            <h3 class="widget-header-title">
                                <i class="fa-solid fa-newspaper text-blue ms-1 me-3"></i>
                                <span>Informasi Terbaru</span>
                            </h3>
                        </div>
                        <div class="widget-body">
                            <div class="latest-info-list">
                                @forelse ($latestPosts as $lp)
                                    @php
                                        $lpThumb = $lp->thumbnail
                                            ? asset('storage/post/thumbnail/' . $lp->thumbnail)
                                            : null;
                                        $lpJenisIcon = 'fa-solid fa-newspaper';
                                        if (in_array(strtolower($lp->jenis ?? ''), ['tips', 'info'])) {
                                            $lpJenisIcon = 'fa-solid fa-lightbulb';
                                        } elseif (strtolower($lp->jenis ?? '') === 'artikel') {
                                            $lpJenisIcon = 'fa-solid fa-file-pen';
                                        }
                                    @endphp
                                    <a href="{{ route('website.informasi.detail', $lp->slug ?? $lp->id_post) }}"
                                        class="latest-info-item">
                                        <div class="latest-info-thumb">
                                            @if ($lpThumb)
                                                <img src="{{ $lpThumb }}" alt="{{ $lp->judul }}"
                                                    loading="lazy">
                                            @else
                                                <div class="latest-thumb-placeholder">
                                                    <i class="{{ $lpJenisIcon }}"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="latest-info-details">
                                            <span class="latest-info-meta">
                                                <i class="fa-regular fa-calendar-days me-2"></i>
                                                {{ $lp->created_at ? $lp->created_at->format('d') . ' ' . bulan_indo($lp->created_at) . ' ' . $lp->created_at->format('Y') : '-' }}
                                            </span>
                                            <h4 class="latest-info-title">{{ Str::limit($lp->judul, 50) }}</h4>
                                        </div>
                                    </a>
                                @empty
                                    <div class="sidebar-empty-text">Belum ada informasi terbaru lainnya.</div>
                                @endforelse
                            </div>
                        </div>
                        <div class="widget-footer text-center">
                            <a href="{{ url('/informasi') }}" class="btn-sidebar-more">
                                <span>Lihat Semua Informasi</span>
                                <i class="fa-solid fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>

                    <!-- WIDGET 2: POPULER TAG YANG SERING DIGUNAKAN (MAKSIMAL 6 - 2 KOLOM) -->
                    <div class="sidebar-widget-card mt-4">
                        <div class="widget-header">
                            <h3 class="widget-header-title">
                                <i class="fa-solid fa-fire text-amber ms-1 me-3"></i>
                                <span>Tag Populer</span>
                            </h3>
                        </div>
                        <div class="widget-body">



                            <div class="popular-tags-grid">
                                @forelse ($popularHashtags->take(6) as $tag)
                                    <a href="{{ url('/informasi?q=' . urlencode($tag->hashtag)) }}"
                                        class="popular-tag-item" data-tooltip="#{{ $tag->hashtag }}"
                                        title="#{{ $tag->hashtag }} ({{ $tag->posts_count }} postingan)">
                                        <span class="tag-label-wrap">
                                            <span class="tag-hash">#</span><span
                                                class="tag-name">{{ Str::limit($tag->hashtag, 12) }}</span>
                                        </span>
                                        <span class="tag-count-badge">{{ $tag->posts_count }}</span>
                                    </a>
                                @empty
                                    <div class="sidebar-empty-text">Belum ada tag populer.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                </aside>

            </div>
        </div>
    </section>

    <!-- LIGHTBOX MODAL UNTUK PREVIEW DETIL FOTO GALERI (NAVIGASI KEYBOARD PANAH KIRI & KANAN) -->
    <div class="photo-lightbox-modal" id="photoLightboxModal" aria-hidden="true">
        <div class="lightbox-backdrop" onclick="closePhotoLightbox()"></div>
        <div class="lightbox-dialog">
            <button type="button" class="lightbox-close-btn" onclick="closePhotoLightbox()" title="Tutup Modal (ESC)">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <!-- Navigation Buttons (Prev & Next) -->
            <button type="button" class="lightbox-nav-btn lightbox-prev-btn" onclick="prevPhotoLightbox()"
                title="Foto Sebelumnya (Panah Kiri)">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button type="button" class="lightbox-nav-btn lightbox-next-btn" onclick="nextPhotoLightbox()"
                title="Foto Selanjutnya (Panah Kanan)">
                <i class="fa-solid fa-chevron-right"></i>
            </button>

            <div class="lightbox-body">
                <img src="" id="lightboxImg" alt="Detail Foto" class="lightbox-image">
                <div class="lightbox-footer-info">
                    <div class="lightbox-caption" id="lightboxCaption"></div>
                    <div class="lightbox-counter" id="lightboxCounter"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- TOAST NOTIFICATION COPY LINK -->
    <div class="toast-copy-notify" id="toastCopyNotify">
        <i class="fa-solid fa-circle-check text-green me-2"></i>
        <span>Tautan berhasil disalin ke papan klip!</span>
    </div>
@endsection

@push('scripts')
    <script>
        function slideGaleriTrack(trackId, direction) {
            const track = document.getElementById(trackId);
            if (!track) return;
            const scrollAmount = track.clientWidth * 0.75;
            track.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });
        }

        const galleryItems = @json($galleryList);
        let currentGalleryIndex = 0;

        // Lightbox Functions for Gallery Photos
        function openPhotoLightboxByIndex(index) {
            if (!galleryItems || galleryItems.length === 0) return;
            currentGalleryIndex = index;
            updateLightboxContent();

            const modal = document.getElementById('photoLightboxModal');
            if (modal) {
                modal.classList.add('is-active');
                document.body.style.overflow = 'hidden';
            }
        }

        function updateLightboxContent() {
            const img = document.getElementById('lightboxImg');
            const caption = document.getElementById('lightboxCaption');
            const counter = document.getElementById('lightboxCounter');

            if (galleryItems[currentGalleryIndex]) {
                const item = galleryItems[currentGalleryIndex];
                if (img) img.src = item.src;
                if (caption) caption.textContent = item.caption;
                if (counter) counter.textContent = (currentGalleryIndex + 1) + ' / ' + galleryItems.length;
            }
        }

        function prevPhotoLightbox() {
            if (!galleryItems || galleryItems.length === 0) return;
            currentGalleryIndex = (currentGalleryIndex - 1 + galleryItems.length) % galleryItems.length;
            updateLightboxContent();
        }

        function nextPhotoLightbox() {
            if (!galleryItems || galleryItems.length === 0) return;
            currentGalleryIndex = (currentGalleryIndex + 1) % galleryItems.length;
            updateLightboxContent();
        }

        function closePhotoLightbox() {
            const modal = document.getElementById('photoLightboxModal');
            if (modal) {
                modal.classList.remove('is-active');
                document.body.style.overflow = '';
            }
        }

        // Close Lightbox on ESC Key & Arrow Left / Arrow Right Keyboard Navigation
        document.addEventListener('keydown', function(e) {
            const modal = document.getElementById('photoLightboxModal');
            if (modal && modal.classList.contains('is-active')) {
                if (e.key === 'ArrowLeft') {
                    prevPhotoLightbox();
                } else if (e.key === 'ArrowRight') {
                    nextPhotoLightbox();
                } else if (e.key === 'Escape') {
                    closePhotoLightbox();
                }
            }
        });

        // Copy Share Link to Clipboard
        function copyShareLink(url) {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(url).then(showCopyToast).catch(() => fallbackCopyText(url));
            } else {
                fallbackCopyText(url);
            }
        }

        function fallbackCopyText(text) {
            const textArea = document.createElement("textarea");
            textArea.value = text;
            textArea.style.position = "fixed";
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            try {
                document.execCommand('copy');
                showCopyToast();
            } catch (err) {
                console.error('Gagal menyalin tautan:', err);
            }
            document.body.removeChild(textArea);
        }

        function showCopyToast() {
            const toast = document.getElementById('toastCopyNotify');
            const copyBtnText = document.getElementById('copyBtnText');
            const copyBtnIcon = document.getElementById('copyBtnIcon');

            if (copyBtnText && copyBtnIcon) {
                copyBtnText.textContent = 'Tersalin!';
                copyBtnIcon.className = 'fa-solid fa-check text-green me-2';
                setTimeout(() => {
                    copyBtnText.textContent = 'Salin Link';
                    copyBtnIcon.className = 'fa-solid fa-link me-2';
                }, 3000);
            }

            if (toast) {
                toast.classList.add('show');
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 3000);
            }
        }

        // Share to Instagram Handler
        function shareToInstagram(url) {
            copyShareLink(url);
            alert(
                'Tautan halaman telah disalin ke papan klip!\nSilakan buka aplikasi Instagram Anda untuk membagikan tautan ini.'
            );
        }
    </script>
@endpush
