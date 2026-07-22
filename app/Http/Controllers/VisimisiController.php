<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VisimisiController extends Controller
{
    public function view(){

        return view('admin.profile.visimisi.view');
    }
    
}
