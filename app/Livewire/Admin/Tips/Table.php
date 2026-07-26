<?php

namespace App\Livewire\Admin\Tips;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $perPage = 10;

    protected $listeners = [
        'tips-refresh' => '$refresh'
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
            ->where('jenis','Tips')
            ->where('judul','like','%'.$this->search.'%')
            ->orderByDesc('id_post')
            ->paginate($this->perPage);

        return view('livewire.admin.tips.table', compact('post'));
    }

}
