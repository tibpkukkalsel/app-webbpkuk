<?php

namespace App\Livewire\Admin\Hashtag;

use App\Models\Hashtag;
use Livewire\Component;

class Create extends Component
{
    public $hashtag = '';

    protected $rules = [
        'hashtag' => 'required|unique:hashtag,hashtag'
    ];

    protected $messages = [
        'hashtag.required' => 'Hashtag wajib diisi.',
        'hashtag.unique' => 'Hashtag sudah ada.'
    ];

   public function simpan()
   {
        $this->validate();

        Hashtag::create([
            'hashtag' => $this->hashtag
        ]);

        $this->reset();
        
        $this->dispatch('hashtag-refresh');

        $this->dispatch('swal',
            icon: 'success',
            title: 'Berhasil',
            text: 'Hashtag berhasil ditambahkan.'
        );

        $this->dispatch('hashtag-created');
    }

    public function render()
    {
        return view('livewire.admin.hashtag.create');
    }
}
