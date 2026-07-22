<?php

namespace App\Livewire\Admin\Footer;

use App\Models\Footer;
use Livewire\Component;

class EditText extends Component
{
    public $id_footer;
    public $nama;
    public $keterangan;
    public $link;

    protected $listeners=[
        'editText'
    ];

    public function editText($id_footer)
    {
        $data=Footer::findOrFail($id_footer);

        $this->id_footer=$data->id_footer;
        $this->nama=$data->nama;
        $this->keterangan=$data->keterangan;
        $this->link=$data->link;
    }

    public function simpan()
    {
        $this->validate([
            'keterangan'=>'required'
        ]);

        Footer::where('id_footer',$this->id_footer)->update([
            'keterangan'=>$this->keterangan,
            'link'=>$this->link
        ]);

        $this->dispatch('footer-refresh');
        $this->dispatch('close-edit-text');
        $this->dispatch('swal',icon:'success',title:'Berhasil',text:'Data berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.footer.edit-text');
    }
}
