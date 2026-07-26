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
