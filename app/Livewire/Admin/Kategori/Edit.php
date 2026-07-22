<?php

namespace App\Livewire\Admin\Kategori;

use App\Models\Kategori;
use Livewire\Component;

class Edit extends Component
{
    public string $id_kategori;
    public string $kategori;

    protected $listeners = [
        'editKategori'
    ];

    public function editKategori(string $id_kategori)
    {
        $data = Kategori::findOrFail($id_kategori);

        $this->id_kategori = $data->id_kategori;
        $this->kategori = $data->kategori;
    }

    public function update()
    {
        $this->validate([
            'kategori' => 'required|unique:kategori,kategori,' . $this->id_kategori . ',id_kategori'
        ]);

        Kategori::where('id_kategori', $this->id_kategori)->update([
            'kategori' => $this->kategori
        ]);

        $this->dispatch('kategori-refresh');

        $this->dispatch('close-edit-modal');

        $this->dispatch('swal',
            icon:'success',
            title:'Berhasil',
            text:'Data berhasil diubah.'
        );
    }

    public function render()
    {
        return view('livewire.admin.kategori.edit');
    }
}