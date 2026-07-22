<?php

namespace App\Livewire\Admin\Layanan;

use App\Models\Layanan;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class Delete extends Component
{
    
    protected $listeners = [
        'hapusLayanan'
    ];

    public function hapusLayanan($id_layanan)
    {

        $layanan=Layanan::findOrFail($id_layanan);

        if($layanan->thumbnail){
            Storage::disk('public')->delete('layanan/'.$layanan->thumbnail);
        }

        $layanan->delete();

        $this->dispatch('layanan-refresh');

        $this->dispatch('swal',
            icon: 'success',
            title: 'Berhasil',
            text: 'Data berhasil dihapus.'
        );
    }

    public function render()
    {
        return view('livewire.admin.layanan.delete');
    }
}

