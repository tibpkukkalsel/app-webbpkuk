<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HeroBannerController extends Controller
{
    public function view()
    {
        return view('admin.hero-banner.view');
    }
}
