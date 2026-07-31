<?php

namespace App\Livewire\Admin\Jabatan;

use App\Models\Jabatan;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $perPage = 10;

    protected $listeners = [
        'jabatan-refresh' => '$refresh'
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
        $jabatan = Jabatan::where('jabatan', 'like', '%'.$this->search.'%')
            ->orWhere('kelas', 'like', '%'.$this->search.'%')
            ->orderBy('id_jabatan', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.jabatan.table', compact('jabatan'));
    }
}
