<?php

namespace App\Livewire\Admin\Layanan;

use App\Models\Layanan;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $nama='';
    public $deskripsi='';
    public $status='1';
    public $gambar;

    protected function buatSlug($nama)
    {
        $slug=Str::slug($nama);
        $originalSlug=$slug;
        $i=1;

        while(Layanan::where('slug',$slug)->exists()){
            $slug=$originalSlug.'-'.$i;
            $i++;
        }
        return $slug;
    }

    public function simpan()
    {
        $this->validate([
            'nama'=>'required|min:3|max:255',
            'deskripsi'=>'required',
            'status'=>'required',
            'gambar'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $thumbnail=null;

        if($this->gambar){

            $thumbnail=Str::uuid().'.'.$this->gambar->getClientOriginalExtension();

            $this->gambar->storeAs('layanan',$thumbnail,'public');

        }

        Layanan::create([
            'nama'=>$this->nama,
            'thumbnail'=>$thumbnail,
            'slug'=>$this->buatSlug($this->nama),
            'deskripsi'=>$this->deskripsi,
            'status'=>$this->status,
        ]);

        $this->dispatch('simpan-berhasil');
    }

    public function render()
    {
        return view('livewire.admin.layanan.create');
    }
}