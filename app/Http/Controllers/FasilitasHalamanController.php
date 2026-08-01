<?php

namespace App\Http\Controllers;

use App\Models\FasilitasHalaman;
use Illuminate\Http\Request;

class FasilitasHalamanController extends Controller
{
    public function view()
    {
        return view('admin.layanan.fasilitas_halaman.view');
    }

    public function create()
    {
        return view('admin.layanan.fasilitas_halaman.create');
    }

    public function edit($id)
    {
        $halaman = FasilitasHalaman::findOrFail($id);
        return view('admin.layanan.fasilitas_halaman.edit', compact('halaman'));
    }
}
