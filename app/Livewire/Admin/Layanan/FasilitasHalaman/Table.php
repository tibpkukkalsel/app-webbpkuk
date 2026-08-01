<?php

namespace App\Livewire\Admin\Layanan\FasilitasHalaman;

use App\Models\FasilitasHalaman;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $perPage = 10;

    protected $listeners = [
        'halaman-refresh' => '$refresh'
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $halamans = FasilitasHalaman::where('judul', 'like', '%' . $this->search . '%')
            ->orWhere('slug', 'like', '%' . $this->search . '%')
            ->orderBy('urutan', 'asc')
            ->orderBy('id_halaman', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.layanan.fasilitas_halaman.table', compact('halamans'));
    }
}
