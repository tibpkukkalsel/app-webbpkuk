<?php

namespace App\Livewire\Admin\Kategori;

use App\Models\Kategori;
use Livewire\Component;

class Create extends Component
{
    public $kategori = '';

    protected $rules = [
        'kategori' => 'required|unique:kategori,kategori'
    ];

    protected $messages = [
        'kategori.required' => 'Kategori wajib diisi.',
        'kategori.unique' => 'Kategori sudah ada.'
    ];

   public function simpan()
   {
        $this->validate();

        Kategori::create([
            'kategori' => $this->kategori
        ]);

        $this->reset();
        
        $this->dispatch('kategori-refresh');

        $this->dispatch('swal',
            icon: 'success',
            title: 'Berhasil',
            text: 'Kategori berhasil ditambahkan.'
        );

        $this->dispatch('kategori-created');
    }

    public function render()
    {
        return view('livewire.admin.kategori.create');
    }
}