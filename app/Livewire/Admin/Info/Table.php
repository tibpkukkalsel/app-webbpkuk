<?php

namespace App\Livewire\Admin\Info;

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
        'info-refresh' => '$refresh'
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
            ->whereIn('jenis',['Info dan Tips','Info','Tips','Info Tips'])
            ->where('judul','like','%'.$this->search.'%')
            ->orderByDesc('id_post')
            ->paginate($this->perPage);

        return view('livewire.admin.info.table', compact('post'));
    }

}
