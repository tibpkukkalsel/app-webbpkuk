<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Tentang;
use App\Models\Identitas;

class TentangController extends Controller
{
    public function view()
    {
        $tentang = Tentang::orderBy('id_tentang')->get();
        $identitas = Identitas::all();

        return view('websites.profile.tentang.view', compact('tentang', 'identitas'));
    }
}
