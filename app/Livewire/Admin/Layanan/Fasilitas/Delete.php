<?php

namespace App\Livewire\Admin\Layanan\Fasilitas;

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
        $fasilitas = Fasilitas::findOrFail($id_fasilitas);

        if ($fasilitas->thumbnail && Storage::disk('public')->exists('fasilitas/' . $fasilitas->thumbnail)) {
            Storage::disk('public')->delete('fasilitas/' . $fasilitas->thumbnail);
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
        return view('livewire.admin.layanan.fasilitas.delete');
    }
}
