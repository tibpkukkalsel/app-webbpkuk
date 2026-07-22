<?php

namespace App\Livewire\Admin\Beranda\Bannerutama;

use App\Models\Beranda;
use Livewire\Component;

class Table extends Component
{

        protected $listeners=[
        'bannerutama-refresh'=>'$refresh'
    ];

    public function render()
    {
        return view('livewire.admin.beranda.bannerutama.table',[
            'bannerutama'=>Beranda::where('jenis', 'Banner Primary')->orderBy('id_beranda')->get()
        ]);
    }
    
}
