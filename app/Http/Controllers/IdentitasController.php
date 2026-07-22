<?php

namespace App\Http\Controllers;

use App\Models\Identitas;
use Illuminate\Http\Request;

class IdentitasController extends Controller
{
    public function view() {

        $identitas = Identitas::all();

        return view('admin.identitas.view', compact('identitas'));
    }
}
