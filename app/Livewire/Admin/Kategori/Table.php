<?php

namespace App\Livewire\Admin\Kategori;

use App\Models\Kategori;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $perPage = 10;

    protected $listeners = [
        'kategori-refresh' => '$refresh'
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
        $kategori = Kategori::where('kategori', 'like', '%'.$this->search.'%')
            ->orderBy('id_kategori', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.kategori.table', compact('kategori'));
    }
}