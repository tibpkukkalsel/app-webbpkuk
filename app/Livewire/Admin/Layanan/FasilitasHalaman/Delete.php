<?php

namespace App\Livewire\Admin\Layanan\FasilitasHalaman;

use App\Models\FasilitasHalaman;
use Livewire\Component;

class Delete extends Component
{
    protected $listeners = [
        'hapusHalaman'
    ];

    public function hapusHalaman($id_halaman)
    {
        $halaman = FasilitasHalaman::findOrFail($id_halaman);
        $halaman->delete();

        $this->dispatch('halaman-refresh');
        $this->dispatch('swal',
            icon: 'success',
            title: 'Berhasil',
            text: 'Halaman fasilitas berhasil dihapus.'
        );
    }

    public function render()
    {
        return view('livewire.admin.layanan.fasilitas_halaman.delete');
    }
}
