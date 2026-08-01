<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;

class FasilitasFotoController extends Controller
{
    public function view($id_fasilitas)
    {
        $fasilitas = Fasilitas::findOrFail($id_fasilitas);
        return view('admin.layanan.fasilitas_foto.view', compact('fasilitas'));
    }
}
