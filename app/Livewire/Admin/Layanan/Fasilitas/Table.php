<?php

namespace App\Livewire\Admin\Layanan\Fasilitas;

use App\Models\Fasilitas;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $perPage = 10;

    protected $listeners = [
        'fasilitas-refresh' => '$refresh'
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        $fasilitas = Fasilitas::where('nama', 'like', '%'.$this->search.'%')
            ->orderBy('id_fasilitas', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.layanan.fasilitas.table', compact('fasilitas'));
    }
}
