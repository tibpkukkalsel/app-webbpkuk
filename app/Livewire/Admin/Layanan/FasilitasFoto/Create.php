<?php

namespace App\Livewire\Admin\Layanan\FasilitasFoto;

use App\Models\FasilitasFoto;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $id_fasilitas;
    public $foto;
    public $urutan = 0;
    public $status = 1;

    public function mount($id_fasilitas)
    {
        $this->id_fasilitas = $id_fasilitas;
    }

    public function simpan()
    {
        $this->validate([
            'foto'    => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'urutan'  => 'nullable|integer|min:0',
            'status'  => 'required|in:0,1',
        ]);

        $namaFile = time() . '_' . uniqid() . '.' . $this->foto->getClientOriginalExtension();
        $this->foto->storeAs('fasilitas_foto', $namaFile, 'public');

        FasilitasFoto::create([
            'id_fasilitas' => $this->id_fasilitas,
            'foto'         => $namaFile,
            'urutan'       => $this->urutan ?? 0,
            'status'       => $this->status,
        ]);

        $this->reset(['foto', 'urutan', 'status']);
        $this->status = 1;

        $this->dispatch('foto-refresh');
        $this->dispatch('foto-created');
    }

    public function render()
    {
        return view('livewire.admin.layanan.fasilitas_foto.create');
    }
}
