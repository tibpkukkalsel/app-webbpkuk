<?php

namespace App\Livewire\Admin\Jabatan;

use App\Models\Jabatan;
use Livewire\Component;

class Delete extends Component
{
    protected $listeners = [
        'hapusJabatan' => 'delete'
    ];

    public function delete($id_jabatan)
    {
        Jabatan::findOrFail($id_jabatan)->delete();
        $this->dispatch('jabatan-refresh');
    }

    public function render()
    {
        return view('livewire.admin.jabatan.delete');
    }
}
