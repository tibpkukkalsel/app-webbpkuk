<?php

namespace App\Livewire\Admin\Profile\Tentang;

use App\Models\Tentang;
use Livewire\Component;

class Table extends Component
{
        protected $listeners=[
        'profile-refresh'=>'$refresh'
    ];

    public function render()
    {
        return view('livewire.admin.profile.tentang.table',[
            'profile'=>Tentang::orderBy('id_tentang')->get()
        ]);
    }
    
}
