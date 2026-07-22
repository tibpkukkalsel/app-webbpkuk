<?php

namespace App\Livewire\Admin\Profile\Storganisasi;

use App\Models\Storganisasi;
use Livewire\Component;

class EditText extends Component
{
    public $id_storganisasi;
    public $nama;
    public $keterangan;

    protected $listeners=[
        'editText'
    ];

    public function editText($id_storganisasi)
    {
        $data=Storganisasi::findOrFail($id_storganisasi);

        $this->id_storganisasi=$data->id_storganisasi;
        $this->nama=$data->nama;
        $this->keterangan=$data->keterangan;
    }

    public function simpan()
    {
        $this->validate([
            'keterangan'=>'required'
        ]);

        Storganisasi::where('id_storganisasi',$this->id_storganisasi)->update([
            'keterangan'=>$this->keterangan
        ]);

        $this->dispatch('profile-refresh');
        $this->dispatch('close-edit-text');
        $this->dispatch('swal',icon:'success',title:'Berhasil',text:'Data berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.profile.storganisasi.edit-text');
    }
}


