document.addEventListener('DOMContentLoaded', () => {
    
    // =========================================================
    // 1. STICKY HEADER SCROLL EVENT (ACTIVATE ONLY AFTER 500px)
    // =========================================================
    const header = document.getElementById('mainHeader');
    const scrollThreshold = 500;

    const handleScroll = () => {
        if (!header) {
            return;
        }

        if (window.scrollY > scrollThreshold) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    };

    window.addEventListener('scroll', handleScroll);
    window.addEventListener('resize', handleScroll);
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
    // 3. HASHTAG SEARCH AUTO-FILL
    // =========================================================
    const tagPills = document.querySelectorAll('.tag-pill');
    const searchInput = document.getElementById('searchInput');

    tagPills.forEach(pill => {
        pill.addEventListener('click', (e) => {
            e.preventDefault();
            const tagText = pill.textContent.replace('#', '').trim();
            if (searchInput) {
                searchInput.value = tagText;
                searchInput.focus();
                
                const searchForm = document.getElementById('searchForm');
                searchForm.style.transform = 'scale(1.02)';
                setTimeout(() => {
                    searchForm.style.transform = 'scale(1)';
                }, 200);
            }
        });
    });

    const searchForm = document.getElementById('searchForm');
    if (searchForm) {
        searchForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const query = searchInput.value.trim();
            if (query) {
                alert(`Mencari informasi: "${query}" ...`);
            } else {
                searchInput.focus();
            }
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
    const newsCardsGrid = document.getElementById('newsCardsGrid');

    if (tabBtns.length > 0 && newsCardsGrid) {
        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                tabBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                newsCardsGrid.style.opacity = '0.3';
                newsCardsGrid.style.transform = 'translateY(6px)';

                setTimeout(() => {
                    newsCardsGrid.style.opacity = '1';
                    newsCardsGrid.style.transform = 'translateY(0)';
                }, 200);
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

});
