<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeksiController extends Controller
{
    public function view()
    {
        return view('admin.seksi.view');
    }
}
