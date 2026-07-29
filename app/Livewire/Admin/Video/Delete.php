<?php

namespace App\Livewire\Admin\Video;

use App\Services\VideoService;
use Livewire\Component;

class Delete extends Component
{
    protected VideoService $videoService;

    protected $listeners = [
        'hapusVideo'
    ];

    public function boot(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

    public function hapusVideo($id_video)
    {
        $this->videoService->hapus($id_video);

        $this->dispatch('video-refresh');

        $this->dispatch('swal',
            icon: 'success',
            title: 'Berhasil',
            text: 'Data video berhasil dihapus.'
        );
    }

    public function render()
    {
        return view('livewire.admin.video.delete');
    }
}
