<?php

namespace App\Livewire\Admin\Beranda\Bannercard;

use App\Models\Beranda;
use Livewire\Component;

class Table extends Component
{

        protected $listeners=[
        'beranda-refresh'=>'$refresh'
    ];

    public function render()
    {
        return view('livewire.admin.beranda.bannercard.table',[
            'beranda'=>Beranda::where('jenis', 'Banner Secondary')->orderBy('id_beranda')->get()
        ]);
    }
    
}
