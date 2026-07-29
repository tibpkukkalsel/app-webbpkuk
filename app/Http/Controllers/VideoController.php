<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function view()
    {
        return view('admin.video.view');
    }

    public function create()
    {
        return view('admin.video.create');
    }

    public function edit($id)
    {
        return view('admin.video.edit', [
            'id' => $id
        ]);
    }
}
