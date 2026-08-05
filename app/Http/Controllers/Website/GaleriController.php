<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Video;
use App\Models\Hashtag;
use App\Models\Tentang;
use App\Models\Identitas;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function view(Request $request)
    {
        $search = $request->query('q');
        $selectedKategori = $request->query('kategori');

        $query = Post::with(['kategori', 'galeri'])
            ->where('status', 2)
            ->has('galeri');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('isi', 'like', "%{$search}%");
            });
        }

        if (!empty($selectedKategori)) {
            $query->where('id_kategori', $selectedKategori);
        }

        $galeriFoto = $query->latest('created_at')->paginate(9)->withQueryString();

        $kategoriList = \App\Models\Kategori::orderBy('kategori')->get();
        $tentang = Tentang::all();
        $identitas = Identitas::all();

        return view('websites.galeri.view', compact(
            'galeriFoto',
            'kategoriList',
            'selectedKategori',
            'search',
            'tentang',
            'identitas'
        ));
    }

    public function viewVideo(Request $request)
    {
        $search = $request->query('q');
        $selectedKategori = $request->query('kategori');

        $query = Video::with('kategori')
            ->where('status', 2);

        if (!empty($search)) {
            $query->where('judul', 'like', "%{$search}%");
        }

        if (!empty($selectedKategori)) {
            $query->where('id_kategori', $selectedKategori);
        }

        $galeriVideo = $query->latest('created_at')->paginate(9)->withQueryString();

        $kategoriList = \App\Models\Kategori::orderBy('kategori')->get();
        $tentang = Tentang::all();
        $identitas = Identitas::all();

        return view('websites.galeri.video', compact(
            'galeriVideo',
            'kategoriList',
            'selectedKategori',
            'search',
            'tentang',
            'identitas'
        ));
    }

    public function detail(Request $request, $slug)
    {
        $post = Post::with(['kategori', 'user', 'galeri', 'hashtags'])
            ->where('status', 2)
            ->where(function ($q) use ($slug) {
                $q->where('slug', $slug)
                  ->orWhere('id_post', $slug);
            })
            ->firstOrFail();

        // Increment count view per hour per device
        $ip = $request->ip();
        $userAgent = md5($request->userAgent() ?? '');
        $currentHour = date('YmdH');
        $viewKey = 'viewed_galeri_' . $post->id_post . '_' . md5($ip . '_' . $userAgent) . '_' . $currentHour;

        if (!$request->session()->has($viewKey) && !cache()->has($viewKey)) {
            $post->increment('view_count');
            $request->session()->put($viewKey, true);
            cache()->put($viewKey, true, now()->addHour());
        }

        // 5 Informasi / Galeri Terbaru
        $latestPosts = Post::with('kategori')
            ->where('status', 2)
            ->where('id_post', '!=', $post->id_post)
            ->latest('created_at')
            ->take(5)
            ->get();

        // Tag Populer
        $popularHashtags = Hashtag::whereHas('posts', function ($query) {
            $query->where('status', 2);
        })
            ->withCount(['posts' => function ($query) {
                $query->where('status', 2);
            }])
            ->orderByDesc('posts_count')
            ->take(6)
            ->get();

        $tentang = Tentang::all();
        $identitas = Identitas::all();

        return view('websites.galeri.detail', compact(
            'post',
            'latestPosts',
            'popularHashtags',
            'tentang',
            'identitas'
        ));
    }
}
