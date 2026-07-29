<?php

namespace App\Livewire\Admin\Beranda\LinkTerkait;

use App\Services\LinkTerkaitService;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $nama = '';
    public $gambar;
    public $url = '';
    public $urutan = 1;
    public $status = 'aktif';

    protected $rules = [
        'nama'   => 'required|string|max:150',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
        'url'    => 'required|url|max:255',
        'urutan' => 'required|integer|min:1|max:20',
        'status' => 'required|in:aktif,nonaktif',
    ];

    public function simpan(LinkTerkaitService $service)
    {
        if ($this->url && !preg_match('/^https?:\/\//i', $this->url)) {
            $this->url = 'https://' . $this->url;
        }

        $this->validate();

        $service->create([
            'nama'   => $this->nama,
            'url'    => $this->url,
            'urutan' => $this->urutan,
            'status' => $this->status,
        ], $this->gambar);

        $this->reset(['nama', 'gambar', 'url', 'urutan', 'status']);
        $this->urutan = 1;
        $this->status = 'aktif';

        $this->dispatch('link-terkait-refresh');
        $this->dispatch('close-modal-create-link');
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Link terkait berhasil ditambahkan.');
    }

    public function render()
    {
        return view('livewire.admin.beranda.link-terkait.create');
    }
}
