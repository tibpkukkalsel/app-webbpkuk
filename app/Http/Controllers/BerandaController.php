<?php

namespace App\Http\Controllers;

use App\Models\Beranda;
use Illuminate\Http\Request;


class BerandaController extends Controller
{
    public function bannerutama_view(){
        
        return view('admin.beranda.bannerutama.view');
    }

    public function bannercard_view(){
        
        return view('admin.beranda.bannercard.view');
    }

    public function mitra_view(){
        
        return view('admin.beranda.mitra.view');
    }

    public function tajuktentang_view(){
        
        return view('admin.beranda.tajuktentang.view');
    }

    public function tajukcard_view(){
        
        return view('admin.beranda.tajukcard.view');
    }
    public function tajukagenda_view(){
        
        return view('admin.beranda.tajukagenda.view');
    }
}
