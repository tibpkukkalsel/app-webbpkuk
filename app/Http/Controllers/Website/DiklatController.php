<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Identitas;
use App\Models\Tentang;
use Illuminate\Http\Request;

class DiklatController extends Controller
{
    public function view()
    {
        $identitas = Identitas::all();
        $tentang   = Tentang::all();

        return view('websites.layanan.diklat.view', compact('identitas', 'tentang'));
    }

    public function identifikasi()
    {
        $identitas = Identitas::all();
        $tentang   = Tentang::all();

        return view('pengembangan.view', compact('identitas', 'tentang'));
    }

    public function sertifikat()
    {
        $identitas = Identitas::all();
        $tentang   = Tentang::all();

        return view('pengembangan.view', compact('identitas', 'tentang'));
    }

    public function survei()
    {
        $identitas = Identitas::all();
        $tentang   = Tentang::all();

        return view('pengembangan.view', compact('identitas', 'tentang'));
    }
}
