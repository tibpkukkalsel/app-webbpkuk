<?php

namespace App\Livewire\Admin\Layanan\Fasilitas;

use App\Models\Fasilitas;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public $id_fasilitas;
    public $thumbnail;
    public $thumbnailLama;
    public $nama;
    public $kode;
    public $deskripsi;
    public $kapasitas;
    public $jumlah;
    public $lokasi;
    public $status = 1;

    protected $listeners = [
        'edit'
    ];

    public function edit($id_fasilitas)
    {
        $data = Fasilitas::findOrFail($id_fasilitas);

        $this->id_fasilitas  = $data->id_fasilitas;
        $this->thumbnailLama = $data->thumbnail;
        $this->thumbnail     = null;
        $this->nama          = $data->nama;
        $this->kode          = $data->kode;
        $this->deskripsi     = $data->deskripsi;
        $this->kapasitas     = $data->kapasitas;
        $this->jumlah        = $data->jumlah;
        $this->lokasi        = $data->lokasi;
        $this->status        = $data->status;
        $this->resetErrorBag();
    }

    public function simpan()
    {
        $this->validate([
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'nama'      => 'required|string|max:255',
            'kode'      => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
            'kapasitas' => 'nullable|integer|min:0',
            'jumlah'    => 'nullable|integer|min:0',
            'lokasi'    => 'nullable|string|max:255',
            'status'    => 'required|in:0,1',
        ]);

        $updateData = [
            'nama'      => $this->nama,
            'slug'      => Fasilitas::generateSlug($this->nama, $this->id_fasilitas),
            'kode'      => $this->kode ?: null,
            'deskripsi' => $this->deskripsi,
            'kapasitas' => $this->kapasitas ?: null,
            'jumlah'    => $this->jumlah ?: null,
            'lokasi'    => $this->lokasi,
            'status'    => $this->status,
        ];

        if ($this->thumbnail) {
            if ($this->thumbnailLama && Storage::disk('public')->exists('fasilitas/' . $this->thumbnailLama)) {
                Storage::disk('public')->delete('fasilitas/' . $this->thumbnailLama);
            }
            $namaFile = time() . '_' . uniqid() . '.' . $this->thumbnail->getClientOriginalExtension();
            $this->thumbnail->storeAs('fasilitas', $namaFile, 'public');
            $updateData['thumbnail'] = $namaFile;
        }

        Fasilitas::where('id_fasilitas', $this->id_fasilitas)->update($updateData);

        $this->dispatch('fasilitas-refresh');
        $this->dispatch('close-edit-modal');
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.layanan.fasilitas.edit');
    }
}
