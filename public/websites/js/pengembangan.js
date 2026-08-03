/* =========================================================
   HALAMAN SEDANG DIBANGUN / PENGEMBANGAN JAVASCRIPT (GENERAL)
   ========================================================= */

(function () {
    'use strict';

    var targetDate = new Date();
    targetDate.setDate(targetDate.getDate() + 40);

    function updateCountdown() {
        var now = new Date().getTime();
        var distance = targetDate.getTime() - now;

        if (distance < 0) return;

        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        var daysEl = document.getElementById('uc-days');
        var hoursEl = document.getElementById('uc-hours');
        var minutesEl = document.getElementById('uc-minutes');
        var secondsEl = document.getElementById('uc-seconds');

        if (daysEl) daysEl.innerText = days < 10 ? '0' + days : days;
        if (hoursEl) hoursEl.innerText = hours < 10 ? '0' + hours : hours;
        if (minutesEl) minutesEl.innerText = minutes < 10 ? '0' + minutes : minutes;
        if (secondsEl) secondsEl.innerText = seconds < 10 ? '0' + seconds : seconds;
    }

    if (document.getElementById('uc-days')) {
        setInterval(updateCountdown, 1000);
        updateCountdown();
    }
})();
