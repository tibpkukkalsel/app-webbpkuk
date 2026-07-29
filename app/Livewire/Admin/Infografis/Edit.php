<?php

namespace App\Livewire\Admin\Infografis;

use App\Models\Infografis;
use App\Services\InfografisService;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public $id_infografis;
    public $judul;
    public $link;
    public $gambarBaru;
    public $gambarLama;
    public $urutan;
    public $status;

    protected $listeners = [
        'editInfografis'
    ];

    public function editInfografis($id)
    {
        $data = Infografis::findOrFail($id);

        $this->id_infografis = $data->id_infografis;
        $this->judul         = $data->judul;
        $this->link          = $data->link;
        $this->gambarLama    = $data->gambar;
        $this->gambarBaru    = null;
        $this->urutan        = $data->urutan;
        $this->status        = $data->status;
    }

    public function simpan(InfografisService $service)
    {
        $rules = [
            'judul'      => 'required|string|max:150',
            'link'       => 'nullable|url|max:255',
            'gambarBaru' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'urutan'     => 'required|integer|min:1|max:10',
            'status'     => 'required|in:aktif,nonaktif',
        ];

        $this->validate($rules);

        $service->update($this->id_infografis, [
            'judul'  => $this->judul,
            'link'   => $this->link,
            'urutan' => $this->urutan,
            'status' => $this->status,
        ], $this->gambarBaru);

        $this->dispatch('infografis-refresh');
        $this->dispatch('close-modal-edit');
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data infografis berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.infografis.edit');
    }
}
