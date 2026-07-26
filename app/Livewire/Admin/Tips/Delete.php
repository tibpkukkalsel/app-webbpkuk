<?php

namespace App\Livewire\Admin\Tips;

use App\Services\PostService;
use Livewire\Component;

class Delete extends Component
{
    protected PostService $postService;

    protected $listeners=[
        'hapusTips'
    ];

    public function boot(PostService $postService)
    {
        $this->postService=$postService;
    }

    public function hapusTips($id_post)
    {
        $this->postService
            ->hapus($id_post);

        $this->dispatch('tips-refresh');

        $this->dispatch('swal',
            icon:'success',
            title:'Berhasil',
            text:'Data berhasil dihapus.'
        );
    }

    public function render()
    {
        return view('livewire.admin.tips.delete');
    }
}
