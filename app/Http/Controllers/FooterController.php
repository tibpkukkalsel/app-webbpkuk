<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function view(){

        $footer = Footer::all();

        return view('admin.footer.view', compact('footer'));
    }
    
}
