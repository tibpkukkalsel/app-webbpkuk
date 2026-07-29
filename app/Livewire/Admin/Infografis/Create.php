<?php

namespace App\Livewire\Admin\Infografis;

use App\Services\InfografisService;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $judul = '';
    public $gambar;
    public $link = '';
    public $urutan = 1;
    public $status = 'aktif';

    protected $rules = [
        'judul'  => 'required|string|max:150',
        'gambar' => 'required|image|mimes:jpg,jpeg,png,webp|max:3072',
        'link'   => 'nullable|url|max:255',
        'urutan' => 'required|integer|min:1|max:10',
        'status' => 'required|in:aktif,nonaktif',
    ];

    public function simpan(InfografisService $service)
    {
        $this->validate();

        $service->create([
            'judul'  => $this->judul,
            'link'   => $this->link,
            'urutan' => $this->urutan,
            'status' => $this->status,
        ], $this->gambar);

        $this->reset(['judul', 'gambar', 'link', 'urutan', 'status']);
        $this->urutan = 1;
        $this->status = 'aktif';

        $this->dispatch('infografis-refresh');
        $this->dispatch('close-modal-create');
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data infografis berhasil ditambahkan.');
    }

    public function render()
    {
        return view('livewire.admin.infografis.create');
    }
}
