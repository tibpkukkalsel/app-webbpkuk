<?php

namespace App\Livewire\Admin\Beranda\LinkTerkait;

use App\Services\LinkTerkaitService;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'link-terkait-refresh' => '$refresh'
    ];

    public function render(LinkTerkaitService $service)
    {
        return view('livewire.admin.beranda.link-terkait.table', [
            'linkTerkaitList' => $service->getAllPaginated(10)
        ]);
    }
}
