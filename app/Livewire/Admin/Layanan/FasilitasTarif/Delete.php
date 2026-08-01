<?php

namespace App\Livewire\Admin\Layanan\FasilitasTarif;

use App\Models\FasilitasTarif;
use Livewire\Component;

class Delete extends Component
{
    protected $listeners = [
        'hapusTarif'
    ];

    public function hapusTarif($id_tarif)
    {
        $tarif = FasilitasTarif::findOrFail($id_tarif);
        $tarif->delete();

        $this->dispatch('tarif-refresh');
        $this->dispatch('swal',
            icon: 'success',
            title: 'Berhasil',
            text: 'Tarif fasilitas berhasil dihapus.'
        );
    }

    public function render()
    {
        return view('livewire.admin.layanan.fasilitas_tarif.delete');
    }
}
