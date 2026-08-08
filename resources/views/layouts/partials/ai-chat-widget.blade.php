<!-- ASISTEN AI BALATKOP KALSEL FLOATING CHATBOT WIDGET -->
<div id="ai-chat-widget-wrapper">

    <!-- FLOATING TOGGLE BUTTON (IMAGE-ONLY CIRCULAR BUTTON) -->
    <button type="button" id="ai-chat-toggle-btn" class="ai-chat-btn-pulse" aria-label="Tanya Aira" title="Asisten AI Aira">
        <div class="ai-btn-icon-wrap">
            <img src="{{ asset('websites/images/aira_avatar.png') }}?v={{ time() }}" alt="Aira Avatar" class="ai-btn-avatar-img ai-icon-default">
            <i class="fa-solid fa-xmark ai-icon-active"></i>
        </div>
    </button>

    <!-- CHAT MODAL WINDOW -->
    <div id="ai-chat-modal" class="ai-chat-modal-hidden">
        <!-- HEADER -->
        <div class="ai-chat-header">
            <div class="ai-header-info">
                <div class="ai-avatar-wrap">
                    <img src="{{ asset('websites/images/aira_avatar.png') }}?v={{ time() }}" alt="Aira Avatar" class="ai-avatar-img">
                    <span class="ai-avatar-status"></span>
                </div>
                <div>
                    <h4 class="ai-header-title">Aira - Asisten AI</h4>
                    <p class="ai-header-sub"><span class="ai-status-text">🟢 Online 24/7</span> • Prov. Kalsel</p>
                </div>
            </div>
            <button type="button" id="ai-chat-close-btn" class="ai-header-close" aria-label="Tutup Chat">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- MESSAGES CONTAINER -->
        <div id="ai-chat-body" class="ai-chat-body">
            <!-- WELCOME MESSAGE -->
            <div class="ai-msg-row ai-msg-bot">
                <div class="ai-msg-bubble">
                    Halo Kakak! Selamat datang di <strong>Balai Pelatihan Koperasi dan Usaha Kecil Prov. Kalsel</strong> 🌸<br><br>
                    Saya <strong>Aira</strong>, asisten virtual resmi Balatkop-UK Kalsel. Ada yang bisa Aira bantu mengenai informasi pelatihan diklat UMKM, sewa gedung/fasilitas, klinik kemasan, atau agenda kegiatan hari ini Kak? 😊
                </div>
            </div>

            <!-- QUICK SUGGESTION CHIPS -->
            <div id="ai-chips-wrapper" class="ai-chips-container">
                <button type="button" class="ai-chip-btn" data-msg="📅 Jadwal Diklat & Pelatihan">📅 Jadwal Diklat</button>
                <button type="button" class="ai-chip-btn" data-msg="🏢 Cara Sewa Gedung & Fasilitas">🏢 Sewa Gedung</button>
                <button type="button" class="ai-chip-btn" data-msg="🛍️ Layanan Kemasan UMKM">🛍️ Layanan Kemasan</button>
                <button type="button" class="ai-chip-btn" data-msg="📍 Lokasi & Jam Operasional">📍 Lokasi & Jam Kerja</button>
                <button type="button" class="ai-chip-btn" data-msg="📞 Hubungi Helpdesk Official">📞 Helpdesk Resmi</button>
            </div>

            <!-- DYNAMIC MESSAGES WILL BE INJECTED HERE -->
            <div id="ai-messages-list"></div>

            <!-- TYPING INDICATOR -->
            <div id="ai-typing-indicator" class="ai-msg-row ai-msg-bot d-none">
                <div class="ai-msg-bubble ai-typing-bubble">
                    <span class="ai-dot"></span>
                    <span class="ai-dot"></span>
                    <span class="ai-dot"></span>
                </div>
            </div>
        </div>

        <!-- INPUT FOOTER -->
        <form id="ai-chat-form" class="ai-chat-footer">
            @csrf
            <input type="text" id="ai-chat-input" class="ai-chat-input" placeholder="Tanyakan sesuatu ke Aira..." autocomplete="off" required>
            <button type="submit" id="ai-chat-send-btn" class="ai-chat-send-btn" aria-label="Kirim Pesan">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </form>
    </div>
</div>

<!-- STYLES FOR AI CHATBOT WIDGET -->
<style>
    #ai-chat-widget-wrapper {
        position: fixed;
        bottom: 24px;
        right: 90px;
        z-index: 99990;
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
    }

    @media (max-width: 640px) {
        #ai-chat-widget-wrapper {
            bottom: 85px !important;
            right: 74px !important;
        }
    }

    /* TOGGLE BUTTON - IMAGE ONLY CIRCLE FAB */
    #ai-chat-toggle-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: #ffffff;
        border: 2.5px solid #0284c7;
        box-shadow: 0 8px 24px rgba(2, 132, 199, 0.4);
        cursor: pointer;
        padding: 0;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        animation: aiPulseGlow 2.5s infinite;
    }

    #ai-chat-toggle-btn:hover {
        transform: scale(1.12) rotate(-5deg);
        box-shadow: 0 12px 28px rgba(2, 132, 199, 0.5);
    }

    .ai-btn-icon-wrap {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .ai-btn-avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transform: scale(1.15);
        border-radius: 50%;
    }

    .ai-icon-active {
        display: none;
        font-size: 1.4rem;
        color: #e11d48;
    }

    #ai-chat-widget-wrapper.ai-active .ai-icon-default {
        display: none;
    }

    #ai-chat-widget-wrapper.ai-active .ai-icon-active {
        display: block;
    }

    @keyframes aiPulseGlow {
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

    #ai-chat-toggle-btn:hover {
        transform: translateY(-3px) scale(1.03);
        box-shadow: 0 14px 30px rgba(2, 132, 199, 0.5);
    }

    .ai-btn-icon-wrap {
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        position: relative;
    }

    .ai-icon-active {
        display: none;
    }

    #ai-chat-widget-wrapper.ai-active .ai-icon-default {
        display: none;
    }

    #ai-chat-widget-wrapper.ai-active .ai-icon-active {
        display: inline-block;
    }

    .ai-btn-badge {
        font-size: 14px;
        font-weight: 700;
        letter-spacing: -0.2px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .ai-online-dot {
        width: 8px;
        height: 8px;
        background-color: #22c55e;
        border-radius: 50%;
        box-shadow: 0 0 8px #22c55e;
    }

    /* CHAT MODAL WINDOW */
    #ai-chat-modal {
        position: absolute;
        bottom: 75px;
        right: 0;
        width: 380px;
        max-width: calc(100vw - 32px);
        height: 520px;
        max-height: calc(100vh - 120px);
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        border: 1px solid rgba(226, 232, 240, 0.8);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        transform-origin: bottom right;
    }

    .ai-chat-modal-hidden {
        opacity: 0;
        visibility: hidden;
        transform: scale(0.85) translateY(20px);
        pointer-events: none;
    }

    /* HEADER */
    .ai-chat-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .ai-header-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .ai-avatar-wrap {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: visible;
    }

    .ai-avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #38bdf8;
    }

    .ai-btn-avatar-img {
        width: 30px;
        height: 30px;
        object-fit: cover;
        border-radius: 50%;
        border: 1.5px solid #ffffff;
    }

    .ai-avatar-status {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 10px;
        height: 10px;
        background: #22c55e;
        border: 2px solid #0f172a;
        border-radius: 50%;
    }

    .ai-header-title {
        font-size: 15px;
        font-weight: 700;
        margin: 0;
        color: #ffffff;
    }

    .ai-header-sub {
        font-size: 11px;
        margin: 2px 0 0 0;
        color: #94a3b8;
    }

    .ai-header-close {
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: #ffffff;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        transition: background 0.2s;
    }

    .ai-header-close:hover {
        background: rgba(255, 255, 255, 0.25);
    }

    /* CHAT BODY */
    .ai-chat-body {
        flex: 1;
        padding: 16px;
        overflow-y: auto;
        background-color: #f8fafc;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .ai-msg-row {
        display: flex;
        flex-direction: column;
        max-width: 85%;
    }

    .ai-msg-bot {
        align-self: flex-start;
    }

    .ai-msg-user {
        align-self: flex-end;
    }

    .ai-msg-bubble {
        padding: 12px 14px;
        border-radius: 16px;
        font-size: 13px;
        line-height: 1.55;
        word-break: break-word;
    }

    .ai-msg-bot .ai-msg-bubble {
        background: #ffffff;
        color: #1e293b;
        border-bottom-left-radius: 4px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.03);
    }

    .ai-msg-user .ai-msg-bubble {
        background: #0284c7;
        color: #ffffff;
        border-bottom-right-radius: 4px;
    }

    .ai-msg-bubble a {
        color: #0284c7;
        font-weight: 700;
        text-decoration: underline;
    }

    .ai-msg-user .ai-msg-bubble a {
        color: #ffffff;
    }

    /* CHIPS */
    .ai-chips-container {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 4px;
    }

    .ai-chip-btn {
        background: #ffffff;
        border: 1px solid #0284c7;
        color: #0284c7;
        font-size: 11px;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .ai-chip-btn:hover {
        background: #0284c7;
        color: #ffffff;
    }

    /* TYPING INDICATOR */
    .ai-typing-bubble {
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 10px 14px;
    }

    .ai-dot {
        width: 6px;
        height: 6px;
        background: #94a3b8;
        border-radius: 50%;
        animation: aiBounce 1.4s infinite ease-in-out both;
    }

    .ai-dot:nth-child(1) { animation-delay: -0.32s; }
    .ai-dot:nth-child(2) { animation-delay: -0.16s; }

    @keyframes aiBounce {
        0%, 80%, 100% { transform: scale(0); }
        40% { transform: scale(1); }
    }

    /* FOOTER INPUT */
    .ai-chat-footer {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 14px;
        background: #ffffff;
        border-top: 1px solid #e2e8f0;
    }

    .ai-chat-input {
        flex: 1;
        border: 1px solid #cbd5e1;
        border-radius: 24px;
        padding: 10px 16px;
        font-size: 13px;
        outline: none;
        transition: border 0.2s;
    }

    .ai-chat-input:focus {
        border-color: #0284c7;
    }

    .ai-chat-send-btn {
        width: 38px;
        height: 38px;
        background: #0284c7;
        color: #ffffff;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.2s;
    }

    .ai-chat-send-btn:hover {
        background: #0369a1;
    }
</style>

<!-- JAVASCRIPT FOR AI CHATBOT LOGIC -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const wrapper = document.getElementById('ai-chat-widget-wrapper');
    const toggleBtn = document.getElementById('ai-chat-toggle-btn');
    const modal = document.getElementById('ai-chat-modal');
    const closeBtn = document.getElementById('ai-chat-close-btn');
    const chatBody = document.getElementById('ai-chat-body');
    const messagesList = document.getElementById('ai-messages-list');
    const typingIndicator = document.getElementById('ai-typing-indicator');
    const chatForm = document.getElementById('ai-chat-form');
    const chatInput = document.getElementById('ai-chat-input');
    const chipsWrapper = document.getElementById('ai-chips-wrapper');

    // TOGGLE MODAL OPEN/CLOSE
    function toggleChat() {
        const isHidden = modal.classList.contains('ai-chat-modal-hidden');
        if (isHidden) {
            modal.classList.remove('ai-chat-modal-hidden');
            wrapper.classList.add('ai-active');
            chatInput.focus();
            scrollToBottom();
        } else {
            modal.classList.add('ai-chat-modal-hidden');
            wrapper.classList.remove('ai-active');
        }
    }

    toggleBtn.addEventListener('click', toggleChat);
    closeBtn.addEventListener('click', toggleChat);

    // AUTO SCROLL TO BOTTOM
    function scrollToBottom() {
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    // FORMAT MARKDOWN TO HTML
    function formatMessageText(text) {
        if (!text) return '';
        let formatted = text
            .replace(/\n/g, '<br>')
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\[(.*?)\]\((.*?)\)/g, '<a href="$2" target="_blank">$1 ↗</a>');
        return formatted;
    }

    // APPEND MESSAGE BUBBLE
    function appendMessage(sender, text) {
        const row = document.createElement('div');
        row.className = `ai-msg-row ai-msg-${sender}`;

        const bubble = document.createElement('div');
        bubble.className = 'ai-msg-bubble';
        bubble.innerHTML = formatMessageText(text);

        row.appendChild(bubble);
        messagesList.appendChild(row);
        scrollToBottom();
    }

    // HANDLE CHIPS CLICK
    if (chipsWrapper) {
        chipsWrapper.addEventListener('click', function (e) {
            if (e.target.classList.contains('ai-chip-btn')) {
                const msg = e.target.getAttribute('data-msg');
                if (msg) {
                    sendUserMessage(msg);
                }
            }
        });
    }

    // SUBMIT USER MESSAGE
    chatForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const msg = chatInput.value.trim();
        if (msg) {
            sendUserMessage(msg);
            chatInput.value = '';
        }
    });

    // SMART LOCAL AI KNOWLEDGE ENGINE (GUARANTEED ZERO-FAILURE FALLBACK)
    function getSmartLocalReply(userMsg) {
        const msgLower = userMsg.toLowerCase();

        if (/(halo|hai|selamat|pagi|siang|sore|malam|assalamualaikum|siapa kamu)/i.test(msgLower)) {
            return "Halo Kakak! 😊 Salam hangat dari **Aira** (Asisten Virtual Balatkop-UK Prov. Kalsel) 🌸\n\nAira siap membantu Kakak memberikan informasi seputar pelatihan diklat UMKM, pemanfaatan sewa gedung/fasilitas, klinik kemasan, dan agenda kegiatan Balatkop.\n\nAda yang bisa Aira bantu untuk Kakak hari ini?";
        }
        if (/(sewa|gedung|fasilitas|asrama|aula|lab|pinjam|pesan gedung|ruangan|kamar)/i.test(msgLower)) {
            return "Halo Kakak! 🏢 Berikut beberapa **Fasilitas Pelatihan & Gedung** unggulan yang ada di Balatkop-UK Prov. Kalsel:\n\n- 🏛️ **Gedung Aula Utama Pelatihan** (Kapasitas besar untuk seminar & workshop)\n- 🏨 **Asrama Peserta Diklat** (Kamar AC & tempat tidur nyaman)\n- 💻 **Laboratorium Komputer & TI** (Untuk pelatihan digital & TI)\n- 🛍️ **Klinik Kemasan UMKM** (Konsultasi desain & cetak mockup)\n\n📝 **Prosedur Pemesanan / Sewa:**\nKakak dapat mengecek estimasi tarif dan ketersediaan langsung di menu [Pemanfaatan Fasilitas](/layanan/pemanfaatan-fasilitas) ya Kak! Aira siap membantu 🙏🌸";
        }
        if (/(agenda|jadwal|pelatihan|diklat|kegiatan|acara|daftar pelatihan|ikut diklat|sebutkan agenda)/i.test(msgLower)) {
            return "Halo Kak! 📅 Mengenai **Jadwal Pelatihan & Agenda Kegiatan** Balatkop-UK Prov. Kalsel, berikut beberapa agenda unggulan kami:\n\n• **Pelatihan Digital Marketing & Branding Produk UMKM** (Kampus Balatkop Banjarbaru)\n• **Bimtek Akselerasi Manajerial & Keuangan Koperasi Modern** (Kampus Balatkop Banjarbaru)\n\n💡 **Informasi Selengkapnya & Pendaftaran:**\nKakak dapat memantau seluruh rincian kualifikasi dan mendaftar secara online melalui halaman [Agenda Kegiatan](/agenda) ya Kak! ✨🌸";
        }
        if (/(kemasan|desain|kemas|produk|umkm|klinik|bantu desain)/i.test(msgLower)) {
            return "Wah menarik sekali Kak! 🛍️ Balatkop-UK Kalsel memiliki **Layanan Klinik Kemasan UMKM** untuk membantu para pelaku UMKM Kalimantan Selatan dalam meningkatkan kualitas desain & kemasan produk agar lebih bernilai jual tinggi.\n\nKakak bisa berkonsultasi mengenai:\n- Redesain Label & Kemasan Produk\n- Pemilihan Bahan Kemasan yang Ramah Pangan (Food Grade)\n- Cetak Contoh Mockup Kemasan\n\nSilakan datang langsung ke Klinik Kemasan Balatkop di Banjarbaru ya Kak! 🌸";
        }
        if (/(lokasi|alamat|dimana|jam kerja|operasional|buka|tutup|peta)/i.test(msgLower)) {
            return "Halo Kakak! 📍 Berikut informasi **Lokasi & Jam Pelayanan** resmi Balatkop-UK Kalsel:\n\n🏢 **Alamat Kantor:**\nJl. Ahmad Yani KM. 18.200, Kec. Liang Anggang, Kota Banjarbaru, Kalimantan Selatan.\n\n⏰ **Jam Pelayanan Operasional:**\n- **Senin - Kamis:** 08.00 - 16.00 WITA\n- **Jumat:** 08.00 - 16.30 WITA\n- **Sabtu & Minggu:** Libur (Tutup)\n\nSemoga membantu ya Kak! Aira tunggu kedatangannya 😊";
        }
        if (/(sertifikat|e-sertifikat|piagam|unduh sertifikat|download)/i.test(msgLower)) {
            return "Halo Kak! 📜 Untuk mengunduh atau memverifikasi **E-Sertifikat Elektronik** alumni pelatihan Balatkop-UK Prov. Kalsel, Kakak dapat mengklik menu [Sertifikat Elektronik](/layanan/sertifikat-elektronik) lalu memasukkan Nomor Sertifikat atau NIK Kakak.\n\nJika sertifikat belum muncul, Kakak bisa menghubungi panitia diklat ya Kak! ✨";
        }
        if (/(kontak|hubungi|wa|whatsapp|telepon|email|admin|helpdesk)/i.test(msgLower)) {
            return "Halo Kakak! 📞 Jika Kakak membutuhkan bantuan lebih lanjut secara langsung dari petugas Helpdesk resmi Balatkop-UK Kalsel, Kakak dapat menghubungi kami via:\n\n- 🌐 **Halaman Kontak:** [Kontak & Helpdesk](/kontak)\n- 📍 **Kantor:** Banjarbaru KM 18.200\n\nAira selalu senang bisa membantu Kakak! 🌸";
        }
        if (/(makasih|terima kasih|thanks|ok|baik|mantap|siap)/i.test(msgLower)) {
            return "Sama-sama Kakak! 🥰 Aira senang sekali bisa membantu Kakak. Semoga usaha dan kegiatan Kakak selalu sukses dan sukses terus UMKM Kalimantan Selatan! 🌸✨";
        }

        return "Terima kasih atas pertanyaannya ya Kak! 😊\n\nMengenai hal tersebut, Aira rekomendasikan Kakak untuk mengecek menu layanan utama kami:\n- 🏢 [Pemanfaatan Fasilitas Gedung](/layanan/pemanfaatan-fasilitas)\n- 📅 [Jadwal & Agenda Pelatihan](/agenda)\n- 📞 [Kontak Helpdesk Resmi](/kontak)\n\nAtau Kakak bisa menanyakan pertanyaan lain seputar pelatihan Koperasi & UMKM Kalimantan Selatan. Aira siap membantu Kak! 🌸";
    }

    // SEND MESSAGE TO BACKEND API WITH FAILSAFE LOCAL AI FALLBACK
    function sendUserMessage(userMsg) {
        appendMessage('user', userMsg);
        typingIndicator.classList.remove('d-none');
        scrollToBottom();

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

        fetch("{{ route('website.ai-chat.respond') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ message: userMsg })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Server response not ok: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            typingIndicator.classList.add('d-none');
            if (data && data.reply) {
                appendMessage('bot', data.reply);
            } else {
                const localReply = getSmartLocalReply(userMsg);
                appendMessage('bot', localReply);
            }
        })
        .catch(err => {
            console.warn('Backend fetch bypassed, using local Aira AI engine:', err);
            typingIndicator.classList.add('d-none');
            const localReply = getSmartLocalReply(userMsg);
            appendMessage('bot', localReply);
        });
    }
});
</script>
