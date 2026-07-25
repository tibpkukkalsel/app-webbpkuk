<?php

namespace App\Livewire\Admin\Berita;

use App\Models\Hashtag;
use App\Models\Kategori;
use App\Models\Post;
use App\Models\PostHashtag;
use App\Models\PostGaleri;
use App\Services\GeminiService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $postId=null;

    public $judul='';
    public $isi='';
    public $ringkasan='';
    public $status='0';
    public $id_kategori='';

    public $gambar;
    public $thumbnail=null;

    public $galeri=[];
    public $galeriPost=[];

    public $hashtagPost=[];

    public $lastSavedAt='';
    public $isDirty=false;

    protected $listeners=[
        'auto-save'=>'autoSave'
    ];

    public function mount()
    {
        $this->refreshGallery();
        $this->refreshHashtag();
    }

    protected function rules()
    {
        return[
            'judul'=>'required|min:3|max:255',
            'isi'=>'required',
            'ringkasan'=>'nullable|max:500',
            'status'=>'required',
            'id_kategori'=>'required|exists:kategori,id_kategori',
            'gambar'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'galeri.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048'
        ];
    }

    protected function messages()
    {
        return[
            'judul.required'=>'Judul wajib diisi.',
            'isi.required'=>'Isi berita wajib diisi.',
            'id_kategori.required'=>'Kategori wajib dipilih.',
            'gambar.image'=>'Thumbnail harus berupa gambar.',
            'gambar.mimes'=>'Thumbnail harus JPG, PNG atau WEBP.',
            'gambar.max'=>'Ukuran thumbnail maksimal 2 MB.',
            'galeri.*.image'=>'File harus berupa gambar.',
            'galeri.*.mimes'=>'Format gambar harus JPG, PNG atau WEBP.',
            'galeri.*.max'=>'Ukuran gambar maksimal 2 MB.'
        ];
    }

    protected function validateData()
    {
        $this->validate();
    }

    protected function buatSlug($judul)
    {
        $slug=Str::slug($judul);
        $originalSlug=$slug;
        $i=1;

        while(
            Post::where('slug',$slug)
            ->when($this->postId,function($q){
                $q->where('id_post','!=',$this->postId);
            })
            ->exists()
        ){
            $slug=$originalSlug.'-'.$i;
            $i++;
        }

        return $slug;
    }

    public function updated()
    {
        $this->isDirty=true;
    }

    public function updatedGambar()
    {
        if(!$this->gambar){
            return;
        }
        $this->uploadThumbnail();
        $this->isDirty=true;
    }

    protected function uploadThumbnail()
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
    }

    protected function saveDraft()
    {
        if(
            blank($this->judul)||
            blank($this->id_kategori)||
            blank($this->thumbnail)
        ){
            return false;
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

            $post=Post::findOrFail($this->postId);

            $post->update($data);

        }else{

            $post=Post::create($data);

            $this->postId=$post->id_post;

        }

        return true;
    }

    public function autoSave()
    {
        if(!$this->isDirty){
            return;
        }

        if(!$this->saveDraft()){
            return;
        }

        $this->isDirty=false;

        $this->lastSavedAt=now()->format('H:i:s');
    }

    public function simpan()
    {
        $this->validateData();

        if(!$this->saveDraft()){

            $this->dispatch('swal',
                icon:'warning',
                title:'Perhatian',
                text:'Lengkapi Judul, Kategori, dan Thumbnail.'
            );

            return;
        }

        Post::where('id_post',$this->postId)
            ->update([
                'status'=>$this->status
            ]);

        $this->dispatch('swal',
            icon:'success',
            title:'Berhasil',
            text:'Berita berhasil disimpan.'
        );
    }

    public function buatRingkasan()
    {
        if(blank(strip_tags($this->isi))){
            $this->addError('isi','Isi berita masih kosong.');
            return;
        }

        try{

            $this->ringkasan=app(GeminiService::class)
                ->ringkas($this->isi);

            $this->isDirty=true;

            $this->dispatch('swal',
                icon:'success',
                title:'Berhasil',
                text:'Ringkasan berhasil dibuat.'
            );

        }catch(\Exception $e){

            $this->dispatch('swal',
                icon:'error',
                title:'AI Gagal',
                text:$e->getMessage()
            );

        }
    }

    public function updatedGaleri()
    {
        if(!$this->postId){

            $this->dispatch('swal',
                icon:'warning',
                title:'Perhatian',
                text:'Simpan draft terlebih dahulu.'
            );

            $this->galeri=[];

            return;
        }

        $totalGaleri=count($this->galeriPost);

        $totalUpload=count($this->galeri);

        if(($totalGaleri + $totalUpload) > 6){

            $this->dispatch('swal',
                icon:'warning',
                title:'Batas Galeri',
                text:'Maksimal hanya 6 foto untuk setiap berita.'
            );

            $this->galeri=[];

            return;
        }

        $this->uploadGallery();

        $this->refreshGallery();
    }

    protected function uploadGallery()
    {
        foreach($this->galeri as $foto){
            
            if(!$foto->isValid()){
            continue;
            }

            $nama=Str::uuid().'.'.$foto->getClientOriginalExtension();

            $foto->storeAs(
                'berita/galeri',
                $nama,
                'public'
            );

            PostGaleri::create([
                'id_post'=>$this->postId,
                'gambar'=>$nama
            ]);

        }

        $this->galeri=[];

        $this->dispatch('swal',
            icon:'success',
            title:'Berhasil',
            text:'Galeri berhasil ditambahkan.'
        );
    }
    

    protected function refreshGallery()
    {
        $this->galeriPost=PostGaleri::where(
            'id_post',
            $this->postId
        )
        ->latest()
        ->get();
    }

    public function hapusGaleri($id)
    {
        $galeri=PostGaleri::findOrFail($id);

        Storage::disk('public')
            ->delete('berita/galeri/'.$galeri->gambar);

        $galeri->delete();

        $this->refreshGallery();

        $this->dispatch('swal',
            icon:'success',
            title:'Berhasil',
            text:'Foto berhasil dihapus.'
        );
    }

    public function tambahHashtag($idHashtag)
    {
        if(!$this->postId){

            $this->dispatch('swal',
                icon:'warning',
                title:'Perhatian',
                text:'Simpan draft terlebih dahulu.'
            );

            return;
        }

        PostHashtag::firstOrCreate([
            'id_post'=>$this->postId,
            'id_hashtag'=>$idHashtag
        ]);

        $this->refreshHashtag();
    }

    public function hapusHashtag($idHashtag)
    {
        if(!$this->postId){
            return;
        }

        PostHashtag::where('id_post',$this->postId)
            ->where('id_hashtag',$idHashtag)
            ->delete();

        $this->refreshHashtag();
    }

    protected function refreshHashtag()
    {
        if(!$this->postId){

            $this->hashtagPost=[];

            return;
        }

        $post=Post::find($this->postId);

        $this->hashtagPost=$post
        ? $post->hashtags()->orderBy('hashtag')->get()
        : collect();
    }

    protected function resetForm()
    {
        $this->reset([
            'judul',
            'isi',
            'ringkasan',
            'status',
            'id_kategori',
            'gambar',
            'thumbnail',
            'galeri',
            'galeriPost',
            'hashtagPost',
            'postId'
        ]);

        $this->status=0;

        $this->isDirty=false;

        $this->lastSavedAt='';
    }

    protected function loadPost(Post $post)
    {
        $this->postId=$post->id_post;
        $this->judul=$post->judul;
        $this->isi=$post->isi;
        $this->ringkasan=$post->ringkasan;
        $this->status=$post->status;
        $this->thumbnail=$post->thumbnail;
        $this->id_kategori=$post->id_kategori;

        $this->refreshGallery();
        $this->refreshHashtag();
    }


    public function render()
    {
        return view('livewire.admin.berita.create',[
            'kategori'=>Kategori::orderBy('kategori')->get(),
            'hashtags'=>Hashtag::orderBy('hashtag')->get()
        ]);
    }
}