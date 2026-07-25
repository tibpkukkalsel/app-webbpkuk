<?php

namespace App\Livewire\Admin\Hashtag;

use App\Models\Hashtag;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $perPage = 10;

    protected $listeners = [
        'hashtag-refresh' => '$refresh'
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
        $hashtag = Hashtag::where('hashtag', 'like', '%'.$this->search.'%')
            ->orderBy('id_hashtag', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.hashtag.table', compact('hashtag'));
    }
}
