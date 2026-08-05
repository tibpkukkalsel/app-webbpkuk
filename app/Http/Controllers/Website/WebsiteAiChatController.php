<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Fasilitas;
use App\Models\ProdukUmkm;
use App\Models\Identitas;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WebsiteAiChatController extends Controller
{
    public function respond(Request $request)
    {
        $message = trim(strip_tags($request->input('message', '')));

        if (empty($message)) {
            return response()->json([
                'status' => 'error',
                'reply'  => 'Silakan ketikkan pertanyaan Anda seputar layanan Balai Pelatihan Koperasi dan Usaha Kecil.'
            ]);
        }

        $lowerMsg = strtolower($message);

        // 1. GREETINGS
        if (preg_match('/\b(halo|hai|salam|selamat pagi|selamat siang|selamat sore|ping|help|bantuan|assalamualaikum|assalamu\'alaikum)\b/', $lowerMsg)) {
            return response()->json([
                'status' => 'success',
                'reply'  => "Halo! 👋 Selamat datang di Website Resmi **Balai Pelatihan Koperasi dan Usaha Kecil Prov. Kalsel**.\n\nSaya **Aira** (Asisten AI Balatkop-UK). Ada yang bisa saya bantu hari ini?\n\nAnda dapat memilih topik populer di bawah ini atau ketik pertanyaan Anda.",
                'chips'  => [
                    '📅 Jadwal Diklat & Pelatihan',
                    '🏢 Cara Sewa Gedung & Fasilitas',
                    '🛍️ Layanan Kemasan UMKM',
                    '📍 Lokasi & Jam Operasional',
                    '📞 Hubungi Helpdesk Official'
                ]
            ]);
        }

        // 2. SEWA FASILITAS & GEDUNG INTENT
        if (preg_match('/\b(fasilitas|sewa|gedung|aula|asrama|ruang|kelas|tarif|biaya|pinjam|reservasi|kamar|aula utama|aula 1|aula 2)\b/', $lowerMsg)) {
            $fasilitasCount = Fasilitas::count();
            $fasilitasSample = Fasilitas::select('nama_fasilitas', 'kapasitas', 'slug')->limit(3)->get();

            $reply = "🏢 **Layanan Pemanfaatan Fasilitas Balatkop-UK Kalsel**\n\nBalai Pelatihan Koperasi dan Usaha Kecil memiliki berbagai fasilitas (Gedung Aula Utama, Ruang Kelas, Asrama, dsb) yang dapat disewa oleh masyarakat umum maupun instansi.\n\n";

            if ($fasilitasSample->count() > 0) {
                $reply .= "Beberapa fasilitas populer kami:\n";
                foreach ($fasilitasSample as $f) {
                    $reply .= "• **" . e($f->nama_fasilitas) . "**" . ($f->kapasitas ? " (Kapasitas: {$f->kapasitas} orang)" : "") . "\n";
                }
            }

            $reply .= "\n👉 Untuk melihat foto detail, tarif resmi, dan mengisi **Formulir Permohonan Sewa Online**, silakan kunjungi halaman:\n[🏢 Halaman Pemanfaatan Fasilitas](" . route('website.layanan.fasilitas') . ")";

            return response()->json([
                'status' => 'success',
                'reply'  => $reply,
                'action_link' => route('website.layanan.fasilitas'),
                'action_label' => 'Buka Pemanfaatan Fasilitas'
            ]);
        }

        // 3. DIKLAT & PELATIHAN INTENT
        if (preg_match('/\b(diklat|pelatihan|kursus|jadwal|daftar|syarat|sertifikat|e-sertifikat|survei|ikp|koperasi|umkm|alumni)\b/', $lowerMsg)) {
            $reply = "📅 **Informasi Diklat & Pelatihan Koperasi / UMKM**\n\nBalatkop Kalsel secara rutin menyelenggarakan Pelatihan Manajemen Koperasi, Kewirausahaan UMKM, Digital Marketing, Keuangan, dan Pengolahan Produk.\n\nFasilitas Diklat:\n• Pendaftaran Online & Identifikasi Kebutuhan Diklat\n• E-Sertifikat Elektronik Alumni\n• Survei Kepuasan Diklat (IKP)\n\n👉 Silakan akses Portal Layanan Diklat kami melalui link di bawah ini:\n[📊 Dashboard & Dashboard Diklat](" . route('website.layanan.diklat') . ")\n[📝 Identifikasi Kebutuhan Diklat](" . route('website.layanan.identifikasi') . ")\n[📜 Cek E-Sertifikat Elektronik](" . route('website.layanan.sertifikat') . ")";

            return response()->json([
                'status' => 'success',
                'reply'  => $reply,
                'action_link' => route('website.layanan.diklat'),
                'action_label' => 'Portal Layanan Diklat'
            ]);
        }

        // 4. LAYANAN KEMASAN & PRODUK UMKM INTENT
        if (preg_match('/\b(kemasan|produk|umkm|etalase|desain|cetak|bimbingan|konsultasi|mitra|jual)\b/', $lowerMsg)) {
            $totalProduk = ProdukUmkm::count();
            $reply = "🛍️ **Layanan Kemasan & Etalase Produk UMKM**\n\nBalatkop Kalsel menyediakan Layanan Kemasan bagi para pelaku Usaha Mikro, Kecil, dan Menengah (UMKM) Provinsi Kalimantan Selatan untuk meningkatkan kualitas kemasan dan daya saing produk.\n\nSaat ini terdapat **" . number_format($totalProduk) . " Produk UMKM Mitra** yang terdaftar di etalase kami.";

            return response()->json([
                'status' => 'success',
                'reply'  => $reply
            ]);
        }

        // 5. PROFIL, LOKASI, JAM OPERASIONAL & KONTAK INTENT
        if (preg_match('/\b(lokasi|alamat|dimana|jam|buka|tutup|operasional|kontak|telepon|wa|whatsapp|email|instagram|youtube|sosmed|alamat kantor)\b/', $lowerMsg)) {
            $identitas = Identitas::all();
            $alamat = $identitas->firstWhere('nama', 'Alamat')?->keterangan ?? 'Jl. Ahmad Yani KM. 18.200 Banjarbaru, Kalimantan Selatan 70722';
            $telepon = $identitas->firstWhere('nama', 'Telepon')?->keterangan ?? '(0511) 4707559';
            $email = $identitas->firstWhere('nama', 'Email')?->keterangan ?? 'web.balatkopuk@gmail.com';

            $reply = "📍 **Lokasi & Kontak Resmi Balatkop Kalsel**\n\n"
                . "• **Alamat Kantor**: " . e($alamat) . "\n"
                . "• **Jam Kerja Operasional**: Senin - Jumat | 08.00 - 16.00 WITA\n"
                . "• **Telepon**: " . e($telepon) . "\n"
                . "• **Email**: " . e($email) . "\n"
                . "• **Media Sosial Resmi**: Instagram @balatkop_kalsel | YouTube Balatkop Kalsel\n\n"
                . "👉 Jika Anda ingin mengirimkan pesan/pertanyaan resmi ke Helpdesk, silakan isi form di halaman [📞 Halaman Kontak Resmi](" . route('website.kontak') . ").";

            return response()->json([
                'status' => 'success',
                'reply'  => $reply,
                'action_link' => route('website.kontak'),
                'action_label' => 'Kirim Pesan ke Helpdesk'
            ]);
        }

        // 6. SEARCH RECENT POSTS (BERITA / ARTIKEL / INFO)
        $matchingPosts = Post::where('status', 2)
            ->where(function ($q) use ($lowerMsg) {
                $q->where('judul', 'like', "%{$lowerMsg}%")
                  ->orWhere('isi', 'like', "%{$lowerMsg}%");
            })
            ->select('judul', 'slug', 'jenis', 'created_at')
            ->latest('created_at')
            ->limit(3)
            ->get();

        if ($matchingPosts->count() > 0) {
            $reply = "📰 **Informasi & Berita Terkait Pertanyaan Anda:**\n\nSaya menemukan artikel/berita publikasi berikut yang mungkin sesuai:\n\n";
            foreach ($matchingPosts as $p) {
                $url = route('website.informasi.detail', $p->slug);
                $reply .= "• [" . e($p->judul) . "]({$url}) (" . e(ucfirst($p->jenis)) . " - " . ($p->created_at ? $p->created_at->format('d/m/Y') : '') . ")\n";
            }

            return response()->json([
                'status' => 'success',
                'reply'  => $reply
            ]);
        }

        // 7. FALLBACK RESPONSE
        $reply = "Terima kasih telah bertanya! 😊\n\nSaya **Aira** (Asisten AI Balatkop-UK). Pertanyaan Anda *" . e(Str::limit($message, 50)) . "* memerlukan jawaban lebih spesifik dari staf kami.\n\nSilakan pilih topik cepat di bawah ini atau kirim pesan resmi ke Helpdesk kami:";

        return response()->json([
            'status' => 'fallback',
            'reply'  => $reply,
            'chips'  => [
                '🏢 Cara Sewa Gedung',
                '📅 Jadwal Diklat',
                '📞 Hubungi Helpdesk Official'
            ],
            'action_link' => route('website.kontak'),
            'action_label' => 'Tanyakan ke Helpdesk'
        ]);
    }
}
