<?php

namespace App\Livewire\Admin\Info;

use App\Models\Hashtag;
use App\Models\Kategori;
use App\Models\Post;
use App\Services\PostService;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;
    
    protected PostService $postService;

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

    public function boot(PostService $postService){

        $this->postService=$postService;
    }

    public function mount($id)
    {
        $post=$this->postService
            ->load($id);

        $this->loadPost($post);
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

        $this->galeriPost=$this->postService
            ->refreshGallery($this->postId);

        $this->hashtagPost=$this->postService
            ->refreshHashtag($this->postId);
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
            'galeri.*'=>'image|mimes:jpg,jpeg,png,webp|max:2048'
        ];
    }

    protected function messages()
    {
        return[
            'judul.required'=>'Judul wajib diisi.',
            'isi.required'=>'Isi info wajib diisi.',
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

    public function updated()
    {
        $this->isDirty=true;
    }

    public function updatedGambar()
    {
        if(!$this->gambar){
            return;
        }

        $this->thumbnail=$this->postService
            ->uploadThumbnail(
                $this->gambar,
                $this->thumbnail
            );

        $this->isDirty=true;
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

        $post=$this->postService
            ->saveDraft(
                $this->postId,
                [
                    'judul'=>$this->judul,
                    'thumbnail'=>$this->thumbnail,
                    'isi'=>$this->isi,
                    'ringkasan'=>$this->ringkasan,
                    'jenis'=>'Info dan Tips',
                    'id_kategori'=>$this->id_kategori
                ]
            );

        $this->postId=$post->id_post;

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

        $this->postService
            ->publish(
                $this->postId,
                $this->status
            );

        $this->dispatch('swal',
            icon:'success',
            title:'Berhasil',
            text:'Perubahan berhasil disimpan.'
        );
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

        if(($totalGaleri+$totalUpload)>6){

            $this->dispatch('swal',
                icon:'warning',
                title:'Batas Galeri',
                text:'Maksimal hanya 6 foto untuk setiap info.'
            );

            $this->galeri=[];

            return;
        }

        $this->postService
            ->uploadGallery(
                $this->postId,
                $this->galeri
            );

        $this->galeri=[];

        $this->galeriPost=$this->postService
            ->refreshGallery($this->postId);

        $this->dispatch('swal',
            icon:'success',
            title:'Berhasil',
            text:'Galeri berhasil ditambahkan.'
        );
    }

    public function hapusGaleri($id)
    {
        $this->postService
            ->hapusGallery($id);

        $this->galeriPost=$this->postService
            ->refreshGallery($this->postId);

        $this->dispatch('swal',
            icon:'success',
            title:'Berhasil',
            text:'Foto berhasil dihapus.'
        );
    }

    public function tambahHashtag($tag)
    {
        if(!$this->postId){

            $this->dispatch('swal',
                icon:'warning',
                title:'Perhatian',
                text:'Simpan draft terlebih dahulu.'
            );

            return;
        }

        if(count($this->hashtagPost ?? []) >= 3){
            $this->dispatch('swal',
                icon:'warning',
                title:'Perhatian',
                text:'Maksimal hanya 3 hashtag untuk setiap postingan.'
            );
            return;
        }

        $this->postService
            ->tambahHashtag(
                $this->postId,
                $tag
            );

        $this->hashtagPost=$this->postService
            ->refreshHashtag(
                $this->postId
            );
    }

    public function hapusHashtag($tag)
    {
        if(!$this->postId){
            return;
        }

        $this->postService
            ->hapusHashtag(
                $this->postId,
                $tag
            );

        $this->hashtagPost=$this->postService
            ->refreshHashtag(
                $this->postId
            );
    }

    public function buatRingkasan()
    {
        if(blank(strip_tags($this->isi))){

            $this->addError(
                'isi',
                'Isi info masih kosong.'
            );

            return;
        }

        try{

            $this->ringkasan=$this->postService
                ->buatRingkasan(
                    $this->isi
                );

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

    public function render()
    {
        return view('livewire.admin.info.edit',[
            'kategori'=>Kategori::orderBy('kategori')->get(),
            'hashtags'=>Hashtag::orderBy('hashtag')->get()
        ]);
    }

}
