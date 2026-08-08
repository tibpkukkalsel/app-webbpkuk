<!-- FLOATING ACCESSIBILITY DISABILITY WIDGET (PEMERINTAH / SPBE ACCESSIBILITY STANDARD) -->
<div id="accessWidgetWrapper" class="access-widget-wrapper">
    
    <!-- Floating Trigger Button (Bottom-Left Pinned Minimalist Icon FAB) -->
    <button type="button" id="accessWidgetToggleBtn" class="access-widget-trigger" aria-label="Buka Menu Aksesibilitas Disabilitas" title="Aksesibilitas Ramah Difabel & Lansia">
        <i class="fa-solid fa-universal-access access-icon-main"></i>
    </button>

    <!-- Slide-out Drawer Panel -->
    <div id="accessWidgetDrawer" class="access-widget-drawer" aria-hidden="true">
        <div class="access-drawer-header">
            <div class="access-drawer-title">
                <i class="fa-solid fa-universal-access text-blue"></i>
                <div>
                    <h4 class="m-0 font-bold">Fitur Aksesibilitas</h4>
                    <span class="text-xs text-muted">Ramah Difabel & Lansia</span>
                </div>
            </div>
            <button type="button" id="accessWidgetCloseBtn" class="access-drawer-close" aria-label="Tutup">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="access-drawer-body">
            
            <!-- Feature 1: Text to Speech Audio Reader -->
            <div class="access-feature-group">
                <div class="access-feature-label">
                    <i class="fa-solid fa-volume-high text-blue"></i>
                    <span>Pembaca Suara (Text-to-Speech)</span>
                </div>
                <div class="access-audio-controls">
                    <button type="button" id="accessBtnPlayAudio" class="access-audio-btn play-btn" title="Mulai Membaca Halaman Ini">
                        <i class="fa-solid fa-play me-2"></i> <span>Baca Halaman</span>
                    </button>
                    <button type="button" id="accessBtnStopAudio" class="access-audio-btn stop-btn" title="Hentikan Pembacaan Suara" style="display: none;">
                        <i class="fa-solid fa-square me-2"></i> <span>Hentikan</span>
                    </button>
                </div>
                <span id="accessAudioStatusText" class="access-status-subtext" style="display: none;">Membaca teks halaman...</span>
            </div>

            <hr class="access-divider">

            <!-- Feature 2: Font Resizer -->
            <div class="access-feature-group">
                <div class="access-feature-label">
                    <i class="fa-solid fa-font text-blue"></i>
                    <span>Ukuran Teks / Huruf</span>
                </div>
                <div class="access-pills-row">
                    <button type="button" class="access-pill-btn active" data-font="normal">Normal</button>
                    <button type="button" class="access-pill-btn" data-font="lg">Besar (A+)</button>
                    <button type="button" class="access-pill-btn" data-font="xl">Sangat Besar (A++)</button>
                </div>
            </div>

            <hr class="access-divider">

            <!-- Feature 3: Contrast & Color Filter -->
            <div class="access-feature-group">
                <div class="access-feature-label">
                    <i class="fa-solid fa-circle-half-stroke text-blue"></i>
                    <span>Mode Tampilan & Warna</span>
                </div>
                <div class="access-pills-row">
                    <button type="button" class="access-pill-btn active" data-color="normal">Standar</button>
                    <button type="button" class="access-pill-btn" data-color="contrast">Kontras Tinggi</button>
                    <button type="button" class="access-pill-btn" data-color="grayscale">Monokrom</button>
                </div>
            </div>

            <hr class="access-divider">

            <!-- Feature 4: Dyslexia Friendly Font -->
            <div class="access-feature-group">
                <div class="access-feature-label">
                    <i class="fa-solid fa-book-open-reader text-blue"></i>
                    <span>Huruf Ramah Disleksia</span>
                </div>
                <div class="access-pills-row">
                    <button type="button" class="access-pill-btn active" data-dyslexic="off">Standar</button>
                    <button type="button" class="access-pill-btn" data-dyslexic="on">Ramah Disleksia</button>
                </div>
            </div>

            <hr class="access-divider">

            <!-- Feature 5: Highlight Links -->
            <div class="access-feature-group">
                <div class="access-feature-label">
                    <i class="fa-solid fa-link text-blue"></i>
                    <span>Sorot Tautan / Link</span>
                </div>
                <div class="access-pills-row">
                    <button type="button" class="access-pill-btn active" data-links="off">Standar</button>
                    <button type="button" class="access-pill-btn" data-links="on">Sorot Link</button>
                </div>
            </div>

        </div>

        <div class="access-drawer-footer">
            <button type="button" id="accessBtnReset" class="access-reset-btn">
                <i class="fa-solid fa-rotate-left me-1"></i> Reset Semua Pengaturan
            </button>
        </div>
    </div>
</div>

<!-- SCOPED CSS STYLES FOR ACCESSIBILITY WIDGET -->
<style>
/* Unique Floating Circular Trigger Button (Bottom Right Pinned) */
.access-widget-wrapper {
    position: fixed;
    bottom: 24px;
    right: 24px;
    z-index: 999999;
    font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
}

.access-widget-trigger {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
    color: #ffffff;
    border: 2.5px solid #ffffff;
    cursor: pointer;
    box-shadow: 0 8px 24px rgba(2, 132, 199, 0.4);
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    outline: none;
    animation: accessPulseGlow 2.5s infinite;
}

.access-widget-trigger:hover {
    transform: scale(1.12) rotate(6deg);
    background: linear-gradient(135deg, #0369a1 0%, #075985 100%);
}

.access-icon-main {
    font-size: 1.45rem;
    color: #ffffff;
    transition: transform 0.3s ease;
}

.access-widget-trigger:hover .access-icon-main {
    transform: scale(1.1);
}

@keyframes accessPulseGlow {
    0% {
        box-shadow: 0 0 0 0 rgba(2, 132, 199, 0.6), 0 8px 24px rgba(2, 132, 199, 0.35);
    }
    70% {
        box-shadow: 0 0 0 14px rgba(2, 132, 199, 0), 0 8px 24px rgba(2, 132, 199, 0.35);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(2, 132, 199, 0), 0 8px 24px rgba(2, 132, 199, 0.35);
    }
}

/* Slide-out Drawer Panel */
.access-widget-drawer {
    position: fixed;
    bottom: 84px;
    right: 24px;
    left: auto;
    width: 380px;
    max-width: calc(100vw - 32px);
    max-height: calc(100vh - 110px);
    display: flex;
    flex-direction: column;
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 20px 40px -10px rgba(15, 23, 42, 0.25);
    border: 1px solid #e2e8f0;
    overflow: hidden;
    visibility: hidden;
    opacity: 0;
    transform: translateY(15px) scale(0.95);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    z-index: 1000000;
}

@media (max-width: 640px) {
    .access-widget-wrapper {
        bottom: 85px !important;
        right: 16px !important;
        z-index: 999999 !important;
    }
    .access-widget-trigger {
        width: 48px !important;
        height: 48px !important;
    }
    .access-widget-drawer {
        position: fixed !important;
        bottom: 0 !important;
        right: 0 !important;
        left: 0 !important;
        top: auto !important;
        width: 100vw !important;
        max-width: 100vw !important;
        max-height: 82vh !important;
        display: flex !important;
        flex-direction: column !important;
        border-radius: 24px 24px 0 0 !important;
        box-shadow: 0 -10px 40px rgba(15, 23, 42, 0.4) !important;
        z-index: 1000000 !important;
    }
    .access-drawer-body {
        flex: 1 !important;
        max-height: calc(82vh - 120px) !important;
        overflow-y: auto !important;
        -webkit-overflow-scrolling: touch !important;
        touch-action: pan-y !important;
        overscroll-behavior: contain !important;
    }
    .access-pill-btn {
        min-width: 75px !important;
        font-size: 0.78rem !important;
        padding: 7px 6px !important;
    }
}

.access-widget-drawer.is-active {
    visibility: visible;
    opacity: 1;
    transform: translateY(0) scale(1);
}

.access-drawer-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    flex-shrink: 0;
}

.access-drawer-title {
    display: flex;
    align-items: center;
    gap: 10px;
}

.access-drawer-title i {
    font-size: 1.3rem;
}

.access-drawer-title h4 {
    font-size: 0.95rem;
    font-weight: 800;
    color: #0f172a;
}

.access-drawer-title span {
    font-size: 0.72rem;
    color: #64748b;
}

.access-drawer-close {
    background: #e2e8f0;
    border: none;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #475569;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.access-drawer-close:hover {
    background: #cbd5e1;
    color: #0f172a;
}

.access-drawer-body {
    flex: 1;
    padding: 18px 20px;
    max-height: calc(100vh - 200px);
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
    touch-action: pan-y;
    overscroll-behavior: contain;
}

.access-feature-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.access-feature-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.84rem;
    font-weight: 700;
    color: #1e293b;
}

.access-feature-label i {
    font-size: 0.9rem;
}

.access-pills-row {
    display: flex;
    align-items: stretch;
    gap: 8px;
    flex-wrap: wrap;
}

.access-pill-btn {
    flex: 1 1 calc(33.333% - 6px);
    min-width: 80px;
    padding: 8px 10px;
    border-radius: 12px;
    background: #f1f5f9;
    border: 1px solid #cbd5e1;
    color: #475569;
    font-size: 0.78rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: center;
    white-space: normal;
    word-break: break-word;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    line-height: 1.25;
}

.access-pill-btn:hover {
    background: #e2e8f0;
    color: #0f172a;
}

.access-pill-btn.active {
    background: #0284c7;
    border-color: #0284c7;
    color: #ffffff;
    font-weight: 700;
    box-shadow: 0 2px 6px rgba(2, 132, 199, 0.25);
}

.access-audio-controls {
    display: flex;
    gap: 8px;
}

.access-audio-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 9px 16px;
    border-radius: 10px;
    font-size: 0.82rem;
    font-weight: 700;
    cursor: pointer;
    border: none;
    transition: all 0.2s ease;
}

.access-audio-btn i {
    font-size: 0.85rem;
    margin-right: 2px;
}

.access-audio-btn.play-btn {
    background: #e0f2fe;
    color: #0284c7;
    border: 1px solid #bae6fd;
    width: 100%;
}

.access-audio-btn.play-btn:hover {
    background: #0284c7;
    color: #ffffff;
}

.access-audio-btn.stop-btn {
    background: #ffe4e6;
    color: #e11d48;
    border: 1px solid #fecdd3;
    width: 100%;
}

.access-audio-btn.stop-btn:hover {
    background: #e11d48;
    color: #ffffff;
}

.access-status-subtext {
    font-size: 0.72rem;
    color: #16a34a;
    font-weight: 600;
    margin-top: 2px;
}

.access-divider {
    border: 0;
    height: 1px;
    background: #f1f5f9;
    margin: 14px 0;
}

.access-drawer-footer {
    padding: 12px 20px;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
}

.access-reset-btn {
    width: 100%;
    padding: 8px 12px;
    border-radius: 10px;
    background: #fff1f2;
    border: 1px solid #fecdd3;
    color: #e11d48;
    font-size: 0.78rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
}

.access-reset-btn:hover {
    background: #ffe4e6;
    color: #be123c;
}

/* ==========================================================================
   GLOBAL ACCESSIBILITY BODY MODIFIERS (NON-DESTRUCTIVE)
   ========================================================================== */
/* Proportional Font & Layout Scaling (Applied ONLY to Page Content, NOT Floating Widgets) */
body.access-font-lg main,
body.access-font-lg header,
body.access-font-lg footer,
body.access-font-lg section,
body.access-font-lg article,
body.access-font-lg .hero-section,
body.access-font-lg .informasi-main-section,
body.access-font-lg .profile-page-banner,
body.access-font-lg .kontak-section {
    zoom: 1.14 !important;
}

body.access-font-xl main,
body.access-font-xl header,
body.access-font-xl footer,
body.access-font-xl section,
body.access-font-xl article,
body.access-font-xl .hero-section,
body.access-font-xl .informasi-main-section,
body.access-font-xl .profile-page-banner,
body.access-font-xl .kontak-section {
    zoom: 1.28 !important;
}

/* Hard-Lock Widget Drawer Internal Font Sizes against Page Resizing */
.access-widget-drawer .access-drawer-title h4 { font-size: 0.95rem !important; }
.access-widget-drawer .access-drawer-title span { font-size: 0.72rem !important; }
.access-widget-drawer .access-feature-label { font-size: 0.84rem !important; }
.access-widget-drawer .access-pill-btn { font-size: 0.78rem !important; }
.access-widget-drawer .access-audio-btn { font-size: 0.82rem !important; }
.access-widget-drawer .access-reset-btn { font-size: 0.78rem !important; }

/* Fallback for browsers that do not support zoom */
@supports not (zoom: 1.14) {
    body.access-font-lg main,
    body.access-font-lg header,
    body.access-font-lg footer {
        font-size: 114% !important;
    }
    body.access-font-xl main,
    body.access-font-xl header,
    body.access-font-xl footer {
        font-size: 128% !important;
    }
}

body.access-contrast {
    background-color: #0f172a !important;
    color: #f8fafc !important;
}

body.access-contrast p,
body.access-contrast span,
body.access-contrast h1,
body.access-contrast h2,
body.access-contrast h3,
body.access-contrast h4,
body.access-contrast h5,
body.access-contrast h6,
body.access-contrast li {
    color: #ffffff !important;
}

body.access-contrast a {
    color: #38bdf8 !important;
}

body.access-contrast .news-card,
body.access-contrast .agenda-ref-card,
body.access-contrast .informasi-filter-modal .filter-modal-content,
body.access-contrast .hero-content {
    background: #1e293b !important;
    border-color: #334155 !important;
}

html.access-grayscale {
    filter: grayscale(100%) !important;
    -webkit-filter: grayscale(100%) !important;
}

body.access-dyslexic,
body.access-dyslexic * {
    font-family: 'OpenDyslexic', 'Lexend', 'Comic Sans MS', sans-serif !important;
}

body.access-highlight-links a {
    outline: 2px dashed #0284c7 !important;
    outline-offset: 3px !important;
    text-decoration: underline !important;
    font-weight: 700 !important;
}
</style>

<!-- ACCESSIBILITY WIDGET LOGIC SCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('accessWidgetToggleBtn');
    const drawer = document.getElementById('accessWidgetDrawer');
    const closeBtn = document.getElementById('accessWidgetCloseBtn');
    const resetBtn = document.getElementById('accessBtnReset');

    const playAudioBtn = document.getElementById('accessBtnPlayAudio');
    const stopAudioBtn = document.getElementById('accessBtnStopAudio');
    const audioStatusText = document.getElementById('accessAudioStatusText');

    const fontPills = document.querySelectorAll('.access-pill-btn[data-font]');
    const colorPills = document.querySelectorAll('.access-pill-btn[data-color]');
    const dyslexicPills = document.querySelectorAll('.access-pill-btn[data-dyslexic]');
    const linksPills = document.querySelectorAll('.access-pill-btn[data-links]');

    const STORAGE_KEY = 'balatkop_accessibility_settings_v1';

    let currentSettings = {
        font: 'normal',
        color: 'normal',
        dyslexic: 'off',
        links: 'off'
    };

    // Load Saved Settings from LocalStorage
    function loadSettings() {
        try {
            const saved = localStorage.getItem(STORAGE_KEY);
            if (saved) {
                currentSettings = Object.assign({}, currentSettings, JSON.parse(saved));
            }
        } catch(e) {}
        applySettings();
    }

    // Save Settings
    function saveSettings() {
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(currentSettings));
        } catch(e) {}
    }

    // Apply Settings to Body & DocumentElement
    function applySettings() {
        // Font Resizer
        document.body.classList.remove('access-font-lg', 'access-font-xl');
        document.documentElement.classList.remove('access-font-lg', 'access-font-xl');

        if (currentSettings.font === 'lg') {
            document.body.classList.add('access-font-lg');
            document.documentElement.classList.add('access-font-lg');
        }
        if (currentSettings.font === 'xl') {
            document.body.classList.add('access-font-xl');
            document.documentElement.classList.add('access-font-xl');
        }
        fontPills.forEach(p => {
            p.classList.toggle('active', p.getAttribute('data-font') === currentSettings.font);
        });

        // Color & Contrast Filter
        document.body.classList.remove('access-contrast');
        document.documentElement.classList.remove('access-contrast', 'access-grayscale');

        if (currentSettings.color === 'contrast') {
            document.body.classList.add('access-contrast');
        }
        if (currentSettings.color === 'grayscale') {
            document.documentElement.classList.add('access-grayscale');
        }
        colorPills.forEach(p => {
            p.classList.toggle('active', p.getAttribute('data-color') === currentSettings.color);
        });

        // Dyslexia Font
        document.body.classList.remove('access-dyslexic');
        if (currentSettings.dyslexic === 'on') document.body.classList.add('access-dyslexic');
        dyslexicPills.forEach(p => {
            p.classList.toggle('active', p.getAttribute('data-dyslexic') === currentSettings.dyslexic);
        });

        // Highlight Links
        document.body.classList.remove('access-highlight-links');
        if (currentSettings.links === 'on') document.body.classList.add('access-highlight-links');
        linksPills.forEach(p => {
            p.classList.toggle('active', p.getAttribute('data-links') === currentSettings.links);
        });
    }

    // Toggle Drawer
    function openDrawer() {
        if (drawer) {
            drawer.classList.add('is-active');
            drawer.setAttribute('aria-hidden', 'false');
        }
    }

    function closeDrawer() {
        if (drawer) {
            drawer.classList.remove('is-active');
            drawer.setAttribute('aria-hidden', 'true');
        }
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            if (drawer.classList.contains('is-active')) {
                closeDrawer();
            } else {
                openDrawer();
            }
        });
    }

    if (closeBtn) closeBtn.addEventListener('click', closeDrawer);

    document.addEventListener('click', function(e) {
        if (drawer && drawer.classList.contains('is-active') && !drawer.contains(e.target) && e.target !== toggleBtn) {
            closeDrawer();
        }
    });

    // Event Handlers for Pills
    fontPills.forEach(pill => {
        pill.addEventListener('click', function() {
            currentSettings.font = this.getAttribute('data-font');
            saveSettings();
            applySettings();
        });
    });

    colorPills.forEach(pill => {
        pill.addEventListener('click', function() {
            currentSettings.color = this.getAttribute('data-color');
            saveSettings();
            applySettings();
        });
    });

    dyslexicPills.forEach(pill => {
        pill.addEventListener('click', function() {
            currentSettings.dyslexic = this.getAttribute('data-dyslexic');
            saveSettings();
            applySettings();
        });
    });

    linksPills.forEach(pill => {
        pill.addEventListener('click', function() {
            currentSettings.links = this.getAttribute('data-links');
            saveSettings();
            applySettings();
        });
    });

    // Reset All
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            currentSettings = { font: 'normal', color: 'normal', dyslexic: 'off', links: 'off' };
            stopSpeech();
            saveSettings();
            applySettings();
        });
    }

    // ==========================================================================
    // TEXT-TO-SPEECH AUDIO READER (NATIVE WEB SPEECH API)
    // ==========================================================================
    let synth = window.speechSynthesis;
    let utterance = null;

    function startSpeech() {
        if (!synth) {
            alert('Maaf, peramban Anda belum mendukung fitur Pembaca Suara.');
            return;
        }

        synth.cancel(); // Stop any active speech

        // Extract readable text from main content
        let readableText = '';
        const titleEl = document.querySelector('h1') || document.title;
        const mainContentEl = document.querySelector('main') || document.querySelector('.informasi-main-section') || document.body;

        if (titleEl) {
            readableText += (titleEl.innerText || titleEl) + '. ';
        }

        if (mainContentEl) {
            // Clean text from scripts/buttons/inputs
            const clone = mainContentEl.cloneNode(true);
            const removeTargets = clone.querySelectorAll('script, style, button, input, select, nav, footer, .access-widget-wrapper');
            removeTargets.forEach(el => el.remove());
            readableText += clone.innerText.replace(/\s+/g, ' ').trim();
        }

        if (!readableText) return;

        // Truncate to reasonable speech length if necessary
        readableText = readableText.substring(0, 1500);

        utterance = new SpeechSynthesisUtterance(readableText);
        utterance.lang = 'id-ID'; // Indonesian Voice
        utterance.rate = 0.95; // Slightly comfortable reading speed

        utterance.onstart = function() {
            if (playAudioBtn) playAudioBtn.style.display = 'none';
            if (stopAudioBtn) stopAudioBtn.style.display = 'inline-flex';
            if (audioStatusText) audioStatusText.style.display = 'block';
        };

        utterance.onend = function() {
            resetSpeechUI();
        };

        utterance.onerror = function() {
            resetSpeechUI();
        };

        synth.speak(utterance);
    }

    function stopSpeech() {
        if (synth) {
            synth.cancel();
        }
        resetSpeechUI();
    }

    function resetSpeechUI() {
        if (playAudioBtn) playAudioBtn.style.display = 'inline-flex';
        if (stopAudioBtn) stopAudioBtn.style.display = 'none';
        if (audioStatusText) audioStatusText.style.display = 'none';
    }

    if (playAudioBtn) playAudioBtn.addEventListener('click', startSpeech);
    if (stopAudioBtn) stopAudioBtn.addEventListener('click', stopSpeech);

    // Initial load
    loadSettings();
});
</script>
