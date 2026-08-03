<?php

namespace App\Livewire\Admin\Kontak;

use App\Models\Kontak;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $filterStatus = '';
    public $perPage = 10;
    public $selectedKontakId = null;

    protected $listeners = [
        'kontak-refresh' => '$refresh',
        'select-kontak' => 'selectKontak',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function selectKontak($id)
    {
        $this->selectedKontakId = $id;
        $this->dispatch('open-detail-kontak', id: $id);
    }

    public function deleteKontak($id)
    {
        if (!auth()->user()->can('kontak.delete') && !auth()->user()->hasRole('Superadmin')) {
            session()->flash('error', 'Anda tidak memiliki akses untuk menghapus pesan.');
            return;
        }

        $kontak = Kontak::find($id);
        if ($kontak) {
            $kontak->delete();
            session()->flash('success', 'Pesan kontak berhasil dihapus.');
            $this->dispatch('kontak-refresh');
        }
    }

    public function render()
    {
        $kontaks = Kontak::withCount('balasan')
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('nama', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('subjek', 'like', '%' . $this->search . '%')
                        ->orWhere('pesan', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterStatus, function ($q) {
                $q->where('status', $this->filterStatus);
            })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        $unreadCount = Kontak::where('status', 'unread')->count();
        $readCount = Kontak::where('status', 'read')->count();
        $repliedCount = Kontak::where('status', 'replied')->count();

        return view('livewire.admin.kontak.table', compact('kontaks', 'unreadCount', 'readCount', 'repliedCount'));
    }
}
