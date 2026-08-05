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
        $post = \App\Models\Post::find($id_post);
        if ($post && $post->id_user != auth()->id() && !auth()->user()->hasRole('Superadmin')) {
            $this->dispatch('swal',
                icon: 'error',
                title: 'Akses Ditolak',
                text: 'Anda tidak berhak menghapus info & tips milik pengguna lain.'
            );
            return;
        }

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
