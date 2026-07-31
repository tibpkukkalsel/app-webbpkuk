@extends('layouts.websites')

@section('content')
    @php
        $bgBanner = $post->thumbnail
            ? asset('storage/post/thumbnail/' . $post->thumbnail)
            : ($tentang->firstWhere('status', 'file')?->keterangan
                ? asset('storage/profileweb/' . $tentang->firstWhere('status', 'file')->keterangan)
                : 'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=1920&auto=format&fit=crop');

        $allPhotos = [];

        // Add Thumbnail as Photo 1 if available
        if ($post->thumbnail) {
            $allPhotos[] = [
                'src' => asset('storage/post/thumbnail/' . $post->thumbnail),
                'caption' => 'Foto Utama - ' . e($post->judul),
            ];
        }

        // Add post_galeri photos
        if ($post->galeri && $post->galeri->count() > 0) {
            foreach ($post->galeri as $index => $gal) {
                $allPhotos[] = [
                    'src' => asset('storage/post/galeri/' . $gal->gambar),
                    'caption' => 'Foto ' . ($index + 1) . ' - ' . e($post->judul),
                ];
            }
        }

        $galleryList = $allPhotos;
    @endphp

    <!-- PAGE BANNER / BREADCRUMB HEADER -->
    <div class="profile-page-banner banner-compact" style="background-image: url('{{ $bgBanner }}');">
        <div class="profile-banner-overlay"></div>
        <div class="profile-banner-container">
            <div class="profile-breadcrumb">
                <a href="{{ url('/') }}"><i class="fa-solid fa-house me-1"></i> BERANDA</a>
                <span class="separator">/</span>
                <a href="{{ url('/galeri') }}">GALERI FOTO</a>
                <span class="separator">/</span>
                <span class="current" title="{{ $post->judul }}">{{ Str::limit($post->judul, 65, '...') }}</span>
            </div>
        </div>
    </div>

    <!-- MAIN GALERI DETAIL & SIDEBAR SECTION -->
    <section class="informasi-detail-section">
        <div class="informasi-detail-container">
            <div class="informasi-detail-grid">

                <!-- LEFT COLUMN: MAIN GALERI CONTENT CARD -->
                <article class="informasi-article-card">

                    <!-- 1. JUDUL GALERI -->
                    <h1 class="detail-post-title">{{ $post->judul }}</h1>

                    <!-- 2. METADATA POST -->
                    <div class="detail-post-meta">
                        <!-- Tanggal Post -->
                        <div class="meta-item">
                            <i class="fa-regular fa-calendar-days text-blue me-2"></i>
                            <span>{{ $post->created_at ? $post->created_at->format('d') . ' ' . bulan_indo_full($post->created_at) . ' ' . $post->created_at->format('Y') : '-' }}</span>
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

                        <!-- Total Foto Badge -->
                        <div class="meta-item">
                            <i class="fa-solid fa-images text-blue me-2"></i>
                            <span>{{ count($allPhotos) }} Foto Galeri</span>
                        </div>

                        <!-- View Count -->
                        <div class="meta-item ms-auto">
                            <i class="fa-regular fa-eye me-2 text-muted"></i>
                            <span class="text-muted">{{ number_format($post->view_count ?? 0, 0, ',', '.') }}x dilihat</span>
                        </div>
                    </div>

                    <!-- 3. TERSUSUN RAPI FOTO GALERI (4 KOLOM GRID SEPERTI CONTOH GAMBAR) -->
                    @if (count($allPhotos) > 0)
                        <div class="galeri-photos-wrapper mb-4">
                            <div class="galeri-photos-grid">
                                @foreach ($allPhotos as $index => $photo)
                                    <div class="galeri-photo-card" onclick="openPhotoLightboxByIndex({{ $index }})" title="Klik untuk memperbesar">
                                        <img src="{{ $photo['src'] }}" alt="{{ $photo['caption'] }}" loading="lazy">
                                        <div class="galeri-photo-overlay">
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
                    @else
                        <div class="alert alert-info rounded-16 p-4 text-center">
                            <i class="fa-solid fa-images fa-2x mb-2 text-blue"></i>
                            <p class="mb-0 font-weight-bold">Belum ada foto galeri untuk postingan ini.</p>
                        </div>
                    @endif



                    <!-- 5. HASHTAGS BADGES (IF ANY) -->
                    @if ($post->hashtags && $post->hashtags->count() > 0)
                        <div class="detail-hashtags-wrap mt-4">
                            <span class="hashtags-label"><i class="fa-solid fa-tags me-2"></i> Tag:</span>
                            @foreach ($post->hashtags as $hTag)
                                <a href="{{ url('/informasi?q=' . urlencode($hTag->hashtag)) }}"
                                    class="news-hashtag-badge">
                                    #{{ $hTag->hashtag }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <!-- 6. TOMBOL SHARE -->
                    <div class="detail-share-section mt-4">
                        <span class="share-title"><i class="fa-solid fa-share-nodes me-2 text-blue"></i> Bagikan Galeri:</span>
                        <div class="share-buttons-wrap">
                            @php
                                $shareUrl = url()->current();
                                $waText = rawurlencode('Galeri Foto: ' . $post->judul . "\n" . $shareUrl);
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

                <!-- RIGHT COLUMN: SIDEBAR -->
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
                                                <img src="{{ $lpThumb }}" alt="{{ $lp->judul }}" loading="lazy">
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
                                    <div class="sidebar-empty-text">Belum ada informasi terbaru.</div>
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

                    <!-- WIDGET 2: TAG POPULER -->
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

    <!-- LIGHTBOX PREVIEW MODAL -->
    <div class="photo-lightbox-modal" id="photoLightboxModal" aria-hidden="true">
        <div class="lightbox-backdrop" onclick="closePhotoLightbox()"></div>
        <div class="lightbox-dialog">
            <!-- Close Button -->
            <button type="button" class="lightbox-close-btn" onclick="closePhotoLightbox()" title="Tutup (ESC)">
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

            <!-- Image & Caption Body -->
            <div class="lightbox-body">
                <img src="" alt="Preview Foto" id="lightboxActiveImg" class="lightbox-image">
                <div class="lightbox-footer-info">
                    <span class="lightbox-caption" id="lightboxActiveCaption"></span>
                    <span class="lightbox-counter" id="lightboxActiveCounter">1 / 1</span>
                </div>
            </div>
        </div>
    </div>

    <!-- TOAST NOTIFICATION -->
    <div class="toast-copy-notify" id="toastCopyNotify">
        <i class="fa-solid fa-circle-check text-emerald me-2"></i>
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
        let currentPhotoIndex = 0;

        function openPhotoLightboxByIndex(index) {
            if (!galleryItems || galleryItems.length === 0) return;
            currentPhotoIndex = index;
            updateLightboxContent();

            const modal = document.getElementById('photoLightboxModal');
            if (modal) {
                modal.classList.add('is-active');
                document.body.style.overflow = 'hidden';
            }
        }

        function updateLightboxContent() {
            if (!galleryItems || galleryItems.length === 0) return;

            if (currentPhotoIndex < 0) currentPhotoIndex = galleryItems.length - 1;
            if (currentPhotoIndex >= galleryItems.length) currentPhotoIndex = 0;

            const item = galleryItems[currentPhotoIndex];
            const imgEl = document.getElementById('lightboxActiveImg');
            const captionEl = document.getElementById('lightboxActiveCaption');
            const counterEl = document.getElementById('lightboxActiveCounter');

            if (imgEl && item) {
                imgEl.style.opacity = '0.4';
                imgEl.src = item.src;
                imgEl.onload = function() {
                    imgEl.style.opacity = '1';
                };
            }
            if (captionEl && item) {
                captionEl.textContent = item.caption || '';
            }
            if (counterEl) {
                counterEl.textContent = (currentPhotoIndex + 1) + ' / ' + galleryItems.length;
            }
        }

        function prevPhotoLightbox() {
            currentPhotoIndex--;
            updateLightboxContent();
        }

        function nextPhotoLightbox() {
            currentPhotoIndex++;
            updateLightboxContent();
        }

        function closePhotoLightbox() {
            const modal = document.getElementById('photoLightboxModal');
            if (modal) {
                modal.classList.remove('is-active');
                document.body.style.overflow = '';
            }
        }

        // Keyboard Navigation (Panah Kiri, Panah Kanan, ESC)
        document.addEventListener('keydown', function(event) {
            const modal = document.getElementById('photoLightboxModal');
            if (!modal || !modal.classList.contains('is-active')) return;

            if (event.key === 'ArrowLeft') {
                prevPhotoLightbox();
            } else if (event.key === 'ArrowRight') {
                nextPhotoLightbox();
            } else if (event.key === 'Escape') {
                closePhotoLightbox();
            }
        });

        // Copy Share Link Toast
        function copyShareLink(url) {
            navigator.clipboard.writeText(url).then(function() {
                const toast = document.getElementById('toastCopyNotify');
                const btnText = document.getElementById('copyBtnText');
                const btnIcon = document.getElementById('copyBtnIcon');

                if (btnText) btnText.textContent = 'Tersalin!';
                if (btnIcon) btnIcon.className = 'fa-solid fa-check me-2 text-emerald';

                if (toast) {
                    toast.classList.add('show');
                    setTimeout(() => {
                        toast.classList.remove('show');
                        if (btnText) btnText.textContent = 'Salin Link';
                        if (btnIcon) btnIcon.className = 'fa-solid fa-link me-2';
                    }, 2500);
                }
            });
        }

        function shareToInstagram(url) {
            copyShareLink(url);
            window.open('https://www.instagram.com', '_blank');
        }
    </script>
@endpush
