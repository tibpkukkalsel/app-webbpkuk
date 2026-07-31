<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Storganisasi;
use App\Models\Tentang;
use App\Models\Identitas;

class StorganisasiController extends Controller
{
    public function view()
    {
        $storganisasi = Storganisasi::orderBy('id_storganisasi')->get();
        $tentang = Tentang::all();
        $identitas = Identitas::all();

        return view('websites.profile.struktur-organisasi.view', compact('storganisasi', 'tentang', 'identitas'));
    }
}
