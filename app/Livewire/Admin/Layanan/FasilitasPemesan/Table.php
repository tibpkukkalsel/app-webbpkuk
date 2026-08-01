<?php

namespace App\Livewire\Admin\Layanan\FasilitasPemesan;

use App\Models\FasilitasPemesan;
use App\Models\Fasilitas;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $filterStatus = '';
    public $filterFasilitas = '';
    public $perPage = 10;

    protected $listeners = [
        'pemesan-refresh' => '$refresh'
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterFasilitas()
    {
        $this->resetPage();
    }

    public function render()
    {
        $pemesanans = FasilitasPemesan::with(['details.fasilitas'])
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('nomor_booking', 'like', '%' . $this->search . '%')
                        ->orWhere('nama_pemohon', 'like', '%' . $this->search . '%')
                        ->orWhere('instansi', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('no_hp', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterStatus, function ($q) {
                $q->where('status', $this->filterStatus);
            })
            ->when($this->filterFasilitas, function ($q) {
                $q->whereHas('details', function ($det) {
                    $det->where('id_fasilitas', $this->filterFasilitas);
                });
            })
            ->orderBy('id_pemesanan', 'desc')
            ->paginate($this->perPage);

        $fasilitasOptions = Fasilitas::where('status', 1)->get();

        return view('livewire.admin.layanan.fasilitas_pemesan.table', compact('pemesanans', 'fasilitasOptions'));
    }
}
