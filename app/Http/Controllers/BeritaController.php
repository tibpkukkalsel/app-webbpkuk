<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BeritaController extends Controller
{
        public function view(){

        return view('admin.berita.view');
        
    }

    public function create(){

        return view('admin.berita.create');
        
    }

    public function edit($id_post)
    {

    return view('admin.berita.edit',compact('id_post'));
    
    }
}
