<?php

namespace App\Livewire\Admin\Seksi;

use App\Models\Seksi;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $perPage = 10;

    protected $listeners = [
        'seksi-refresh' => '$refresh'
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
        $seksi = Seksi::where('seksi', 'like', '%'.$this->search.'%')
            ->orderBy('id_seksi', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.seksi.table', compact('seksi'));
    }
}
