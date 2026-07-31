<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Beranda;
use App\Models\HeroBanner;
use App\Models\Identitas;
use App\Models\Infografis;
use App\Models\LinkTerkait;
use App\Models\Post;
use App\Models\Video;
use Illuminate\Support\Facades\Cache;

class BerandaController extends Controller
{
    public function view()
    {
        $heroBanners = HeroBanner::where('status', 'aktif')
            ->orderBy('urutan')
            ->orderBy('id_hero_banner')
            ->get();

        $fallbackImages = [
            'https://images.unsplash.com/photo-1577495508048-b635879837f1?q=80&w=1920&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=1920&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=1920&auto=format&fit=crop',
        ];

        if (!empty($heroBanners) && count($heroBanners) > 0) {
            $heroImages = $heroBanners->map(fn($b) => asset('storage/hero-banner/' . $b->gambar))->toArray();
        } else {
            $heroImages = $fallbackImages;
        }

        $infografis = Infografis::where('status', 'aktif')
            ->orderBy('urutan')
            ->orderBy('id_infografis')
            ->get();

        $linkTerkait = LinkTerkait::where('status', 'aktif')
            ->orderBy('urutan')
            ->orderBy('id_link_terkait')
            ->get();

        $tagline = Beranda::all();

        $beritaTerbaru = Post::select(['id_post', 'judul', 'slug', 'thumbnail', 'jenis', 'id_kategori', 'created_at'])
            ->with('kategori:id_kategori,kategori')
            ->where('status', 2)
            ->latest('created_at')
            ->take(4)
            ->get();

        $beritaTerpopuler = Post::select(['id_post', 'judul', 'slug', 'thumbnail', 'jenis', 'id_kategori', 'created_at', 'view_count'])
            ->with('kategori:id_kategori,kategori')
            ->where('status', 2)
            ->orderByDesc('view_count')
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        $galeriFoto = Post::select(['id_post', 'judul', 'slug', 'thumbnail', 'id_kategori', 'created_at'])
            ->has('galeri')
            ->with([
                'kategori:id_kategori,kategori',
                'galeri:id_galeri,id_post,gambar'
            ])
            ->where('status', 2)
            ->latest('id_post')
            ->take(4)
            ->get();

        $galeriVideo = Video::select(['id_video', 'judul', 'slug', 'youtube_id', 'id_kategori', 'created_at'])
            ->with('kategori:id_kategori,kategori')
            ->where('status', 2)
            ->latest('created_at')
            ->take(4)
            ->get();

        $agendas = Agenda::where('status', 1)
            ->orderBy('tgl_awal', 'desc')
            ->orderBy('id_agenda', 'desc')
            ->take(6)
            ->get();

        return view('websites.beranda.view', compact(
            'heroBanners',
            'heroImages',
            'infografis',
            'linkTerkait',
            'tagline',
            'beritaTerbaru',
            'beritaTerpopuler',
            'galeriFoto',
            'galeriVideo',
            'agendas'
        ));
    }
}
