<?php

namespace App\Livewire\Admin\Profile\Fasilitas;

use App\Models\Fasilitas;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Create extends Component
{
    use WithFileUploads;
    
    public $nama = '';
    public $keterangan = '';
    public $gambar;

   public function simpan()
   {
        $this->validate([
            'gambar'=>'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $namaFile=time().'.'.$this->gambar->getClientOriginalExtension();

        $this->gambar->storeAs('fasilitas',$namaFile,'public');

        Fasilitas::create([
            'nama' => $this->nama,
            'keterangan' =>$this->keterangan,
            'gambar' => $namaFile,
            'status' => '1'
        ]);

        $this->reset();
        
        $this->dispatch('fasilitas-refresh');

        $this->dispatch('swal',
            icon: 'success',
            title: 'Berhasil',
            text: 'Data berhasil ditambahkan.'
        );

        $this->dispatch('fasilitas-created');
    }

    public function render()
    {
        return view('livewire.admin.profile.fasilitas.create');
    }
}
