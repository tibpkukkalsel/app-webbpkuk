<?php

namespace App\Livewire\Admin\Layanan\FasilitasRiwayat;

use App\Models\FasilitasRiwayat;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $filterAktivitas = '';
    public $perPage = 15;

    protected $listeners = [
        'riwayat-refresh' => '$refresh'
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterAktivitas()
    {
        $this->resetPage();
    }

    public function render()
    {
        $riwayats = FasilitasRiwayat::with(['user', 'fasilitas', 'pemesanan.details.fasilitas'])
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('nomor_booking', 'like', '%' . $this->search . '%')
                        ->orWhere('aktivitas', 'like', '%' . $this->search . '%')
                        ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterAktivitas, function ($q) {
                $q->where('aktivitas', 'like', '%' . $this->filterAktivitas . '%');
            })
            ->orderBy('id_riwayat', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.layanan.fasilitas_riwayat.table', compact('riwayats'));
    }
}
