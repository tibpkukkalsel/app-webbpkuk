<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Visimisi;
use App\Models\Tentang;
use App\Models\Identitas;

class VisimisiController extends Controller
{
    public function view()
    {
        $visimisi = Visimisi::orderBy('id_visimisi')->get();
        $tentang = Tentang::all();
        $identitas = Identitas::all();

        return view('websites.profile.visimisi.view', compact('visimisi', 'tentang', 'identitas'));
    }
}
