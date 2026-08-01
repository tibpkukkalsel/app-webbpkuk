/* ==========================================================================
   PEMANFAATAN FASILITAS JAVASCRIPT HANDLERS (public/websites/js/fasilitas.js)
   ========================================================================== */

function openFasilitasModal(id) {
    const overlay = document.getElementById('modal-overlay-' + id);
    if (overlay) {
        overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    }
}

function closeFasilitasModal(id) {
    const overlay = document.getElementById('modal-overlay-' + id);
    if (overlay) {
        overlay.classList.remove('open');
        document.body.style.overflow = 'auto';
    }
}

function setMainGalleryImage(fasilitasId, src) {
    const mainImg = document.getElementById('gallery-main-' + fasilitasId);
    if (mainImg) {
        mainImg.src = src;
    }
}

// Close modal when clicking on the dark backdrop overlay
document.addEventListener('click', function (e) {
    if (e.target.classList && e.target.classList.contains('fasilitas-modal-overlay')) {
        e.target.classList.remove('open');
        document.body.style.overflow = 'auto';
    }
});
