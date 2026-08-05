<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Identitas;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class PostCetakController extends Controller
{
    public function cetakPersetujuan($id)
    {
        $post = Post::with(['kategori', 'user', 'hashtags'])->findOrFail($id);
        $identitas = Identitas::all();

        // Cari Kepala Balai dari data Pegawai (jika ada)
        $kepalaBalai = Pegawai::with('jabatan')
            ->whereHas('jabatan', function ($q) {
                $q->where('jabatan', 'like', '%Kepala Balai%')
                  ->orWhere('jabatan', 'like', '%Kepala%');
            })
            ->where('status', 1)
            ->first();

        return view('admin.post.cetak-persetujuan', compact('post', 'identitas', 'kepalaBalai'));
    }
}
