<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TipsController extends Controller
{
    public function view(){

        return view('admin.tips.view');
        
    }

    public function create(){

        return view('admin.tips.create');
        
    }

    public function edit($id)
    {
        return view('admin.tips.edit',[
            'id'=>$id
        ]);
    }
}
