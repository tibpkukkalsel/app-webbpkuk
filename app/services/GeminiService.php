<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiService
{
    protected string $url;

    public function __construct()
    {
        $this->url='https://generativelanguage.googleapis.com/v1beta/models/gemini-3.5-flash-lite:generateContent';
    }

    public function ringkas(string $isi):string
    {
        $prompt="
                    Anda adalah editor berita pemerintahan Indonesia.
                    Buat ringkasan berita.
                    Aturan:

                    - Maksimal 40 kata.
                    - Bahasa Indonesia baku.
                    - Jangan menambahkan fakta baru.
                    - Jangan mengubah fakta.
                    - Jangan menggunakan clickbait.
                    - Ringkasan harus menarik dibaca.
                    - Hanya tampilkan hasil ringkasan.

                    Berita:
                ".strip_tags($isi);
        $response=Http::timeout(60)
            ->post(
                $this->url.'?key='.config('services.gemini.api_key'),
                [
                    'contents'=>[
                        [
                            'parts'=>[
                                [
                                    'text'=>$prompt
                                ]
                            ]
                        ]
                    ]
                ]
            );
        if(!$response->successful()){
            throw new \Exception('Gagal menghubungi Gemini.');
        }
        return data_get(
            $response->json(),
            'candidates.0.content.parts.0.text',
            ''
        );
    }
}