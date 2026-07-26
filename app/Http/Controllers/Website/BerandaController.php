<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Identitas;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function view(){

        $identitas = Identitas::all();

        return view('layouts.websites', compact('identitas'));
    }
}
