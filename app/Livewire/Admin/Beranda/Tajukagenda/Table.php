<?php

namespace App\Livewire\Admin\Beranda\Tajukagenda;

use App\Models\Beranda;
use Livewire\Component;

class Table extends Component
{
        protected $listeners=[
        'beranda-refresh'=>'$refresh'
    ];

    public function render()
    {
        return view('livewire.admin.beranda.tajukagenda.table',[
            'beranda'=>Beranda::where('jenis', 'Agenda')->orderBy('id_beranda')->get()
        ]);
    }
    
}

