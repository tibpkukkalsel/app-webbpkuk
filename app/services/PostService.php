<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostService
{
    protected $galleryService;

    protected $hashtagService;

    protected $geminiService;

    public function __construct(
        GalleryService $galleryService,
        HashtagService $hashtagService,
        GeminiService $geminiService
    ){
        $this->galleryService=$galleryService;
        $this->hashtagService=$hashtagService;
        $this->geminiService=$geminiService;
    }

    public function buatSlug($judul,$idPost=null)
    {
        $slug=Str::slug($judul);

        $originalSlug=$slug;

        $i=1;

        while(
            Post::where('slug',$slug)
                ->when($idPost,function($q)use($idPost){
                    $q->where('id_post','!=',$idPost);
                })
                ->exists()
        ){

            $slug=$originalSlug.'-'.$i;

            $i++;

        }

        return $slug;
    }

    public function saveDraft($idPost,$data)
    {
        $data['slug']=$this->buatSlug(
            $data['judul'],
            $idPost
        );

        if(!$idPost){

            $data['status']=0;

            $data['view_count']=0;

            $data['id_user']=Auth::id();

        }

        if($idPost){

            $post=Post::findOrFail($idPost);

            $post->update($data);

        }else{

            $post=Post::create($data);

        }

        return $post;
    }

    public function publish($idPost,$status)
    {
        Post::where('id_post',$idPost)
            ->update([
                'status'=>$status
            ]);
    }

    public function load($idPost)
    {
        return Post::findOrFail($idPost);
    }

    public function buatRingkasan($isi)
    {
        return $this->geminiService
            ->ringkas($isi);
    }

    public function uploadThumbnail($gambar,$thumbnail=null)
    {
        return $this->galleryService
            ->uploadThumbnail(
                $gambar,
                $thumbnail
            );
    }

    public function uploadGallery($idPost,$galeri)
    {
        return $this->galleryService
            ->uploadGallery(
                $idPost,
                $galeri
            );
    }

    public function refreshGallery($idPost)
    {
        return $this->galleryService
            ->refreshGallery($idPost);
    }

    public function hapusGallery($id)
    {
        return $this->galleryService
            ->hapusGallery($id);
    }

    public function tambahHashtag($idPost,$tag)
    {
        return $this->hashtagService
            ->tambah(
                $idPost,
                $tag
            );
    }

    public function hapusHashtag($idPost,$tag)
    {
        $this->hashtagService
            ->hapus(
                $idPost,
                $tag
            );
    }

    public function refreshHashtag($idPost)
    {
        return $this->hashtagService
            ->refresh($idPost);
    }

    public function syncHashtag($idPost,$idHashtag)
    {
        return $this->hashtagService
            ->sync(
                $idPost,
                $idHashtag
            );
    }

    public function hapus($idPost)
    {
        $post=Post::findOrFail($idPost);

        if($post->thumbnail){

            $this->galleryService
                ->hapusThumbnail(
                    $post->thumbnail
                );

        }

        $this->galleryService
            ->hapusSemuaGallery(
                $idPost
            );

        $this->hashtagService
            ->hapusSemua(
                $idPost
            );

        $post->delete();
    }
}