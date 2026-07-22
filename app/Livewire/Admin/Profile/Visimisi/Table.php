<?php

namespace App\Livewire\Admin\Profile\Visimisi;

use App\Models\Visimisi;
use Livewire\Component;

class Table extends Component
{
        protected $listeners=[
        'profile-refresh'=>'$refresh'
    ];

    public function render()
    {
        return view('livewire.admin.profile.visimisi.table',[
            'profile'=>Visimisi::orderBy('nama', 'DESC')->get()
        ]);
    }
    
}
