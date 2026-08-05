<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Kontak;
use App\Models\FasilitasPemesan;
use App\Models\GisIdentifikasi;
use App\Models\GisTarget;
use App\Models\GisRealisasi;
use App\Models\ProdukUmkm;
use App\Models\Pegawai;
use App\Models\Agenda;
use App\Models\User;

class DashboardController extends Controller
{
    public function view()
    {
        $totalBerita = Post::where('jenis', 'Berita')->count();
        $totalArtikel = Post::where('jenis', 'Artikel')->count();
        $totalInfo = Post::whereIn('jenis', ['Info', 'Tips', 'Info dan Tips'])->count();
        $totalSemuaPost = Post::count();
        $postPublish = Post::where('status', 2)->count();
        $postDraft = Post::where('status', 0)->count();

        $totalKontak = Kontak::count();
        $kontakMenunggu = Kontak::where('status', 'belum')->count();

        $totalPemesanFasilitas = FasilitasPemesan::count();
        $pemesanMenunggu = FasilitasPemesan::where('status', 'Menunggu Konfirmasi')->count();

        $totalRespondenIKP = GisIdentifikasi::sum('jumlah_responden') ?: 0;
        $totalTargetDiklat = GisTarget::sum('target_peserta') ?: 0;
        $totalRealisasiDiklat = GisRealisasi::sum('jumlah_peserta') ?: 0;

        $totalProdukUmkm = ProdukUmkm::count();
        $totalPegawai = Pegawai::count();
        $totalAgenda = Agenda::count();
        $totalUser = User::count();

        $latestPosts = Post::with('kategori')
            ->latest('created_at')
            ->take(5)
            ->get();

        $latestKontak = Kontak::latest('created_at')
            ->take(5)
            ->get();

        $latestPemesan = FasilitasPemesan::latest('created_at')
            ->take(5)
            ->get();

        return view('admin.dashboard.view', compact(
            'totalBerita',
            'totalArtikel',
            'totalInfo',
            'totalSemuaPost',
            'postPublish',
            'postDraft',
            'totalKontak',
            'kontakMenunggu',
            'totalPemesanFasilitas',
            'pemesanMenunggu',
            'totalRespondenIKP',
            'totalTargetDiklat',
            'totalRealisasiDiklat',
            'totalProdukUmkm',
            'totalPegawai',
            'totalAgenda',
            'totalUser',
            'latestPosts',
            'latestKontak',
            'latestPemesan'
        ));
    }
}
