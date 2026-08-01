<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Models\FasilitasHalaman;
use App\Models\Tentang;
use App\Models\Identitas;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    public function view()
    {
        $fasilitas = Fasilitas::with(['fotos', 'tarifs' => function ($q) {
            $q->where('status', 1)->orderBy('tanggal_mulai', 'desc');
        }])
        ->where('status', 1)
        ->orderBy('id_fasilitas', 'asc')
        ->get();

        $halamans = FasilitasHalaman::where('status', 1)
            ->orderBy('urutan', 'asc')
            ->orderBy('id_halaman', 'asc')
            ->get();

        $tentang = Tentang::all();
        $identitas = Identitas::all();
        $currentHalaman = null;
        $isPesanOnline = false;
        $isCekStatus = false;

        return view('websites.layanan.fasilitas.view', compact('fasilitas', 'halamans', 'tentang', 'identitas', 'currentHalaman', 'isPesanOnline', 'isCekStatus'));
    }

    public function pesan()
    {
        $fasilitas = Fasilitas::with(['fotos', 'tarifs' => function ($q) {
            $q->where('status', 1)->orderBy('tanggal_mulai', 'desc');
        }])
        ->where('status', 1)
        ->orderBy('id_fasilitas', 'asc')
        ->get();

        $halamans = FasilitasHalaman::where('status', 1)
            ->orderBy('urutan', 'asc')
            ->orderBy('id_halaman', 'asc')
            ->get();

        $tentang = Tentang::all();
        $identitas = Identitas::all();
        $currentHalaman = null;
        $isPesanOnline = true;
        $isCekStatus = false;

        return view('websites.layanan.fasilitas.view', compact('fasilitas', 'halamans', 'tentang', 'identitas', 'currentHalaman', 'isPesanOnline', 'isCekStatus'));
    }

    public function cekStatus()
    {
        $fasilitas = Fasilitas::with(['fotos', 'tarifs' => function ($q) {
            $q->where('status', 1)->orderBy('tanggal_mulai', 'desc');
        }])
        ->where('status', 1)
        ->orderBy('id_fasilitas', 'asc')
        ->get();

        $halamans = FasilitasHalaman::where('status', 1)
            ->orderBy('urutan', 'asc')
            ->orderBy('id_halaman', 'asc')
            ->get();

        $tentang = Tentang::all();
        $identitas = Identitas::all();
        $currentHalaman = null;
        $isPesanOnline = false;
        $isCekStatus = true;

        return view('websites.layanan.fasilitas.view', compact('fasilitas', 'halamans', 'tentang', 'identitas', 'currentHalaman', 'isPesanOnline', 'isCekStatus'));
    }

    public function halaman($slug)
    {
        if ($slug === 'pesan-online') {
            return redirect()->route('website.layanan.fasilitas.pesan');
        }

        if ($slug === 'cek-status') {
            return redirect()->route('website.layanan.fasilitas.cekStatus');
        }

        $currentHalaman = FasilitasHalaman::where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        $fasilitas = Fasilitas::where('status', 1)->get();

        $halamans = FasilitasHalaman::where('status', 1)
            ->orderBy('urutan', 'asc')
            ->orderBy('id_halaman', 'asc')
            ->get();

        $tentang = Tentang::all();
        $identitas = Identitas::all();
        $isPesanOnline = false;
        $isCekStatus = false;

        return view('websites.layanan.fasilitas.view', compact('fasilitas', 'halamans', 'tentang', 'identitas', 'currentHalaman', 'isPesanOnline', 'isCekStatus'));
    }
}
