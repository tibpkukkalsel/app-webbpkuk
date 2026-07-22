<?php

namespace App\Livewire\Admin\Beranda\Tajuktentang;

use App\Models\Beranda;
use Livewire\Component;

class EditText extends Component
{
    public $id_beranda;
    public $nama;
    public $keterangan;
    public $caption;
    public $link;

    protected $listeners=[
        'editText'
    ];

    public function editText($id_beranda)
    {
        $data=Beranda::findOrFail($id_beranda);

        $this->id_beranda=$data->id_beranda;
        $this->nama=$data->nama;
        $this->keterangan=$data->keterangan_1;
        $this->caption=$data->keterangan_2;
        $this->link=$data->link;
    }

    public function simpan()
    {
        $this->validate([
            'keterangan'=>'required'
        ]);

        Beranda::where('id_beranda',$this->id_beranda)->update([
            'keterangan_1'=>$this->keterangan,
        ]);

        $this->dispatch('beranda-refresh');
        $this->dispatch('close-edit-text');
        $this->dispatch('swal',icon:'success',title:'Berhasil',text:'Data berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.beranda.tajuktentang.edit-text');
    }
}


