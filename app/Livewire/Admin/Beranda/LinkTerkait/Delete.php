<?php

namespace App\Livewire\Admin\Beranda\LinkTerkait;

use App\Models\LinkTerkait;
use App\Services\LinkTerkaitService;
use Livewire\Component;

class Delete extends Component
{
    protected $listeners = [
        'hapusLinkTerkait'
    ];

    public function hapusLinkTerkait($id, LinkTerkaitService $service)
    {
        $service->delete($id);

        $this->dispatch('link-terkait-refresh');
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Link terkait berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.beranda.link-terkait.delete');
    }
}
