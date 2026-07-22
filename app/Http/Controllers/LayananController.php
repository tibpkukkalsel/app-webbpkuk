<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function view(){

        return view('admin.layanan.view');
        
    }

    public function create(){

        return view('admin.layanan.create');
        
    }

    public function edit($id_layanan)
    {
    return view('admin.layanan.edit',compact('id_layanan'));
    }

}
