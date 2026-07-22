<?php

namespace App\Livewire\Admin\Agenda;

use App\Models\Agenda;
use Livewire\Component;

class Delete extends Component
{
    protected $listeners = [
        'hapusAgenda'
    ];

    public function hapusAgenda($id_agenda)
    {
        Agenda::findOrFail($id_agenda)->delete();

        $this->dispatch('agenda-refresh');

        $this->dispatch('swal',
            icon: 'success',
            title: 'Berhasil',
            text: 'Data berhasil dihapus.'
        );
    }

    public function render()
    {
        return view('livewire.admin.kategori.delete');
    }
}