<?php

namespace App\Livewire\Admin\Hashtag;

use App\Models\Hashtag;
use Livewire\Component;

class Edit extends Component
{
    public string $id_hashtag;
    public string $hashtag;

    protected $listeners = [
        'editHashtag'
    ];

    public function editHashtag(string $id_hashtag)
    {
        $data = Hashtag::findOrFail($id_hashtag);

        $this->id_hashtag = $data->id_hashtag;
        $this->hashtag = $data->hashtag;
    }

    public function update()
    {
        $this->validate([
            'hashtag' => 'required|unique:hashtag,hashtag,' . $this->id_hashtag . ',id_hashtag'
        ]);

        hashtag::where('id_hashtag', $this->id_hashtag)->update([
            'hashtag' => $this->hashtag
        ]);

        $this->dispatch('hashtag-refresh');

        $this->dispatch('close-edit-modal');

        $this->dispatch('swal',
            icon:'success',
            title:'Berhasil',
            text:'Data berhasil diubah.'
        );
    }

    public function render()
    {
        return view('livewire.admin.hashtag.edit');
    }
}
