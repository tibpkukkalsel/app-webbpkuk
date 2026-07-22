<?php

namespace App\Livewire\Admin\Profile\Fasilitas;

use App\Models\Fasilitas;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public $id_fasilitas;
    public $nama;
    public $gambar;
    public $gambarLama;
    public $keterangan;

    protected $listeners=[
        'edit'
    ];

    public function edit($id_fasilitas)
    {
        $data=Fasilitas::findOrFail($id_fasilitas);

        $this->id_fasilitas=$data->id_fasilitas;
        $this->nama=$data->nama;
        $this->keterangan=$data->keterangan;
        $this->gambarLama=$data->gambar;
        $this->gambar=null;
        
    }

    public function simpan()
    {
        $this->validate([
            'nama'=>'required',
            'gambar'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'keterangan'=>'required'
        ]);

        $data=[
            'nama'=>$this->nama,
            'keterangan'=>$this->keterangan,
        ];

        if($this->gambar){

            if($this->gambarLama){
                Storage::disk('public')->delete('fasilitas/'.$this->gambarLama);
            }

            $namaFile=time().'.'.$this->gambar->getClientOriginalExtension();

            $this->gambar->storeAs('fasilitas',$namaFile,'public');

            $data['gambar']=$namaFile;
        }

        Fasilitas::where('id_fasilitas',$this->id_fasilitas)->update($data);

        $this->dispatch('fasilitas-refresh');
        $this->dispatch('close-edit-modal');
        $this->dispatch('swal',icon:'success',title:'Berhasil',text:'Data berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.profile.fasilitas.edit');
    }
}

