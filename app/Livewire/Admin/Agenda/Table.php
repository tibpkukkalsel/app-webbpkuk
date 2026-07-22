<?php

namespace App\Livewire\Admin\Agenda;

use App\Models\Agenda;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $perPage = 10;

    protected $listeners = [
        'agenda-refresh' => '$refresh'
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
        $agenda = Agenda::where('nama', 'like', '%'.$this->search.'%')
            ->orderBy('id_agenda', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.agenda.table', compact('agenda'));
    }
}
