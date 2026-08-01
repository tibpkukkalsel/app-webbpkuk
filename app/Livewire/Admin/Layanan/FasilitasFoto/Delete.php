<?php

namespace App\Livewire\Admin\Layanan\FasilitasFoto;

use App\Models\FasilitasFoto;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class Delete extends Component
{
    protected $listeners = [
        'hapusFoto'
    ];

    public function hapusFoto($id_foto)
    {
        $foto = FasilitasFoto::findOrFail($id_foto);

        if ($foto->foto && Storage::disk('public')->exists('fasilitas_foto/' . $foto->foto)) {
            Storage::disk('public')->delete('fasilitas_foto/' . $foto->foto);
        }

        $foto->delete();

        $this->dispatch('foto-refresh');
        $this->dispatch('swal',
            icon: 'success',
            title: 'Berhasil',
            text: 'Foto berhasil dihapus.'
        );
    }

    public function render()
    {
        return view('livewire.admin.layanan.fasilitas_foto.delete');
    }
}
