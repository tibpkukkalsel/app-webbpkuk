<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    public function view(){
        return view('admin.profile.fasilitas.view');
    }
}
