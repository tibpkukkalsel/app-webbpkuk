<?php

namespace App\Livewire\Admin\Artikel;

use App\Services\PostService;
use Livewire\Component;

class Delete extends Component
{
    protected PostService $postService;

    protected $listeners=[
        'hapusArtikel'
    ];

    public function boot(PostService $postService)
    {
        $this->postService=$postService;
    }

    public function hapusArtikel($id_post)
    {
        $this->postService
            ->hapus($id_post);

        $this->dispatch('artikel-refresh');

        $this->dispatch('swal',
            icon:'success',
            title:'Berhasil',
            text:'Data berhasil dihapus.'
        );
    }

    public function render()
    {
        return view('livewire.admin.artikel.delete');
    }
}
