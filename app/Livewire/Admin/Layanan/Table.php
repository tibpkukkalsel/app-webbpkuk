<?php

namespace App\Livewire\Admin\Layanan;

use App\Models\Layanan;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $perPage = 10;

    protected $listeners = [
        'layanan-refresh' => '$refresh'
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
        $layanan = Layanan::where('nama', 'like', '%'.$this->search.'%')
                    ->orderBy('id_layanan', 'desc')
                    ->paginate($this->perPage);

        return view('livewire.admin.layanan.table', compact('layanan'));
    }

    


}

