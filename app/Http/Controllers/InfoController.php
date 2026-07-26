<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function view(){

        return view('admin.info.view');
        
    }

    public function create(){

        return view('admin.info.create');
        
    }

    public function edit($id)
    {
        return view('admin.info.edit',[
            'id'=>$id
        ]);
    }
}
