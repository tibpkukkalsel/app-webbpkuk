<?php

namespace App\Livewire\Admin\Artikel;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $perPage = 10;

    protected $listeners = [
        'artikel-refresh' => '$refresh'
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function accPost($id)
    {
        if (!auth()->user()->hasRole('Superadmin')) {
            $this->dispatch('swal', icon: 'error', title: 'Akses Ditolak', text: 'Hanya Superadmin yang dapat me-ACC postingan.');
            return;
        }

        Post::where('id_post', $id)->update(['status' => 2]);
        $this->dispatch('swal', icon: 'success', title: 'Berhasil ACC', text: 'Artikel berhasil di-ACC dan dipublikasikan.');
        $this->dispatch('artikel-refresh');
    }

    public function cancelPost($id)
    {
        if (!auth()->user()->hasRole('Superadmin')) {
            $this->dispatch('swal', icon: 'error', title: 'Akses Ditolak', text: 'Hanya Superadmin yang dapat membatalkan postingan.');
            return;
        }

        Post::where('id_post', $id)->update(['status' => 0]);
        $this->dispatch('swal', icon: 'info', title: 'Dibatalkan', text: 'Status artikel dikembalikan ke Draft.');
        $this->dispatch('artikel-refresh');
    }

    public function render()
    {
        $post=Post::with(['kategori','user'])
            ->where('jenis','Artikel')
            ->where('judul','like','%'.$this->search.'%')
            ->orderByDesc('id_post')
            ->paginate($this->perPage);

        return view('livewire.admin.artikel.table', compact('post'));
    }
}
