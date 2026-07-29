<?php

namespace App\Livewire\Admin\HeroBanner;

use App\Models\HeroBanner;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $judul = '';
    public $gambar;
    public $urutan = 1;
    public $status = 'aktif';

    protected $rules = [
        'judul'  => 'required|string|max:150',
        'gambar' => 'required|image|mimes:jpg,jpeg,png,webp|max:3072',
        'urutan' => 'required|integer|min:1|max:10',
        'status' => 'required|in:aktif,nonaktif',
    ];

    public function simpan()
    {
        $this->validate();

        $namaFile = time() . '.' . $this->gambar->getClientOriginalExtension();
        $this->gambar->storeAs('hero-banner', $namaFile, 'public');

        HeroBanner::create([
            'judul'  => $this->judul,
            'gambar' => $namaFile,
            'urutan' => $this->urutan,
            'status' => $this->status,
        ]);

        $this->reset(['judul', 'gambar', 'urutan', 'status']);
        $this->urutan = 1;
        $this->status = 'aktif';

        $this->dispatch('hero-banner-refresh');
        $this->dispatch('close-modal-create');
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Gambar hero banner berhasil ditambahkan.');
    }

    public function render()
    {
        return view('livewire.admin.hero-banner.create');
    }
}
