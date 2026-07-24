<?php

namespace App\Livewire\Admin\Berita;

use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class Delete extends Component
{
    
    protected $listeners = [
        'hapusBerita'
    ];

    public function hapusBerita($id_post)
    {

        $post=Post::findOrFail($id_post);

        if($post->thumbnail){
            Storage::disk('public')->delete('berita/'.$post->thumbnail);
        }

        $post->delete();

        $this->dispatch('berita-refresh');

        $this->dispatch('swal',
            icon: 'success',
            title: 'Berhasil',
            text: 'Data berhasil dihapus.'
        );
    }

    public function render()
    {
        return view('livewire.admin.berita.delete');
    }
}


