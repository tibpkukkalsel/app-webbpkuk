<?php

namespace App\Livewire\Admin\Pegawai;

use App\Models\Pegawai;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class Delete extends Component
{
    protected $listeners = [
        'hapusPegawai' => 'delete'
    ];

    public function delete($id_pegawai)
    {
        $pegawai = Pegawai::findOrFail($id_pegawai);

        if ($pegawai->foto && Storage::disk('public')->exists('pegawai/' . $pegawai->foto)) {
            Storage::disk('public')->delete('pegawai/' . $pegawai->foto);
        }

        $pegawai->delete();
        $this->dispatch('pegawai-refresh');
    }

    public function render()
    {
        return view('livewire.admin.pegawai.delete');
    }
}
