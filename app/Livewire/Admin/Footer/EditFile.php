<?php

namespace App\Livewire\Admin\Footer;

use App\Models\Footer;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EditFile extends Component
{
    use WithFileUploads;

    public $id_footer;
    public $nama;
    public $gambar;
    public $gambarLama;

    protected $listeners=[
        'editFile'
    ];

    public function editFile($id_footer)
    {
        $data=Footer::findOrFail($id_footer);

        $this->id_footer=$data->id_footer;
        $this->nama=$data->nama;
        $this->gambarLama=$data->keterangan;
        $this->gambar=null;
    }

    public function simpan()
    {
        $this->validate([
            'gambar'=>'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        if($this->gambarLama){
            Storage::disk('public')->delete('footer/'.$this->gambarLama);
        }

        $namaFile=time().'.'.$this->gambar->getClientOriginalExtension();

        $this->gambar->storeAs('footer',$namaFile,'public');

        Footer::where('id_footer',$this->id_footer)->update([
            'keterangan'=>$namaFile
        ]);

        $this->dispatch('footer-refresh');
        $this->dispatch('close-edit-file');
        $this->dispatch('swal',icon:'success',title:'Berhasil',text:'Gambar berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.Footer.edit-file');
    }
}