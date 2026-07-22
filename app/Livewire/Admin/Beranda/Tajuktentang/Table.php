<?php

namespace App\Livewire\Admin\Beranda\Tajuktentang;

use App\Models\Beranda;
use Livewire\Component;

class Table extends Component
{
        protected $listeners=[
        'beranda-refresh'=>'$refresh'
    ];

    public function render()
    {
        return view('livewire.admin.beranda.tajuktentang.table',[
            'beranda'=>Beranda::where('jenis', 'Tentang')->orderBy('id_beranda')->get()
        ]);
    }
    
}
