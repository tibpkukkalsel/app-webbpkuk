<?php

namespace App\Livewire\Admin\Beranda\LinkTerkait;

use App\Models\LinkTerkait;
use App\Services\LinkTerkaitService;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public $id_link_terkait;
    public $nama;
    public $url;
    public $gambarBaru;
    public $gambarLama;
    public $urutan;
    public $status;

    protected $listeners = [
        'editLinkTerkait'
    ];

    public function editLinkTerkait($id)
    {
        $data = LinkTerkait::findOrFail($id);

        $this->id_link_terkait = $data->id_link_terkait;
        $this->nama            = $data->nama;
        $this->url             = $data->url;
        $this->gambarLama      = $data->gambar;
        $this->gambarBaru      = null;
        $this->urutan          = $data->urutan;
        $this->status          = $data->status;

        $this->resetErrorBag();
    }

    public function simpan(LinkTerkaitService $service)
    {
        if ($this->url && !preg_match('/^https?:\/\//i', $this->url)) {
            $this->url = 'https://' . $this->url;
        }

        $rules = [
            'nama'       => 'required|string|max:150',
            'url'        => 'required|url|max:255',
            'gambarBaru' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'urutan'     => 'required|integer|min:1|max:20',
            'status'     => 'required|in:aktif,nonaktif',
        ];

        $this->validate($rules);

        $service->update($this->id_link_terkait, [
            'nama'   => $this->nama,
            'url'    => $this->url,
            'urutan' => $this->urutan,
            'status' => $this->status,
        ], $this->gambarBaru);

        $this->dispatch('link-terkait-refresh');
        $this->dispatch('close-modal-edit-link');
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Link terkait berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.beranda.link-terkait.edit');
    }
}
