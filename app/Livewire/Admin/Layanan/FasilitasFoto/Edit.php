<?php

namespace App\Livewire\Admin\Layanan\FasilitasFoto;

use App\Models\FasilitasFoto;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public $id_foto;
    public $foto;
    public $fotoLama;
    public $urutan;
    public $status = 1;

    protected $listeners = [
        'editFoto' => 'loadFoto'
    ];

    public function loadFoto($id_foto)
    {
        $data = FasilitasFoto::findOrFail($id_foto);
        $this->id_foto  = $data->id_foto;
        $this->fotoLama = $data->foto;
        $this->foto     = null;
        $this->urutan   = $data->urutan;
        $this->status   = $data->status;
        $this->resetErrorBag();
    }

    public function simpan()
    {
        $this->validate([
            'foto'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'urutan' => 'nullable|integer|min:0',
            'status' => 'required|in:0,1',
        ]);

        $updateData = [
            'urutan' => $this->urutan ?? 0,
            'status' => $this->status,
        ];

        if ($this->foto) {
            if ($this->fotoLama && Storage::disk('public')->exists('fasilitas_foto/' . $this->fotoLama)) {
                Storage::disk('public')->delete('fasilitas_foto/' . $this->fotoLama);
            }
            $namaFile = time() . '_' . uniqid() . '.' . $this->foto->getClientOriginalExtension();
            $this->foto->storeAs('fasilitas_foto', $namaFile, 'public');
            $updateData['foto'] = $namaFile;
        }

        FasilitasFoto::where('id_foto', $this->id_foto)->update($updateData);

        $this->dispatch('foto-refresh');
        $this->dispatch('close-edit-foto-modal');
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Foto berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.layanan.fasilitas_foto.edit');
    }
}
