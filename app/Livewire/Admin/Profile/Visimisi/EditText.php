<?php

namespace App\Livewire\Admin\Profile\Visimisi;

use App\Models\Visimisi;
use Livewire\Component;

class EditText extends Component
{
    public $id_visimisi;
    public $nama;
    public $keterangan;

    protected $listeners=[
        'editText'
    ];

    public function editText($id_visimisi)
    {
        $data=Visimisi::findOrFail($id_visimisi);

        $this->id_visimisi=$data->id_visimisi;
        $this->nama=$data->nama;
        $this->keterangan=$data->keterangan;
    }

    public function simpan()
    {
        $this->validate([
            'keterangan'=>'required'
        ]);

        Visimisi::where('id_visimisi',$this->id_visimisi)->update([
            'keterangan'=>$this->keterangan
        ]);

        $this->dispatch('profile-refresh');
        $this->dispatch('close-edit-text');
        $this->dispatch('swal',icon:'success',title:'Berhasil',text:'Data berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.profile.visimisi.edit-text');
    }
}

