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
}
