<?php

namespace App\Livewire\Admin\Beranda\Bannercard;

use App\Models\Beranda;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EditFile extends Component
{
    use WithFileUploads;

    public $id_beranda;
    public $nama;
    public $gambar;
    public $gambarLama;

    protected $listeners=[
        'editFile'
    ];

    public function editFile($id_beranda)
    {
        $data=Beranda::findOrFail($id_beranda);

        $this->id_beranda=$data->id_beranda;
        $this->nama=$data->nama;
        $this->gambarLama=$data->keterangan_1;
        $this->gambar=null;
    }

    public function simpan()
    {
        $this->validate([
            'gambar'=>'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        if($this->gambarLama){
            Storage::disk('public')->delete('beranda/'.$this->gambarLama);
        }

        $namaFile=time().'.'.$this->gambar->getClientOriginalExtension();

        $this->gambar->storeAs('beranda',$namaFile,'public');

        Beranda::where('id_beranda',$this->id_beranda)->update([
            'keterangan_1'=>$namaFile
        ]);

        $this->dispatch('beranda-refresh');
        $this->dispatch('close-edit-file');
        $this->dispatch('swal',icon:'success',title:'Berhasil',text:'Gambar berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.beranda.bannerutama.edit-file');
    }
}

