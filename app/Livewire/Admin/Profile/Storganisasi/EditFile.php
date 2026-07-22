<?php

namespace App\Livewire\Admin\Profile\Storganisasi;

use App\Models\Storganisasi;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EditFile extends Component
{
    use WithFileUploads;

    public $id_storganisasi;
    public $nama;
    public $gambar;
    public $gambarLama;

    protected $listeners=[
        'editFile'
    ];

    public function editFile($id_storganisasi)
    {
        $data=Storganisasi::findOrFail($id_storganisasi);

        $this->id_storganisasi=$data->id_storganisasi;
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
            Storage::disk('public')->delete('profileweb/'.$this->gambarLama);
        }

        $namaFile=time().'.'.$this->gambar->getClientOriginalExtension();

        $this->gambar->storeAs('profileweb',$namaFile,'public');

        Storganisasi::where('id_storganisasi',$this->id_storganisasi)->update([
            'keterangan'=>$namaFile
        ]);

        $this->dispatch('profile-refresh');
        $this->dispatch('close-edit-file');
        $this->dispatch('swal',icon:'success',title:'Berhasil',text:'Gambar berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.profile.storganisasi.edit-file');
    }
}

