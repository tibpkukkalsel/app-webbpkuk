<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function view(){
        return view('admin.agenda.view');
    }
}
