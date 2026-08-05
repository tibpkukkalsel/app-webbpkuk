<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Kategori;
use App\Models\Hashtag;
use App\Models\Tentang;
use App\Models\Identitas;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    public function view(Request $request)
    {
        $selectedJenis = $request->query('jenis');
        $selectedKategori = $request->query('kategori');
        $search = $request->query('q');

        $query = Post::with(['kategori:id_kategori,kategori', 'hashtags:id_hashtag,hashtag'])
            ->where('status', 2);

        // Filter by Jenis (Berita, Tips/Info, Artikel)
        if (!empty($selectedJenis)) {
            $jLower = strtolower($selectedJenis);
            if ($jLower === 'tips' || $jLower === 'info' || $jLower === 'info-dan-tips') {
                $query->whereIn('jenis', ['Tips', 'Info', 'Info dan Tips']);
            } elseif ($jLower === 'berita') {
                $query->where('jenis', 'Berita');
            } elseif ($jLower === 'artikel') {
                $query->where('jenis', 'Artikel');
            } else {
                $query->where('jenis', $selectedJenis);
            }
        }

        // Filter by Kategori Slug or ID
        if (!empty($selectedKategori)) {
            $katObj = Kategori::where('slug', $selectedKategori)
                ->orWhere('id_kategori', $selectedKategori)
                ->first();
            if ($katObj) {
                $query->where('id_kategori', $katObj->id_kategori);
            }
        }

        // Filter by Search Query & Hashtags (Querying post_hashtag pivot table as well)
        if (!empty($search)) {
            $cleanSearch = ltrim(trim($search), '#');
            $query->where(function ($q) use ($cleanSearch) {
                $q->where('judul', 'like', '%' . $cleanSearch . '%')
                  ->orWhere('isi', 'like', '%' . $cleanSearch . '%')
                  ->orWhere('ringkasan', 'like', '%' . $cleanSearch . '%')
                  ->orWhereHas('kategori', function ($katQ) use ($cleanSearch) {
                      $katQ->where('kategori', 'like', '%' . $cleanSearch . '%');
                  })
                  ->orWhereHas('hashtags', function ($hashQ) use ($cleanSearch) {
                      $hashQ->where('hashtag', 'like', '%' . $cleanSearch . '%');
                  });
            });
        }

        $posts = $query->latest('created_at')->paginate(9);

        $kategoriList = Kategori::all();
        $popularHashtags = Hashtag::whereHas('posts', function ($query) {
            $query->where('status', 2);
        })->withCount(['posts' => function ($query) {
            $query->where('status', 2);
        }])->orderByDesc('posts_count')->take(10)->get();
        $jenisList = ['Berita', 'Tips', 'Artikel'];
        $tentang = Tentang::all();
        $identitas = Identitas::all();

        return view('websites.informasi.view', compact(
            'posts',
            'kategoriList',
            'popularHashtags',
            'jenisList',
            'tentang',
            'identitas',
            'selectedJenis',
            'selectedKategori',
            'search'
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

        // Increment count view HANYA jika device/browser & jam belum tercatat
        $ip = $request->ip();
        $userAgent = md5($request->userAgent() ?? '');
        $currentHour = date('YmdH');
        $viewKey = 'viewed_post_' . $post->id_post . '_' . md5($ip . '_' . $userAgent) . '_' . $currentHour;

        if (!$request->session()->has($viewKey) && !cache()->has($viewKey)) {
            $post->increment('view_count');
            $request->session()->put($viewKey, true);
            cache()->put($viewKey, true, now()->addHour());
        }

        // 5 Informasi Terbaru
        $latestPosts = Post::with('kategori')
            ->where('status', 2)
            ->where('id_post', '!=', $post->id_post)
            ->latest('created_at')
            ->take(5)
            ->get();

        // Tag Populer yang Sering Digunakan (Maksimal 6 Tag)
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

        return view('websites.informasi.detail', compact(
            'post',
            'latestPosts',
            'popularHashtags',
            'tentang',
            'identitas'
        ));
    }
}

