<?php

namespace App\Livewire\Admin\Beranda\Tajukcard;

use App\Models\Beranda;
use Livewire\Component;

class Table extends Component
{
        protected $listeners=[
        'beranda-refresh'=>'$refresh'
    ];

    public function render()
    {
        return view('livewire.admin.beranda.tajukcard.table',[
            'beranda'=>Beranda::where('jenis', 'Card')->orderBy('id_beranda')->get()
        ]);
    }
    
}
