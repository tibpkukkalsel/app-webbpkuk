<?php

namespace App\Livewire\Admin\Beranda\Mitra;

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
    public $link;

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
        $this->link=$data->link;
    }

    public function simpan()
    {
        $this->validate([
            'nama'=>'required',
            'gambar'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'link'=>'nullable|url'
        ]);

        $data=[
            'nama'=>$this->nama,
            'link'=>$this->link,
        ];

        if($this->gambar){

            if($this->gambarLama){
                Storage::disk('public')->delete('beranda/'.$this->gambarLama);
            }

            $namaFile=time().'.'.$this->gambar->getClientOriginalExtension();

            $this->gambar->storeAs('beranda',$namaFile,'public');

            $data['keterangan_1']=$namaFile;
        }

        Beranda::where('id_beranda',$this->id_beranda)->update($data);

        $this->dispatch('beranda-refresh');
        $this->dispatch('close-edit-file');
        $this->dispatch('swal',icon:'success',title:'Berhasil',text:'Data berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.beranda.mitra.edit-file');
    }
}
