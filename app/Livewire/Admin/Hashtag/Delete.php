<?php

namespace App\Livewire\Admin\Hashtag;

use App\Models\Hashtag;
use Livewire\Component;

class Delete extends Component
{
    protected $listeners = [
        'hapusHashtag'
    ];

    public function hapusHashtag($id_hashtag)
    {
        Hashtag::findOrFail($id_hashtag)->delete();

        $this->dispatch('hashtag-refresh');

        $this->dispatch('swal',
            icon: 'success',
            title: 'Berhasil',
            text: 'Data berhasil dihapus.'
        );
    }

    public function render()
    {
        return view('livewire.admin.hashtag.delete');
    }
}
