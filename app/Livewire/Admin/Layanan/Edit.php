<?php

namespace App\Livewire\Admin\Layanan;

use App\Models\Layanan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public $id_layanan;
    public $nama='';
    public $deskripsi='';
    public $status='1';
    public $gambar;
    public $thumbnailLama;

    public function mount($id_layanan)
    {
        $layanan=Layanan::findOrFail($id_layanan);

        $this->id_layanan=$layanan->id_layanan;
        $this->nama=$layanan->nama;
        $this->deskripsi=$layanan->deskripsi;
        $this->status=$layanan->status;
        $this->thumbnailLama=$layanan->thumbnail;
    }

    protected function buatSlug($nama)
    {
        $slug=Str::slug($nama);
        $originalSlug=$slug;
        $i=1;

        while(Layanan::where('slug',$slug)->where('id_layanan','!=',$this->id_layanan)->exists()){
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

        $thumbnail=$this->thumbnailLama;

        if($this->gambar){

            if($this->thumbnailLama){
                Storage::disk('public')->delete('layanan/'.$this->thumbnailLama);
            }

            $thumbnail=Str::uuid().'.'.$this->gambar->getClientOriginalExtension();
            $this->gambar->storeAs('layanan',$thumbnail,'public');
        }

        Layanan::where('id_layanan',$this->id_layanan)->update([
            'nama'=>$this->nama,
            'slug'=>$this->buatSlug($this->nama),
            'thumbnail'=>$thumbnail,
            'deskripsi'=>$this->deskripsi,
            'status'=>$this->status
        ]);

        $this->dispatch('simpan-berhasil');
    }

    public function render()
    {
        return view('livewire.admin.layanan.edit');
    }
}