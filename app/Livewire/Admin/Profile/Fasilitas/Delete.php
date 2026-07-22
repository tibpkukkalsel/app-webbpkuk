<?php

namespace App\Livewire\Admin\Profile\Fasilitas;

use App\Models\Fasilitas;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class Delete extends Component
{
    
    protected $listeners = [
        'hapusFasilitas'
    ];

    public function hapusFasilitas($id_fasilitas)
    {

        $fasilitas=Fasilitas::findOrFail($id_fasilitas);

        if($fasilitas->gambar){
            Storage::disk('public')->delete('fasilitas/'.$fasilitas->gambar);
        }

        $fasilitas->delete();

        $this->dispatch('fasilitas-refresh');

        $this->dispatch('swal',
            icon: 'success',
            title: 'Berhasil',
            text: 'Data berhasil dihapus.'
        );
    }

    public function render()
    {
        return view('livewire.admin.profile.fasilitas.delete');
    }
}
