<?php

namespace App\Livewire\Admin\Identitas;

use App\Models\Identitas;
use Livewire\Component;

class EditText extends Component
{
    public $id_identitas;
    public $nama;
    public $keterangan;
    public $link;

    protected $listeners=[
        'editText'
    ];

    public function editText($id_identitas)
    {
        $data=Identitas::findOrFail($id_identitas);

        $this->id_identitas=$data->id_identitas;
        $this->nama=$data->nama;
        $this->keterangan=$data->keterangan;
        $this->link=$data->link;
    }

    public function simpan()
    {
        $this->validate([
            'keterangan'=>'required'
        ]);

        Identitas::where('id_identitas',$this->id_identitas)->update([
            'keterangan'=>$this->keterangan,
            'link'=>$this->link
        ]);

        $this->dispatch('identitas-refresh');
        $this->dispatch('close-edit-text');
        $this->dispatch('swal',icon:'success',title:'Berhasil',text:'Data berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.identitas.edit-text');
    }
}