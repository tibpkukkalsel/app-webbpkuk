<?php

namespace App\Livewire\Admin\Identitas;

use App\Models\Identitas;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EditFile extends Component
{
    use WithFileUploads;

    public $id_identitas;
    public $nama;
    public $gambar;
    public $gambarLama;

    protected $listeners=[
        'editFile'
    ];

    public function editFile($id_identitas)
    {
        $data=Identitas::findOrFail($id_identitas);

        $this->id_identitas=$data->id_identitas;
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
            Storage::disk('public')->delete('header/'.$this->gambarLama);
        }

        $namaFile=time().'.'.$this->gambar->getClientOriginalExtension();

        $this->gambar->storeAs('header',$namaFile,'public');

        Identitas::where('id_identitas',$this->id_identitas)->update([
            'keterangan'=>$namaFile
        ]);

        $this->dispatch('identitas-refresh');
        $this->dispatch('close-edit-file');
        $this->dispatch('swal',icon:'success',title:'Berhasil',text:'Gambar berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.identitas.edit-file');
    }
}