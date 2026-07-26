<?php

namespace App\Livewire\Admin\Info;

use App\Services\PostService;
use Livewire\Component;

class Delete extends Component
{
    protected PostService $postService;

    protected $listeners=[
        'hapusInfo'
    ];

    public function boot(PostService $postService)
    {
        $this->postService=$postService;
    }

    public function hapusInfo($id_post)
    {
        $this->postService
            ->hapus($id_post);

        $this->dispatch('info-refresh');

        $this->dispatch('swal',
            icon:'success',
            title:'Berhasil',
            text:'Data berhasil dihapus.'
        );
    }

    public function render()
    {
        return view('livewire.admin.info.delete');
    }
}
