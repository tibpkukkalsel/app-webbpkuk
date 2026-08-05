<?php

namespace App\Livewire\Admin\Berita;

use App\Services\PostService;
use Livewire\Component;

class Delete extends Component
{
    protected PostService $postService;

    protected $listeners=[
        'hapusBerita'
    ];

    public function boot(PostService $postService)
    {
        $this->postService=$postService;
    }

    public function hapusBerita($id_post)
    {
        $post = \App\Models\Post::find($id_post);
        if ($post && $post->id_user != auth()->id() && !auth()->user()->hasRole('Superadmin')) {
            $this->dispatch('swal',
                icon: 'error',
                title: 'Akses Ditolak',
                text: 'Anda tidak berhak menghapus berita milik pengguna lain.'
            );
            return;
        }

        $this->postService
            ->hapus($id_post);

        $this->dispatch('berita-refresh');

        $this->dispatch('swal',
            icon:'success',
            title:'Berhasil',
            text:'Data berhasil dihapus.'
        );
    }

    public function render()
    {
        return view('livewire.admin.berita.delete');
    }
}