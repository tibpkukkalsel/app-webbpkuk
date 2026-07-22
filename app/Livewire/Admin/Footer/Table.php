<?php

namespace App\Livewire\Admin\Footer;

use App\Models\Footer;
use Livewire\Component;

class Table extends Component
{
    protected $listeners=[
        'footer-refresh'=>'$refresh'
    ];

    public function render()
    {
        return view('livewire.admin.footer.table',[
            'footer'=>Footer::orderBy('id_footer')->get()
        ]);
    }
}