<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function view(){

        return view('admin.artikel.view');
        
    }

    public function create(){

        return view('admin.artikel.create');
        
    }

    public function edit($id)
    {
        return view('admin.artikel.edit',[
            'id'=>$id
        ]);
    }
}
