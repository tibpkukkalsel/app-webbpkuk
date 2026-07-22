<?php

namespace App\Livewire\Admin\Identitas;

use App\Models\Identitas;
use Livewire\Component;

class Table extends Component
{
    protected $listeners=[
        'identitas-refresh'=>'$refresh'
    ];

    public function render()
    {
        return view('livewire.admin.identitas.table',[
            'identitas'=>Identitas::orderBy('id_identitas')->get()
        ]);
    }
}