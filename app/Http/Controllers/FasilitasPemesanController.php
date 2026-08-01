<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FasilitasPemesanController extends Controller
{
    public function view()
    {
        return view('admin.layanan.fasilitas_pemesan.view');
    }
}
