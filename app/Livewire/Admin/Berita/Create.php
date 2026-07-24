<?php

namespace App\Livewire\Admin\Berita;

use App\Models\Kategori;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\GeminiService;
use Illuminate\Support\Facades\Storage;

class Create extends Component
{
    use WithFileUploads;

    public $postId=null;
    public $judul='';
    public $isi='';
    public $status='0';
    public $id_kategori='';
    public $gambar;
    public $ringkasan='';
    public $thumbnail=null;
    public $lastSavedAt='';
    public $isDirty=false;


    protected function buatSlug($judul)
    {
        $slug=Str::slug($judul);
        $originalSlug=$slug;
        $i=1;

        while(Post::where('slug',$slug)->exists()){
            $slug=$originalSlug.'-'.$i;
            $i++;
        }
        return $slug;
    }
    

    public function buatRingkasan()
    {
        $this->resetErrorBag('ringkasan');

        if(blank(strip_tags($this->isi))){
            $this->addError('isi','Isi berita masih kosong.');
            return;
        }

        try{

            $this->ringkasan=app(GeminiService::class)
                ->ringkas($this->isi);

            $this->dispatch('ringkasan-berhasil');

        }catch(\Exception $e){

            $this->dispatch('swal',
                icon:'error',
                title:'AI Gagal',
                text:$e->getMessage()
            );

        }
    }

    public function updatedGambar()
    {
        if(!$this->gambar){
            return;
        }

        if($this->thumbnail){
            Storage::disk('public')->delete('berita/'.$this->thumbnail);
        }

        $this->thumbnail=Str::uuid().'.'.$this->gambar->getClientOriginalExtension();

        $this->gambar->storeAs(
            'berita',
            $this->thumbnail,
            'public'
        );

        $this->isDirty=true;
    }

    public function updated()
    {
        $this->isDirty=true;
    }

    protected $listeners=[
        'auto-save'=>'autoSave'
    ];

    public function autoSave()
    {
        if(!$this->isDirty){
            return;
        }

        if(
            blank($this->judul) ||
            blank($this->id_kategori) ||
            blank($this->thumbnail)
        ){
            return;
        }

        $data=[
            'judul'=>$this->judul,
            'slug'=>$this->buatSlug($this->judul),
            'thumbnail'=>$this->thumbnail,
            'isi'=>$this->isi,
            'ringkasan'=>$this->ringkasan,
            'status'=>0,
            'jenis'=>'Berita',
            'view_count'=>0,
            'id_kategori'=>$this->id_kategori,
            'id_user'=>Auth::id()
        ];

        if($this->postId){

            Post::where('id_post',$this->postId)->update($data);

        }else{

            $post=Post::create($data);

            $this->postId=$post->id_post;
        }

        $this->isDirty=false;

        $this->lastSavedAt=now()->format('H:i:s');
    }

    public function simpan()
    {
        $this->validate([
            'judul'=>'required|min:3|max:255',
            'isi'=>'required',
            'ringkasan'=>'nullable|max:500',
            'status'=>'required',
            'id_kategori'=>'required|exists:kategori,id_kategori',
            'gambar'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $thumbnail=null;

        if($this->gambar){

            $thumbnail=Str::uuid().'.'.$this->gambar->getClientOriginalExtension();

            $this->gambar->storeAs('berita',$thumbnail,'public');

        }

        Post::create([
            'judul'=>$this->judul,
            'thumbnail'=>$thumbnail,
            'slug'=>$this->buatSlug($this->judul),
            'isi'=>$this->isi,
            'ringkasan'=>$this->ringkasan,
            'jenis'=>'berita',
            'status'=>$this->status,
            'view_count'=>'0',
            'id_kategori'=>$this->id_kategori,
            'id_user'=>Auth::id()
        ]);

        $this->dispatch('simpan-berhasil');
    }

    public function render()
    {
        return view('livewire.admin.berita.create',[
        'kategori'=>Kategori::orderBy('kategori')->get()
    ]);
    }
}
