<?php

namespace App\Livewire\Admin\Beranda\LinkTerkait;

use App\Models\LinkTerkait;
use App\Services\LinkTerkaitService;
use Livewire\Component;

class Delete extends Component
{
    public $id_link_terkait;
    public $nama;

    protected $listeners = [
        'konfirmasiHapusLinkTerkait'
    ];

    public function konfirmasiHapusLinkTerkait($id)
    {
        $data = LinkTerkait::findOrFail($id);
        $this->id_link_terkait = $data->id_link_terkait;
        $this->nama            = $data->nama;
    }

    public function hapus(LinkTerkaitService $service)
    {
        $service->delete($this->id_link_terkait);

        $this->dispatch('link-terkait-refresh');
        $this->dispatch('close-modal-delete-link');
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Link terkait berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.beranda.link-terkait.delete');
    }
}
