<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function view(Request $request)
    {
        $tab = $request->get('tab', 'wilayah');
        return view('admin.layanan.view', compact('tab'));
    }

    public function create()
    {
        return view('admin.layanan.create');
    }

    public function edit($id_layanan)
    {
        return view('admin.layanan.edit', compact('id_layanan'));
    }
}
