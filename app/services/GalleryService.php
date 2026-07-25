<?php

namespace App\Services;

use App\Models\PostGaleri;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryService
{
    public function uploadThumbnail($gambar,$thumbnail=null)
    {
        if(!$gambar){
            return $thumbnail;
        }

        if($thumbnail){
            $this->hapusThumbnail($thumbnail);
        }

        $nama=Str::uuid().'.'.$gambar->getClientOriginalExtension();

        $gambar->storeAs(
            'post/thumbnail',
            $nama,
            'public'
        );

        return $nama;
    }

    public function uploadGallery($idPost,$galeri)
    {
        foreach($galeri as $foto){

            if(!$foto->isValid()){
                continue;
            }

            $nama=Str::uuid().'.'.$foto->getClientOriginalExtension();

            $foto->storeAs(
                'post/galeri',
                $nama,
                'public'
            );

            PostGaleri::create([
                'id_post'=>$idPost,
                'gambar'=>$nama
            ]);

        }
    }

    public function refreshGallery($idPost)
    {
        return PostGaleri::where(
            'id_post',
            $idPost
        )
        ->latest()
        ->get();
    }

    public function hapusGallery($id)
    {
        $galeri=PostGaleri::findOrFail($id);

        Storage::disk('public')
            ->delete('post/galeri/'.$galeri->gambar);

        $galeri->delete();
    }

    public function hapusThumbnail($thumbnail)
    {
        if(!$thumbnail){
            return;
        }

        Storage::disk('public')
            ->delete('post/thumbnail/'.$thumbnail);
    }

    public function hapusSemuaGallery($idPost)
    {
        $galeri=PostGaleri::where(
            'id_post',
            $idPost
        )->get();

        foreach($galeri as $g){

            Storage::disk('public')
                ->delete('post/galeri/'.$g->gambar);

        }

        PostGaleri::where(
            'id_post',
            $idPost
        )->delete();
    }
}