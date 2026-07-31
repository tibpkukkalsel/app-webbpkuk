<?php

namespace App\Livewire\Admin\Seksi;

use App\Models\Seksi;
use Livewire\Component;

class Delete extends Component
{
    protected $listeners = [
        'hapusSeksi' => 'delete'
    ];

    public function delete($id_seksi)
    {
        Seksi::findOrFail($id_seksi)->delete();
        $this->dispatch('seksi-refresh');
    }

    public function render()
    {
        return view('livewire.admin.seksi.delete');
    }
}
