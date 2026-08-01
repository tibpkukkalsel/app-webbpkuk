<?php

namespace App\Livewire\Admin\Layanan\FasilitasTarif;

use App\Models\FasilitasTarif;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $id_fasilitas;
    public $search = '';
    public $perPage = 10;

    protected $listeners = [
        'tarif-refresh' => '$refresh'
    ];

    public function mount($id_fasilitas)
    {
        $this->id_fasilitas = $id_fasilitas;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $tarifs = FasilitasTarif::where('id_fasilitas', $this->id_fasilitas)
            ->where(function ($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                  ->orWhere('satuan', 'like', '%' . $this->search . '%');
            })
            ->orderBy('tanggal_mulai', 'desc')
            ->orderBy('id_tarif', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.layanan.fasilitas_tarif.table', compact('tarifs'));
    }
}
