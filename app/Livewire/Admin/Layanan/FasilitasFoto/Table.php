<?php

namespace App\Livewire\Admin\Layanan\FasilitasFoto;

use App\Models\FasilitasFoto;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $id_fasilitas;
    public $search = '';
    public $perPage = 12;

    protected $listeners = [
        'foto-refresh' => '$refresh'
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
        $fotos = FasilitasFoto::where('id_fasilitas', $this->id_fasilitas)
            ->orderBy('urutan', 'asc')
            ->orderBy('id_foto', 'asc')
            ->paginate($this->perPage);

        return view('livewire.admin.layanan.fasilitas_foto.table', compact('fotos'));
    }
}
