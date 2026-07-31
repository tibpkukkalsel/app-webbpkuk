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
            if (strtolower($selectedJenis) === 'tips' || strtolower($selectedJenis) === 'info') {
                $query->whereIn('jenis', ['Tips', 'Info', 'Info dan Tips']);
            } else {
                $query->where('jenis', $selectedJenis);
            }
        }

        // Filter by Kategori ID
        if (!empty($selectedKategori)) {
            $query->where('id_kategori', $selectedKategori);
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
        $popularHashtags = Hashtag::withCount('posts')->orderByDesc('posts_count')->take(10)->get();
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
}
