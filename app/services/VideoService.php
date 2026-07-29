<?php

namespace App\Services;

use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VideoService
{
    public function buatSlug($judul, $idVideo = null)
    {
        $slug = Str::slug($judul);
        $originalSlug = $slug;
        $i = 1;

        while (
            Video::where('slug', $slug)
                ->when($idVideo, function ($q) use ($idVideo) {
                    $q->where('id_video', '!=', $idVideo);
                })
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $i;
            $i++;
        }

        return $slug;
    }

    public function buatYoutubeId($url)
    {
        if (blank($url)) {
            return null;
        }

        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/';
        if (preg_match($pattern, trim($url), $matches)) {
            return $matches[1];
        }

        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', trim($url))) {
            return trim($url);
        }

        return null;
    }

    public function saveDraft($idVideo, $data)
    {
        if (isset($data['url_youtube'])) {
            $data['youtube_id'] = $this->buatYoutubeId($data['url_youtube']);
            unset($data['url_youtube']);
        }

        if (!empty($data['judul'])) {
            $data['slug'] = $this->buatSlug($data['judul'], $idVideo);
        }

        if (!$idVideo) {
            $data['status'] = $data['status'] ?? 0;
            $data['view_count'] = 0;
            $data['id_user'] = Auth::id();
        }

        if ($idVideo) {
            $video = Video::findOrFail($idVideo);
            $video->update($data);
        } else {
            $video = Video::create($data);
        }

        return $video;
    }

    public function publish($idVideo, $status)
    {
        return Video::where('id_video', $idVideo)
            ->update([
                'status' => $status
            ]);
    }

    public function load($idVideo)
    {
        return Video::findOrFail($idVideo);
    }

    public function hapus($idVideo)
    {
        $video = $this->load($idVideo);
        return $video->delete();
    }

    public function getPaginatedData($search = '', $perPage = 10)
    {
        return Video::with(['kategori', 'user'])
            ->when($search, function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%');
            })
            ->orderByDesc('id_video')
            ->paginate($perPage);
    }
}
