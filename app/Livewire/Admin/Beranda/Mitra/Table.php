<?php

namespace App\Livewire\Admin\Beranda\Mitra;

use App\Models\Beranda;
use Livewire\Component;

class Table extends Component
{

        protected $listeners=[
        'beranda-refresh'=>'$refresh'
    ];

    public function render()
    {
        return view('livewire.admin.beranda.mitra.table',[
            'beranda'=>Beranda::where('jenis', 'Brand')->orderBy('id_beranda')->get()
        ]);
    }
    
}
