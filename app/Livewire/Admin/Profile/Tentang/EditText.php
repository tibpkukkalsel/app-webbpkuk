<?php

namespace App\Livewire\Admin\Profile\Tentang;

use App\Models\Tentang;
use Livewire\Component;

class EditText extends Component
{
    public $id_tentang;
    public $nama;
    public $keterangan;

    protected $listeners=[
        'editText'
    ];

    public function editText($id_tentang)
    {
        $data=Tentang::findOrFail($id_tentang);

        $this->id_tentang=$data->id_tentang;
        $this->nama=$data->nama;
        $this->keterangan=$data->keterangan;
    }

    public function simpan()
    {
        $this->validate([
            'keterangan'=>'required'
        ]);

        Tentang::where('id_tentang',$this->id_tentang)->update([
            'keterangan'=>$this->keterangan
        ]);

        $this->dispatch('profile-refresh');
        $this->dispatch('close-edit-text');
        $this->dispatch('swal',icon:'success',title:'Berhasil',text:'Data berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.profile.tentang.edit-text');
    }
}
