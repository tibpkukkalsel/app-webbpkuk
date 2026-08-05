document.addEventListener('DOMContentLoaded', () => {
    
    // =========================================================
    // 0. HERO BACKGROUND SLIDER (FADE IN, ZOOM IN, FADE OUT)
    // =========================================================
    const heroBgSlides = document.querySelectorAll('.hero-bg-slide');
    if (heroBgSlides.length > 1) {
        let currentHeroIndex = 0;
        const totalHeroSlides = heroBgSlides.length;
        const displayDuration = 6500;

        setInterval(() => {
            const prevSlide = heroBgSlides[currentHeroIndex];
            currentHeroIndex = (currentHeroIndex + 1) % totalHeroSlides;
            const nextSlide = heroBgSlides[currentHeroIndex];

            prevSlide.classList.remove('active');
            prevSlide.classList.add('exiting');

            nextSlide.classList.remove('exiting');
            nextSlide.classList.add('active');

            setTimeout(() => {
                prevSlide.classList.remove('exiting');
            }, 1800);
        }, displayDuration);
    }

    // =========================================================
    // 1. STICKY HEADER SCROLL EVENT (WHITE HEADER ON SCROLL)
    // =========================================================
    const header = document.getElementById('mainHeader');
    const scrollThreshold = 500;
    let stickyTimeout = null;

    const handleScroll = () => {
        const currentScroll = window.scrollY;

        if (currentScroll > scrollThreshold) {
            if (stickyTimeout) {
                clearTimeout(stickyTimeout);
                stickyTimeout = null;
            }
            header.classList.add('sticky');
            requestAnimationFrame(() => {
                if (window.scrollY > scrollThreshold) {
                    header.classList.add('scrolled');
                }
            });
        } else {
            // Remove 'scrolled' first to trigger slide up exit animation
            header.classList.remove('scrolled');

            if (currentScroll <= 100) {
                // At the top of hero section, reset immediately to absolute top: 0
                if (stickyTimeout) {
                    clearTimeout(stickyTimeout);
                    stickyTimeout = null;
                }
                header.classList.remove('sticky');
            } else if (header.classList.contains('sticky')) {
                // In transition zone (100px - 500px), wait for slide up animation (350ms) before removing 'sticky'
                if (!stickyTimeout) {
                    stickyTimeout = setTimeout(() => {
                        if (window.scrollY <= scrollThreshold) {
                            header.classList.remove('sticky');
                        }
                        stickyTimeout = null;
                    }, 350);
                }
            }
        }
    };

    let isTicking = false;
    const onScroll = () => {
        if (!isTicking) {
            requestAnimationFrame(() => {
                handleScroll();
                isTicking = false;
            });
            isTicking = true;
        }
    };

    window.addEventListener('scroll', onScroll, { passive: true });
    handleScroll();

    // =========================================================
    // 2. MOBILE NAVIGATION TOGGLE
    // =========================================================
    const mobileToggle = document.querySelector('.mobile-toggle');
    const navMenu = document.querySelector('.nav-menu');

    if (mobileToggle && navMenu) {
        mobileToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            const icon = mobileToggle.querySelector('i');
            if (navMenu.classList.contains('active')) {
                icon.className = 'fa-solid fa-xmark';
            } else {
                icon.className = 'fa-solid fa-bars';
            }
        });
    }

    // =========================================================
    // 3. HASHTAG SEARCH AUTO-FILL & FORM SUBMISSION
    // =========================================================
    const tagPills = document.querySelectorAll('.tag-pill');
    const searchInput = document.getElementById('searchInput');

    tagPills.forEach(pill => {
        pill.addEventListener('click', (e) => {
            e.preventDefault();
            const tagText = pill.textContent.replace('#', '').trim();
            if (searchInput) {
                searchInput.value = tagText;
                const searchForm = document.getElementById('searchForm');
                if (searchForm) {
                    searchForm.submit();
                } else {
                    window.location.href = `/informasi?q=${encodeURIComponent(tagText)}`;
                }
            }
        });
    });

    const searchForm = document.getElementById('searchForm');
    if (searchForm) {
        searchForm.addEventListener('submit', (e) => {
            const query = searchInput ? searchInput.value.trim() : '';
            if (!query) {
                e.preventDefault();
                if (searchInput) searchInput.focus();
            }
            // Allow form submit to /informasi?q=KEYWORD
        });
    }

    // =========================================================
    // 4. AUTOMATIC IMAGE CAROUSEL / SLIDER LOGIC
    // =========================================================
    const sliderTrack = document.getElementById('sliderTrack');
    const slides = document.querySelectorAll('.slide-item');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const dotsContainer = document.getElementById('sliderDots');
    const sliderCarousel = document.getElementById('autoSlider');

    if (sliderTrack && slides.length > 0) {
        let currentIndex = 0;
        const totalSlides = slides.length;
        let slideInterval;

        dotsContainer.innerHTML = '';
        slides.forEach((_, index) => {
            const dot = document.createElement('div');
            dot.classList.add('dot');
            if (index === 0) dot.classList.add('active');
            dot.addEventListener('click', () => goToSlide(index));
            dotsContainer.appendChild(dot);
        });

        const dots = document.querySelectorAll('.dot');

        function updateSlider() {
            sliderTrack.style.transform = `translateX(-${currentIndex * 100}%)`;
            dots.forEach((dot, idx) => {
                if (idx === currentIndex) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
        }

        function goToSlide(index) {
            currentIndex = index;
            if (currentIndex < 0) currentIndex = totalSlides - 1;
            if (currentIndex >= totalSlides) currentIndex = 0;
            updateSlider();
        }

        function nextSlide() {
            goToSlide(currentIndex + 1);
        }

        function prevSlide() {
            goToSlide(currentIndex - 1);
        }

        if (nextBtn) nextBtn.addEventListener('click', nextSlide);
        if (prevBtn) prevBtn.addEventListener('click', prevSlide);

        function startAutoSlide() {
            slideInterval = setInterval(nextSlide, 4500);
        }

        function stopAutoSlide() {
            clearInterval(slideInterval);
        }

        startAutoSlide();

        if (sliderCarousel) {
            sliderCarousel.addEventListener('mouseenter', stopAutoSlide);
            sliderCarousel.addEventListener('mouseleave', startAutoSlide);
        }
    }

    // =========================================================
    // 5. PUSAT INFORMASI / NEWS TABS FILTERING
    // =========================================================
    const tabBtns = document.querySelectorAll('.news-tab-btn');
    const tabPanes = document.querySelectorAll('.tab-content-pane');

    if (tabBtns.length > 0) {
        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const targetTab = btn.getAttribute('data-tab');

                tabBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                tabPanes.forEach(pane => {
                    if (pane.id === `tab-${targetTab}`) {
                        pane.style.display = 'block';
                        pane.style.opacity = '0';
                        pane.style.transform = 'translateY(8px)';
                        setTimeout(() => {
                            pane.style.opacity = '1';
                            pane.style.transform = 'translateY(0)';
                            pane.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                        }, 50);
                    } else {
                        pane.style.display = 'none';
                    }
                });
            });
        });
    }

    // =========================================================
    // 6. AGENDA KEGIATAN CAROUSEL CONTROLS
    // =========================================================
    const agendaTrack = document.getElementById('agendaTrack');
    const agendaPrevBtn = document.getElementById('agendaPrevBtn');
    const agendaNextBtn = document.getElementById('agendaNextBtn');
    const agendaCards = document.querySelectorAll('.agenda-card');

    if (agendaTrack && agendaCards.length > 0) {
        let agendaIndex = 0;
        
        function getAgendaCardsPerView() {
            if (window.innerWidth <= 768) return 1;
            if (window.innerWidth <= 1024) return 2;
            return 3;
        }

        function updateAgendaSlider() {
            const cardsPerView = getAgendaCardsPerView();
            const maxIndex = Math.max(0, agendaCards.length - cardsPerView);
            if (agendaIndex > maxIndex) agendaIndex = maxIndex;
            if (agendaIndex < 0) agendaIndex = 0;

            const cardWidth = agendaCards[0].offsetWidth + 24;
            agendaTrack.style.transform = `translateX(-${agendaIndex * cardWidth}px)`;
        }

        if (agendaNextBtn) {
            agendaNextBtn.addEventListener('click', () => {
                const cardsPerView = getAgendaCardsPerView();
                const maxIndex = Math.max(0, agendaCards.length - cardsPerView);
                if (agendaIndex < maxIndex) {
                    agendaIndex++;
                } else {
                    agendaIndex = 0;
                }
                updateAgendaSlider();
            });
        }

        if (agendaPrevBtn) {
            agendaPrevBtn.addEventListener('click', () => {
                const cardsPerView = getAgendaCardsPerView();
                const maxIndex = Math.max(0, agendaCards.length - cardsPerView);
                if (agendaIndex > 0) {
                    agendaIndex--;
                } else {
                    agendaIndex = maxIndex;
                }
                updateAgendaSlider();
            });
        }

        window.addEventListener('resize', updateAgendaSlider);
    }

    // =========================================================
    // 7. PRODUK UNGGULAN CAROUSEL CONTROLS
    // =========================================================
    const productsTrack = document.getElementById('productsTrack');
    const prodPrevBtn = document.getElementById('prodPrevBtn');
    const prodNextBtn = document.getElementById('prodNextBtn');
    const productCards = document.querySelectorAll('.product-card');

    if (productsTrack && productCards.length > 0) {
        let productIndex = 0;

        function getProdCardsPerView() {
            if (window.innerWidth <= 768) return 1;
            if (window.innerWidth <= 1024) return 2;
            return 3;
        }

        function updateProductSlider() {
            const cardsPerView = getProdCardsPerView();
            const maxIndex = Math.max(0, productCards.length - cardsPerView);
            if (productIndex > maxIndex) productIndex = maxIndex;
            if (productIndex < 0) productIndex = 0;

            const cardWidth = productCards[0].offsetWidth + 24;
            productsTrack.style.transform = `translateX(-${productIndex * cardWidth}px)`;
        }

        if (prodNextBtn) {
            prodNextBtn.addEventListener('click', () => {
                const cardsPerView = getProdCardsPerView();
                const maxIndex = Math.max(0, productCards.length - cardsPerView);
                if (productIndex < maxIndex) {
                    productIndex++;
                } else {
                    productIndex = 0;
                }
                updateProductSlider();
            });
        }

        if (prodPrevBtn) {
            prodPrevBtn.addEventListener('click', () => {
                const cardsPerView = getProdCardsPerView();
                const maxIndex = Math.max(0, productCards.length - cardsPerView);
                if (productIndex > 0) {
                    productIndex--;
                } else {
                    productIndex = maxIndex;
                }
                updateProductSlider();
            });
        }

        window.addEventListener('resize', updateProductSlider);
    }

    // =========================================================
    // 8. MOBILE BOTTOM NAVIGATION & SUB-MENU SHEETS LOGIC
    // =========================================================
    const mobileSheetButtons = document.querySelectorAll('.mobile-nav-item[data-sheet]');
    const mobileSheets = document.querySelectorAll('.mobile-bottom-sheet');
    const sheetBackdrop = document.getElementById('mobileSheetBackdrop');
    const sheetCloseBtns = document.querySelectorAll('.sheet-close-btn');

    function closeAllSheets() {
        mobileSheets.forEach(sheet => sheet.classList.remove('active'));
        if (sheetBackdrop) sheetBackdrop.classList.remove('active');
        mobileSheetButtons.forEach(btn => btn.classList.remove('active'));
    }

    mobileSheetButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const targetSheetId = btn.getAttribute('data-sheet');
            const targetSheet = document.getElementById(targetSheetId);

            if (targetSheet) {
                if (targetSheet.classList.contains('active')) {
                    closeAllSheets();
                } else {
                    closeAllSheets();
                    targetSheet.classList.add('active');
                    if (sheetBackdrop) sheetBackdrop.classList.add('active');
                    btn.classList.add('active');
                }
            }
        });
    });

    sheetCloseBtns.forEach(btn => {
        btn.addEventListener('click', closeAllSheets);
    });

    if (sheetBackdrop) {
        sheetBackdrop.addEventListener('click', closeAllSheets);
    }

    // =========================================================
    // 9. INTERACTIVE SCROLL & PAGE LOAD REVEAL ANIMATIONS
    // =========================================================
    const revealTargets = [
        { selector: '.welcome-badge', animation: 'reveal-fade-up' },
        { selector: '.hero-title', animation: 'reveal-fade-up', delay: 'delay-1' },
        { selector: '.hero-subtitle', animation: 'reveal-fade-up', delay: 'delay-2' },
        { selector: '.search-box-wrapper', animation: 'reveal-fade-up', delay: 'delay-3' },
        { selector: '.action-card', animation: 'reveal-zoom-in', stagger: true },
        { selector: '.slider-section', animation: 'reveal-fade-up' },
        { selector: '.news-header', animation: 'reveal-fade-up' },
        { selector: '.news-card', animation: 'reveal-fade-up', stagger: true },
        { selector: '.agenda-section', animation: 'reveal-fade-up' },
        { selector: '.about-overview-left', animation: 'reveal-fade-left' },
        { selector: '.about-overview-right', animation: 'reveal-fade-right' },
        { selector: '.products-section', animation: 'reveal-fade-up' },
        { selector: '.related-links-section', animation: 'reveal-fade-up' }
    ];

    revealTargets.forEach(target => {
        const elements = document.querySelectorAll(target.selector);
        elements.forEach((el, idx) => {
            el.classList.add(target.animation);
            if (target.delay) {
                el.classList.add(target.delay);
            }
            if (target.stagger) {
                const delayClass = `delay-${(idx % 4) + 1}`;
                el.classList.add(delayClass);
            }
        });
    });

    if ('IntersectionObserver' in window) {
        const revealObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-revealed');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.08,
            rootMargin: '0px 0px -20px 0px'
        });

        document.querySelectorAll('.reveal-fade-up, .reveal-fade-left, .reveal-fade-right, .reveal-zoom-in').forEach(el => {
            revealObserver.observe(el);
        });
    } else {
        // Fallback for older browsers
        document.querySelectorAll('.reveal-fade-up, .reveal-fade-left, .reveal-fade-right, .reveal-zoom-in').forEach(el => {
            el.classList.add('is-revealed');
        });
    }

    // =========================================================
    // 10. MOBILE PROFILE SIDEBAR MINIMALIST MENU TOGGLE
    // =========================================================
    const profileSidebarToggle = document.getElementById('profileSidebarToggle');
    const profileMenuList = document.getElementById('profileMenuList');

    if (profileSidebarToggle && profileMenuList) {
        profileSidebarToggle.addEventListener('click', () => {
            profileMenuList.classList.toggle('is-open');
            const icon = profileSidebarToggle.querySelector('.toggle-icon');
            if (profileMenuList.classList.contains('is-open')) {
                icon.className = 'fa-solid fa-xmark toggle-icon';
            } else {
                icon.className = 'fa-solid fa-bars toggle-icon';
            }
        });
    }

    // =========================================================
    // 11. INFORMASI PAGE FILTER MODAL DIALOG TOGGLE
    // =========================================================
    const informasiFilterToggle = document.getElementById('informasiFilterToggle');
    const informasiFilterModal = document.getElementById('informasiFilterModal');
    const filterModalClose = document.getElementById('filterModalClose');
    const filterModalBackdrop = document.getElementById('filterModalBackdrop');
    const filterModalApply = document.getElementById('filterModalApply');

    const openFilterModal = () => {
        if (informasiFilterModal) {
            informasiFilterModal.classList.add('is-active');
            informasiFilterModal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }
    };

    const closeFilterModal = () => {
        if (informasiFilterModal) {
            informasiFilterModal.classList.remove('is-active');
            informasiFilterModal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }
    };

    if (informasiFilterToggle) {
        informasiFilterToggle.addEventListener('click', openFilterModal);
    }
    if (filterModalClose) {
        filterModalClose.addEventListener('click', closeFilterModal);
    }
    if (filterModalBackdrop) {
        filterModalBackdrop.addEventListener('click', closeFilterModal);
    }
    if (filterModalApply) {
        filterModalApply.addEventListener('click', closeFilterModal);
    }

    // Filter Pills Selection Handler (Deferred submit until Cari & Terapkan)
    const filterJenisInput = document.getElementById('filterJenisInput');
    const filterKategoriInput = document.getElementById('filterKategoriInput');

    const jenisPillsGroup = document.getElementById('jenisPillsGroup');
    if (jenisPillsGroup && filterJenisInput) {
        const jenisBtns = jenisPillsGroup.querySelectorAll('.filter-pill-btn');
        jenisBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                jenisBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                filterJenisInput.value = btn.getAttribute('data-val') || '';
            });
        });
    }

    const kategoriPillsGroup = document.getElementById('kategoriPillsGroup');
    if (kategoriPillsGroup && filterKategoriInput) {
        const katBtns = kategoriPillsGroup.querySelectorAll('.filter-pill-btn');
        katBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                katBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                filterKategoriInput.value = btn.getAttribute('data-val') || '';
            });
        });
    }

    // Clear Search Input Button (Clear text without reloading)
    const clearSearchInputBtn = document.getElementById('clearSearchInputBtn');
    const filterQueryInput = document.getElementById('filterQueryInput');

    if (clearSearchInputBtn && filterQueryInput) {
        filterQueryInput.addEventListener('input', () => {
            if (filterQueryInput.value.trim().length > 0) {
                clearSearchInputBtn.style.display = 'block';
            } else {
                clearSearchInputBtn.style.display = 'none';
            }
        });

        clearSearchInputBtn.addEventListener('click', (e) => {
            e.preventDefault();
            filterQueryInput.value = '';
            clearSearchInputBtn.style.display = 'none';
            filterQueryInput.focus();
        });
    }

    // Clean Empty Query Parameters on Form Submit (Prevents sending &q= or empty params)
    const filterModalForm = document.getElementById('filterModalForm');
    if (filterModalForm) {
        filterModalForm.addEventListener('submit', () => {
            const inputs = filterModalForm.querySelectorAll('input');
            inputs.forEach(input => {
                if (!input.value || input.value.trim() === '') {
                    input.disabled = true;
                }
            });
        });
    }

});
