<?php

namespace App\Livewire\Admin\Layanan\Fasilitas;

use App\Models\Fasilitas;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $thumbnail;
    public $nama = '';
    public $kode = '';
    public $deskripsi = '';
    public $kapasitas = '';
    public $jumlah = '';
    public $lokasi = '';
    public $status = 1;

    public function simpan()
    {
        $this->validate([
            'thumbnail' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'nama'      => 'required|string|max:255',
            'kode'      => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
            'kapasitas' => 'nullable|integer|min:0',
            'jumlah'    => 'nullable|integer|min:0',
            'lokasi'    => 'nullable|string|max:255',
            'status'    => 'required|in:0,1',
        ]);

        $namaFile = time() . '_' . uniqid() . '.' . $this->thumbnail->getClientOriginalExtension();
        $this->thumbnail->storeAs('fasilitas', $namaFile, 'public');

        Fasilitas::create([
            'thumbnail' => $namaFile,
            'nama'      => $this->nama,
            'slug'      => Fasilitas::generateSlug($this->nama),
            'kode'      => $this->kode ?: null,
            'deskripsi' => $this->deskripsi,
            'kapasitas' => $this->kapasitas ?: null,
            'jumlah'    => $this->jumlah ?: null,
            'lokasi'    => $this->lokasi,
            'status'    => $this->status,
        ]);

        $this->reset();
        $this->status = 1;

        $this->dispatch('fasilitas-refresh');
        $this->dispatch('fasilitas-created');
        $this->dispatch('swal', icon: 'success', title: 'Berhasil!', text: 'Data fasilitas baru berhasil ditambahkan.');
    }

    public function render()
    {
        return view('livewire.admin.layanan.fasilitas.create');
    }
}
