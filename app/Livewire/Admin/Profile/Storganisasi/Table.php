<?php

namespace App\Livewire\Admin\Profile\Storganisasi;

use App\Models\Storganisasi;
use Livewire\Component;

class Table extends Component
{
        protected $listeners=[
        'profile-refresh'=>'$refresh'
    ];

    public function render()
    {
        return view('livewire.admin.profile.storganisasi.table',[
            'profile'=>Storganisasi::orderBy('nama', 'DESC')->get()
        ]);
    }
    
}
