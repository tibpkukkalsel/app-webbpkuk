/* =========================================================
   STANDALONE ERROR PAGES JAVASCRIPT
   Menangani animasi, countdown, dan interaksi halaman error
   ========================================================= */

(function () {
    'use strict';

    // ---- Countdown Timer (jika ada elemen #error-countdown) ----
    var countdownEl = document.getElementById('error-countdown');
    if (countdownEl) {
        var seconds = parseInt(countdownEl.getAttribute('data-seconds') || '60', 10);
        var interval = setInterval(function () {
            seconds--;
            if (seconds <= 0) {
                clearInterval(interval);
                countdownEl.textContent = '0 detik';
                var reloadBtn = document.getElementById('btn-reload');
                if (reloadBtn) {
                    reloadBtn.classList.remove('disabled');
                    reloadBtn.removeAttribute('disabled');
                }
                return;
            }
            if (seconds >= 60) {
                var min = Math.floor(seconds / 60);
                var sec = seconds % 60;
                countdownEl.textContent = min + ' menit ' + (sec > 0 ? sec + ' detik' : '');
            } else {
                countdownEl.textContent = seconds + ' detik';
            }
        }, 1000);
    }

    // ---- Auto-redirect ke beranda setelah 60 detik (opsional) ----
    // Aktifkan dengan menambahkan data-auto-redirect="true" di <body>
    var body = document.body;
    if (body && body.getAttribute('data-auto-redirect') === 'true') {
        setTimeout(function () {
            window.location.href = '/';
        }, 60000);
    }

    // ---- Klik tombol reload ----
    var reloadBtn = document.getElementById('btn-reload');
    if (reloadBtn) {
        reloadBtn.addEventListener('click', function (e) {
            e.preventDefault();
            window.location.reload();
        });
    }

})();
