<?php

namespace App\Livewire\Admin\Video;

use App\Services\VideoService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $perPage = 10;

    protected VideoService $videoService;

    protected $listeners = [
        'video-refresh' => '$refresh'
    ];

    public function boot(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

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
        $videos = $this->videoService->getPaginatedData($this->search, $this->perPage);

        return view('livewire.admin.video.index', compact('videos'));
    }
}
