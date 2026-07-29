<?php

namespace App\Livewire\Admin\Infografis;

use App\Models\Infografis;
use App\Services\InfografisService;
use Livewire\Component;

class Delete extends Component
{
    public $id_infografis;
    public $judul;

    protected $listeners = [
        'konfirmasiHapusInfografis'
    ];

    public function konfirmasiHapusInfografis($id)
    {
        $data = Infografis::findOrFail($id);
        $this->id_infografis = $data->id_infografis;
        $this->judul         = $data->judul;
    }

    public function hapus(InfografisService $service)
    {
        $service->delete($this->id_infografis);

        $this->dispatch('infografis-refresh');
        $this->dispatch('close-modal-delete-infografis');
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data infografis berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.infografis.delete');
    }
}
