<?php

namespace App\Livewire\Admin\Kategori;

use App\Models\Kategori;
use Livewire\Component;

class Delete extends Component
{
    protected $listeners = [
        'hapusKategori'
    ];

    public function hapusKategori($id_kategori)
    {
        Kategori::findOrFail($id_kategori)->delete();

        $this->dispatch('kategori-refresh');

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