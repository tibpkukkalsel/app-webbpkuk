<?php

namespace App\Services;

use App\Models\Hashtag;
use App\Models\Post;
use App\Models\PostHashtag;

class HashtagService
{
    public function tambah($idPost,$tag)
    {
        $nama=strtolower(trim($tag['value']));

        $hashtag=Hashtag::firstOrCreate([
            'hashtag'=>$nama
        ]);

        PostHashtag::firstOrCreate([
            'id_post'=>$idPost,
            'id_hashtag'=>$hashtag->id_hashtag
        ]);

        return $hashtag;
    }

    public function hapus($idPost,$tag)
    {
        if(empty($tag['value'])){
            return;
        }

        $hashtag=Hashtag::where(
            'hashtag',
            strtolower(trim($tag['value']))
        )->first();

        if(!$hashtag){
            return;
        }

        PostHashtag::where('id_post',$idPost)
            ->where('id_hashtag',$hashtag->id_hashtag)
            ->delete();
    }

    public function refresh($idPost)
    {
        if(!$idPost){
            return collect();
        }

        return Post::findOrFail($idPost)
            ->hashtags()
            ->orderBy('hashtag')
            ->get();
    }

    public function hapusSemua($idPost)
    {
        PostHashtag::where('id_post',$idPost)
            ->delete();
    }

    public function sync($idPost,$idHashtag=[])
    {
        PostHashtag::where('id_post',$idPost)
            ->delete();

        foreach($idHashtag as $id){

            PostHashtag::create([
                'id_post'=>$idPost,
                'id_hashtag'=>$id
            ]);

        }
    }
}