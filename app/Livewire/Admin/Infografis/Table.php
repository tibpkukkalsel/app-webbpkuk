<?php

namespace App\Livewire\Admin\Infografis;

use App\Services\InfografisService;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'infografis-refresh' => '$refresh'
    ];

    public function render(InfografisService $service)
    {
        return view('livewire.admin.infografis.table', [
            'infografisList' => $service->getAllPaginated(10)
        ]);
    }
}
