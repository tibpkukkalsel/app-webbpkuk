<?php

namespace App\Livewire\Admin\HeroBanner;

use App\Models\HeroBanner;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'hero-banner-refresh' => '$refresh'
    ];

    public function render()
    {
        return view('livewire.admin.hero-banner.table', [
            'heroBanners' => HeroBanner::orderBy('urutan')->orderBy('id_hero_banner')->paginate(10)
        ]);
    }
}
