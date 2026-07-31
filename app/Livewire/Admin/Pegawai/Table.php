<?php

namespace App\Livewire\Admin\Pegawai;

use App\Models\Pegawai;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $perPage = 10;

    protected $listeners = [
        'pegawai-refresh' => '$refresh'
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
        $pegawai = Pegawai::with(['jabatan', 'seksi'])
            ->where(function ($q) {
                $q->where('nama', 'like', '%'.$this->search.'%')
                  ->orWhere('nip', 'like', '%'.$this->search.'%');
            })
            ->orderBy('id_pegawai', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.pegawai.table', compact('pegawai'));
    }
}
